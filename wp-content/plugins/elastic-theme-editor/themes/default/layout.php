<?php
$layout = new Group("group-1", array(
	new Group("group-2", array(
		new Header(),
		new Group("group-3", array(
			new Content(),
			new Sidebar("sidebar-2"),
			new Sidebar("sidebar-3"),
		)),
		new Group("group-4", array(
			new Group("group-5", array(
				new Sidebar("sidebar-1"),
				new Group("group-6", array(
					new Sidebar("sidebar-5"),
					new Sidebar("sidebar-4"),
				)),
			)),
		)),
		new Sidebar("footer"),
	)),
));
?>