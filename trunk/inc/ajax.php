<?php
	/**
	 * Created by PhpStorm.
	 * User: hiweb
	 * Date: 09.08.2016
	 * Time: 11:41
	 */


	add_action( 'wp_ajax_hiweb_image_orient', '_hw_io_ajax' );
	add_action( 'wp_ajax_nopriv_hiweb_image_orient', '_hw_io_ajax' );