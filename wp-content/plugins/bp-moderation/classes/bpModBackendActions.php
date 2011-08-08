<?php

/**
 * Handle backend actions
 */
class bpModBackendActions extends bpModeration {

	function __construct() {

		parent::__construct();
		
		add_action('admin_init',array(&$this,'route_action'));
	}

	function route_action(){
		$nonce_action = $_REQUEST['bpmod-action'];
		$action = $_REQUEST['bpmod-action'];
		if( 'bulk_contents' == $_REQUEST['bpmod-action'] || 'bulk_users' == $_REQUEST['bpmod-action'] )
			$action .= '_'.$_REQUEST['bulk-action'];

		$in_ajax = defined('DOING_AJAX');

		if( $in_ajax ){
			check_ajax_referer($nonce_action);
			$response_func  = array(&$this,'ajax_'.$action);
		}else{
			check_admin_referer($nonce_action);
			$response_func  = array(&$this,'action_'.$action);
			$this->redir = remove_query_arg( array('err_ids','marked_spammer','unmarked_spammer','content_ignored','content_moderated','content_deleted'), wp_get_referer() );
		}
		
		$handle_func = array(&$this,'handle_'.$action);
		$response_func  = array(&$this,($in_ajax?'ajax_':'action_').$action);

		if( is_callable($handle_func) ){
			$result = (array)call_user_func($handle_func);

			if( $result && is_callable($response_func) )
				call_user_func_array($response_func, $result);
		}
		
		//fallback if nothing has been called
		if( $in_ajax ){
			die(-1);
		}else{
			bp_core_redirect( $this->redir );
		}
	}


/**** mark/unmark spammer *****************************************************/
	function handle_mark_unmark_spammer() {
		if( empty($_REQUEST['user_id']) || !isset($_REQUEST['set_spam']) )
			return false;

		$this->set_spammer_status($_REQUEST['user_id'],$_REQUEST['set_spam'], array(&$this,(defined('DOING_AJAX')?'ajax_':'action_').'mark_unmark_spammer') );
	}

	function handle_bulk_contents_mark_spammer(){
		$this->handle_bulk_contents_mark_unmark_spammer(true);
	}

	function handle_bulk_contents_unmark_spammer(){
		$this->handle_bulk_contents_mark_unmark_spammer(false);
	}

	function handle_bulk_contents_mark_unmark_spammer($set_spam){
		$authors = $this->get_content_authors(@$_REQUEST['bulk_items']);

		$this->set_spammer_status($authors, $set_spam, array(&$this,'action_mark_unmark_spammer') );
	}

	function handle_bulk_users_mark_spammer(){
		$this->handle_bulk_users_mark_unmark_spammer(true);
	}

	function handle_bulk_users_unmark_spammer(){
		$this->handle_bulk_users_mark_unmark_spammer(false);
	}

	function handle_bulk_users_mark_unmark_spammer($set_spam){
		$user_ids = array_filter(array_map('intval',(array)@$_REQUEST['bulk_items']));

		$this->set_spammer_status($user_ids, $set_spam, array(&$this,'action_mark_unmark_spammer') );
	}

	function action_mark_unmark_spammer($successes,$errors,$is_spam){
		$query_arg = $is_spam ? 'marked_spammer' : 'unmarked_spammer';
		$arg_value = count($successes);

		if( 1==$arg_value ){ //with only one is nicer to display the name
			$username = bp_core_get_username($successes[0]);
			if(is_numeric($username))
				$username = "username:$username";
			$arg_value = empty($successes[0]) ? 0 : $username;
		}
		$args = array($query_arg => $arg_value);
		if (!empty($errors))
			$args['err_ids'] = join(',',$errors);

		bp_core_redirect( add_query_arg( $args, $this->redir ));
	}

	/*function ajax_mark_unmark_spammer($success,$error,$is_spam){
		if(!$uid)
			die(-1);
		else
			die(json_encode(array()));
	}*/

	/**
	 * BP doesn't have a core function for setting spammer status, this is a workaround
	 * for using bp_core_action_set_spammer_status() that is intended as an action function
	 * this is recursive through the hook bp_core_action_set_spammer_status
	 *
	 * @param <int|array> $user_ids member ids
	 * @param <bool> $set_spam mark spammer (true) or unmark (false)
	 * @param <callback> $end_callback function to execute after marking/unmarking, after this bpcore will redirect back & die
	 */
	function set_spammer_status() {
		global $bp;

		static $user_ids = null;
		static $set_spam = null;
		static $end_callback = null;
		static $successes = array();
		static $errors = array();

		//first recursion
		if (null === $user_ids){
			if(3 != func_num_args())
				return;
			$user_ids = (array)func_get_arg(0);
			$set_spam = (int)func_get_arg(1);
			$end_callback = func_get_arg(2);

			$_REQUEST['_wpnonce'] = wp_create_nonce('mark-unmark-spammer');

			$bp->current_component = 'admin';

			if($set_spam)
				$bp->current_action = 'mark-spammer';
			else
				$bp->current_action = 'unmark-spammer';

			//make it call this method again and again before die
			add_action('bp_core_action_set_spammer_status',array(&$this,__FUNCTION__),10,2);

		//other recursions: called from the hook
		}else{
			if ('invalid user_id' === func_get_arg(1) || (bp_core_is_user_spammer( func_get_arg(0) ) XOR $set_spam) )
				$errors[] = func_get_arg(0);
			else
				$successes[] = func_get_arg(0);
		}

		if( empty($user_ids) ){
			call_user_func($end_callback,$successes,$errors,$set_spam);
			return;
		}

		$uid = array_shift($user_ids);
		
		if ( bp_core_get_core_userdata( (int)$uid ) && $bp->loggedin_user->id!=(int)$uid ) {
			$bp->displayed_user->id = (int)$uid;
			bp_core_action_set_spammer_status();
		}else
			call_user_func(array(&$this,__FUNCTION__), $uid, 'invalid user_id');
	}


/**** ignore content **********************************************************/
	function handle_ignore( $cont_id = null){
		return $this->change_content_status('ignored',$cont_id);
	}

	function action_ignore($result){
		bp_core_redirect( add_query_arg( 'content_ignored', (int)$result , $this->redir ));
	}

	function handle_bulk_contents_ignore(){
		$this->bulk_loop_callback(array(&$this,'handle_ignore'),'content_ignored');
	}


/**** mark content moderated **************************************************/
	function handle_mark_moderated( $cont_id = null){
		return $this->change_content_status('moderated',$cont_id);
	}

	function action_mark_moderated($result){
		bp_core_redirect( add_query_arg( 'content_moderated', (int)$result , $this->redir ));
	}

	function handle_bulk_contents_mark_moderated(){
		$this->bulk_loop_callback(array(&$this,'handle_mark_moderated'),'content_moderated');
	}

/**** edit redirect ***********************************************************/
	function handle_edit(){
		if( empty($_REQUEST['cont_id']) )
			return false;

		bpModLoader::load_class('bpModObjContent');
		$cont = new bpModObjContent($_REQUEST['cont_id']);
		if ( !$cont->content_id || !is_callable($this->content_types[$cont->item_type]->callbacks['edit']))
			return false;

		$edit_cb = $this->content_types[$cont->item_type]->callbacks['edit'];

		return call_user_func($edit_cb, $cont->item_id, $cont->item_id2);
	}

	function action_edit($result){
		if($result)
			bp_core_redirect( $result );
		else
			bp_core_redirect( $this->redir );
	}

/**** delete content **********************************************************/
	function handle_delete( $cont_id = null){
		if( !$cont_id && !($cont_id = @$_REQUEST['cont_id']) )
			return false;

		bpModLoader::load_class('bpModObjContent');
		$cont = new bpModObjContent($cont_id);
		if ( !$cont->content_id || !is_callable($this->content_types[$cont->item_type]->callbacks['delete']))
			return false;

		$delete_cb = $this->content_types[$cont->item_type]->callbacks['delete'];
		
		if ( !call_user_func($delete_cb, $cont->item_id, $cont->item_id2) )
			return false;

		$old_status = $cont->status;

		$cont->status = 'deleted';
		
		if( ! $cont->save() )
			return false;

		do_action('bp_moderation_content_deleted', $cont->content_id, $cont);
		do_action('bp_moderation_content_status_changed', $cont->content_id, $old_status, 'deleted', $cont->item_author, $this->get_content_reporters($cont->content_id));

		return true;
	}

	function action_delete($result){
		bp_core_redirect( add_query_arg( 'content_deleted', (int)$result , $this->redir ));
	}

	function handle_bulk_contents_delete(){
		$this->bulk_loop_callback(array(&$this,'handle_delete'),'content_deleted');
	}


/**** enable/disable hotkeys **************************************************/
	function handle_hotkeys(){
		update_user_option( get_current_user_id(), 'bp_moderation_hotkeys', $_REQUEST['set_hotkeys'], true );

		bp_core_redirect( $this->redir );
	}

/**** commons/utils ***********************************************************/
	function change_content_status( $new_status, $cont_id = null){
		if( !$cont_id && !($cont_id = @$_REQUEST['cont_id']) )
			return false;

		bpModLoader::load_class('bpModObjContent');
		$cont = new bpModObjContent($cont_id);
		if ( !$cont->content_id)
			return false;

		if($new_status == $cont->status)
			return true;

		$old_status = $cont->status;
		$cont->status = $new_status;
		if( !$cont->save() )
			return false;

		$reporters = $this->get_content_reporters($cont->content_id);

		do_action("bp_moderation_content_$new_status", $cont->content_id, $cont, $reporters);
		do_action('bp_moderation_content_status_changed',$cont->content_id, $old_status, $new_status, $cont->item_author, $reporters, $cont);

		return true;
	}

	function bulk_loop_callback($callback,$successes_query_arg){
		$cont_ids = array_filter(array_map('intval',(array)@$_REQUEST['bulk_items']));
		$successes = 0;
		$errors = array();

		foreach ($cont_ids as $cid){
			if( call_user_func($callback,$cid) )
				$successes++;
			else
				$errors[] = $cid;
		}

		$args = array($successes_query_arg => $successes);
		if (!empty($errors))
			$args['err_ids'] = join(',',$errors);

		bp_core_redirect( add_query_arg( $args, $this->redir ));
	}


	function get_content_reporters($cont_id){
		global $wpdb;

		$cont_id = (int)$cont_id;
		if(!$cont_id)
			return array();

		$sql = "SELECT DISTINCT f.reporter_id FROM {$this->contents_table} c NATURAL JOIN {$this->flags_table} f WHERE c.content_id = $cont_id";

		return $wpdb->get_col( $sql );
	}
	function get_content_authors($cont_ids){
		global $wpdb;

		$cont_ids = implode(',',array_filter(array_map('intval',(array)$cont_ids)));
		if(!$cont_ids)
			return array();

		$sql = "SELECT DISTINCT item_author FROM {$this->contents_table} WHERE content_id IN ($cont_ids)";

		return $wpdb->get_col( $sql );
	}
}

?>
