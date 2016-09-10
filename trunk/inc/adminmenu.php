<?php
	/**
	 * Created by PhpStorm.
	 * User: hiweb
	 * Date: 09.08.2016
	 * Time: 10:27
	 */


	add_action('admin_menu','_hw_io_add_submenu_page');
	function _hw_io_add_submenu_page(){
		add_submenu_page('tools.php', 'Images Auto-Re-Orient', 'hiWeb Images ReOrient', 'upload_files', 'hw-image-orient-tool', '_hw_io_tool_template');
	}