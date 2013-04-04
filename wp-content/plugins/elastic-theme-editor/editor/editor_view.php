<div id="toolbar">
	<ul>
		<li id="tb-save" class="button-primary">Save Theme</li>
		<li id="tb-instructions" class="button-secondary">Instructions</li>
		<li id="tb-canvas-settings" class="button-secondary">Canvas Settings</li>
	</ul>
	
	<div id="dialogs" class="hide">
		
		<div id="dialog-inspector">
			<div id="tabs-inspector">
				<ul>
					<li><a href="#ir-load"></a></li>
					<li><a href="#ir-save"></a></li>
					<li><a href="#ir-new"></a></li>
					<li><a href="#ir-instructions"></a></li>
					<li><a href="#ir-module"></a></li>
				</ul>
				
				
				<div id="ir-load">
					<form id="ir-load-form">
						<select id="ir-load-select" class="el-select"></select>
						<button id="ir-load-button-load" class="el-button ui-state-default ui-corner-all" type="button">Load Theme</button>
						<button id="ir-load-button-new" class="el-button ui-state-default ui-corner-all" type="button">New Theme</button>
					</form>
				</div>
				
				<div id="ir-save">
					<form id="ir-save-form">
						<span>Theme Name:</span>
						<input id="ir-save-input" class="el-input" type="text" size="11" autocomplete="off"></input>
						<button id="ir-save-button" class="el-button ui-state-default ui-corner-all" type="button">Save Theme</button>
					</form>
				</div>
				
				<div id="ir-new">
					<form id="ir-new-form">
						<table>
							<tr>
								<td>Column Count</td>
								<td><input value="24" type="text" id="ir-new-cc" size="3" /></td>
							</tr>
							<tr>
								<td>Column Width</td>
								<td><input value="30" type="text" id="ir-new-cw" size="3" /></td>
								</tr>
							<tr>
								<td>Gutter Width</td>
								<td><input value="10" type="text" id="ir-new-gw" size="3" /></td>
							</tr>
							<tr>
								<td>Page Width</td>
								<td><input value="950" type="text" id="ir-new-pw" disabled="disabled" size="3" /></td>
							</tr>
						</table>
						<!--<span>Column Count</span> <input type="text" id="column_count" size="3" />
						<span>Column Width</span> <input type="text" id="column_width" size="3" />
						<span>Gutter Width</span> <input type="text" id="gutter_width" size="3" /><br />
						<span>Page Width</span> <input type="text" id="page_width" disabled="disabled" size="3" /><br />
						-->
						<button id="ir-new-button" class="el-button ui-state-default ui-corner-all" type="button">New Theme</button>
						<div><em>Suggested grids:</em>
							<select id="ir-new-select" class="el-select">
								<optgroup label="B l u e p r i n t">
									<option value="24,30,10">950px: 24 column</option>
								</optgroup>
								<optgroup label="9 6 0 g s">
									<option value="16,40,20">940px: 16 column</option>
									<option value="12,60,20">940px: 12 column</option>
								</optgroup>
								<optgroup label="O t h e r s">
									<option value="16,50,10">950px: 16 column</option>
									<option value="18,44,10">962px: 18 column</option>
									<option value="15,40,10">740px: 15 column</option>
									<option value="16,37,10">758px: 16 column</option>
									<option value="18,32,10">746px: 18 column</option>
								</optgroup>
							</select>
						</div>
					</form>
				</div>
				
				<div id="ir-instructions">
					<p>This is the inspector. It's your new best friend.</p>
					
					<p><strong>Click on the canvas</strong> to add a new block.<br />
					You can <strong>drag the block around</strong>,<br />
					or <strong>resize it</strong> to your heart's content.</p>
					
					<p><strong>Click on the block</strong> to edit it in the inspector,<br />
					and <strong>delete it</strong> if it's not to your liking.</p>
					
					<p>But be careful!<br />
					<strong>If your blocks turn red, we can't draw that layout.</strong><br />
					Manipulate the blocks until the red goes away.</p>
				</div>
				
				<div id="ir-module">
					<ul>
						<li><a href="#mod-label">Type</a></li>
						<li><a href="#mod-typo">Typography</a></li>
					</ul>
					<div id="mod-label">
						<form id="mod-label-form" autocomplete="off">
							<span>Type:</span>
							<select id="mod-label-type" class="el-select" autocomplete="off">
								<option value="sidebar">Sidebar</option>
								<option value="header">Header</option>
								<option value="content">Content</option>
								<option value="footer">Footer</option>
							</select>
							<span id="mod-label-name-span">
								<span>Name:</span>
								<input id="mod-label-name" class="el-input" type="text" size="11" autocomplete="off"></input>
							</span>
							<div>
								<span>CSS Id:</span>
								<input id="mod-label-id" class="el-input" type="text" size="11" autocomplete="off" disabled="disabled"></input>
							</div>
						</form>
					</div>
					<div id="mod-typo" class="ir-custom-width">
						<div id="mod-typo-info">
							<div id="mod-typo-title">
								<span>Preview:</span>
								<button id="mod-typo-reset" class="el-button ui-state-default ui-corner-all">Reset</button>
							</div>
							<div id="mod-typo-preview" class="ui-corner-all">
								<div><textarea>The quick brown fox jumped over a lazy dog.</textarea></div>
								<span id="mod-typo-preview-options" class="ui-state-disabled">
									<select class="el-select">
										<option>Default Text</option>
									</select>
								</span>
							</div>
							<div id="mod-typo-font">
								<span><strong>Font:</strong></span> <select id="mod-typo-font-select" class="el-select">
								</select>
								<input id="mod-typo-font-input" class="el-input hide"></input>
								<button id="mod-typo-font-toggle" class="el-button ui-state-default ui-corner-all" value="Font List">Custom Font</button>
							</div>

							<div id="mod-typo-primary">
								<span>Size:</span> <input id="mod-typo-size" class="el-input el-input-pixel"></input>
								<span>Text Color: #</span> <input id="mod-typo-color-text" class="el-input el-input-color"></input>
								<span>Background: #</span> <input id="mod-typo-color-background" class="el-input el-input-color"></input>

							</div>

							<div id="mod-typo-secondary">
								<div id="mod-typo-toolbar" class="el-toolbar ui-widget-header ui-corner-all ui-helper-clearfix">
									<div class="el-buttonset el-buttonset-multi">
										<button id="mod-typo-b" class="el-button ui-state-default ui-corner-left">
											<b>B</b>
										</button>
										<button id="mod-typo-i" class="el-button ui-state-default">
											<i>I</i>
										</button>
										<button id="mod-typo-u" class="el-button ui-state-default ui-corner-right">
											<u>U</u>
										</button>
									</div>
									<div id="mod-typo-caps" class="el-buttonset el-buttonset-single">
										<button id="mod-typo-caps-normal" class="el-button ui-state-default ui-corner-left ui-state-active">
											Ab
										</button>
										<button id="mod-typo-caps-all" class="el-button ui-state-default">
											Ab
										</button>
										<button id="mod-typo-caps-small" class="el-button ui-state-default ui-corner-right">
											Ab
										</button>
									</div>
									<div id="mod-typo-align" class="el-buttonset el-buttonset-single el-toolbar-last">
										<button id="mod-typo-align-left" class="el-button ui-state-default ui-corner-left ui-state-active">
											L
										</button>
										<button id="mod-typo-align-center" class="el-button ui-state-default">
											C
										</button>
										<button id="mod-typo-align-right" class="el-button ui-state-default">
											R
										</button>
										<button id="mod-typo-align-justify" class="el-button ui-state-default ui-corner-right">
											J
										</button>
									</div>
								</div>
								<div id="mod-typo-spacing">
									<table class="mod-typo-table">
										<tr>
											<td>line-height</td>
											<td>letter-spacing</td>
											<td>word-spacing</td>
										</tr>
										<tr>
											<td><input id="mod-typo-spacing-line" class="el-input el-input-pixel"></input></td>
											<td><input id="mod-typo-spacing-letter" class="el-input el-input-pixel"></input></td>
											<td><input id="mod-typo-spacing-word" class="el-input el-input-pixel"></input></td>
										</tr>
									</table>
									<!--<span>line-height:</span> <input id="mod-typo-spacing-line" class="el-input el-input-pixel"></input>
									<span>letter-spacing:</span> <input id="mod-typo-spacing-letter" class="el-input el-input-pixel"></input>
									<span>word-spacing:</span> <input id="mod-typo-spacing-word" class="el-input el-input-pixel"></input>
									-->
								</div>
							</div>
						</div><!-- Close typog info panel-->						
						<div id="mod-typo-samples-panel">
							<button class="el-button el-button-icon-solo ui-state-default ui-corner-all mod-typo-samples-scroll">
								<span class="ui-icon ui-icon-carat-1-n"></span>Scroll Up
							</button>
							<div id="mod-typo-samples">
								<ul>
								</ul>
							</div>
							<button class="el-button el-button-icon-solo ui-state-default ui-corner-all mod-typo-samples-scroll">
								<span class="ui-icon ui-icon-carat-1-s"></span>Scroll Down
							</button>
						</div>
					</div><!--Close typography panel -->
					
				</div><!--Close #ir-module -->
			</div><!--Close #tabs-inspector -->
		</div><!--Close #dialog-inspector -->
		
		<div id="dialog-overlay"></div>
		
		<div id="dialog-neworload">
			Load the layout from your Elastic theme, or create a new layout?
		</div>
		
		
		<form id="dialog-changegrid" class="" action="">
			<em>Some suggested grids:</em><br /><br />
			<strong>960px</strong> : [24, 30, 10]<br />
			<strong>960px</strong> : [16, 50, 10]<br />
			<strong>972px</strong> : [18, 44, 10]<br /><br />
			<strong>750px</strong> : [15, 40, 10]<br />
			<strong>752px</strong> : [16, 37, 10]<br />
			<strong>756px</strong> : [18, 32, 10]<br />
			
				<br />
			Column Count <input type="text" id="column_count" size="3" /><br />
			Column Width <input type="text" id="column_width" size="3" /><br />
			Gutter Width <input type="text" id="gutter_width" size="3" /><br />
			Page Width <input type="text" id="page_width" disabled="disabled" size="3" /><br />
			<!--<input type="submit" id="submit" />-->
		</form>
		
		<div id="dialog-generate-output">
			This plugin will OVERWRITE parts of your Elastic theme!<br /><br />
			<input id="generate-output-warn-again" type="checkbox" /> Don't show again.
		</div>
		
		<div id="dialog-instructions">
			<p><strong>Click on the canvas</strong> to add a new block.<br />
			You can <strong>drag the block around</strong>,<br />
			or <strong>resize it</strong> to your heart's content.<br />
			<strong>Double click on the block</strong> to give it a type,<br />
			and <strong>delete it</strong> if it's not to your liking.</p>
			<p>But be careful!<br />
			<strong>If your blocks turn red, we can't draw that layout.</strong><br />
			Manipulate the blocks until the red goes away.</p>
		</div>
		
	</div>
</div>
<div class="container ui-corner-all" id="editor">
</div>