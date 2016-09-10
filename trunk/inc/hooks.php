<?php
	/**
	 * Created by PhpStorm.
	 * User: hiweb
	 * Date: 09.08.2016
	 * Time: 9:35
	 */

	add_filter('wp_handle_upload_prefilter', '_hw_io_hook_wp_handle_upload_prefilter' );