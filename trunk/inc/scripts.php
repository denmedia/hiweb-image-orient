<?php
	/**
	 * Created by PhpStorm.
	 * User: hiweb
	 * Date: 09.08.2016
	 * Time: 11:27
	 */

	add_action('admin_enqueue_scripts','_hw_io_wp_enqueue_scripts');
	////
	function _hw_io_wp_enqueue_scripts(){
		wp_register_style('hw-io-backend', HW_IO_URL_CSS . '/backend.css');
		wp_enqueue_style('hw-io-backend');
		wp_register_script('hw-io-tool', HW_IO_URL_JS . '/hw-io-tool.js');
		wp_enqueue_script('hw-io-tool');
	}
