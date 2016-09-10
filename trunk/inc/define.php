<?php
	/**
	 * Created by PhpStorm.
	 * User: hiweb
	 * Date: 09.08.2016
	 * Time: 9:30
	 */


	if (!defined('HW_IO_DIR')) define('HW_IO_DIR', dirname(dirname(__FILE__)));
	if (!defined('HW_IO_DIR_TEMPLATE')) define('HW_IO_DIR_TEMPLATE', HW_IO_DIR . '/template');
	if (!defined('HW_IO_URL')) define('HW_IO_URL', WP_PLUGIN_URL . '/' . basename(HW_IO_DIR));
	if (!defined('HW_IO_URL_CSS')) define('HW_IO_URL_CSS', WP_PLUGIN_URL . '/' . basename(HW_IO_DIR) . '/css');
	if (!defined('HW_IO_URL_JS')) define('HW_IO_URL_JS', WP_PLUGIN_URL . '/' . basename(HW_IO_DIR) . '/js');