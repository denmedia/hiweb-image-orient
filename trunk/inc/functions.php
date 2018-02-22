<?php
	/**
	 * Created by PhpStorm.
	 * User: hiweb
	 * Date: 09.08.2016
	 * Time: 9:25
	 */


	function _hw_io_hook_wp_handle_upload_prefilter($file) {
		if (isset($file['type']) && $file['type'] == 'image/jpeg') {
			$exif_data = exif_read_data($file['tmp_name']);
			foreach ($exif_data as $key => $data) {
				if (strtolower($key) == 'orientation') {
					_hw_io_apply_orientation($file['tmp_name'], $data, $exif_data);
				}
			}
		}
		return $file;
	}


	function _hw_io_apply_orientation($filePath, $orientation = 0, $exifData = array()) {
		$orientToDegree = array(
			3 => 180,
			6 => 90,
			8 => 270
		);
		///
		if (!isset($orientToDegree[$orientation])) return false;
		///
		$img = imagecreatefromjpeg($filePath);
		$img = imagerotate($img, $orientToDegree[$orientation], 0);
		return imagejpeg($img, $filePath);
	}


	function _hw_io_rotateImage($img, $rotation) {
		$width = imagesx($img);
		$height = imagesy($img);
		switch ($rotation) {
			case 90:
				$newimg = @imagecreatetruecolor($height, $width);
				break;
			case 180:
				$newimg = @imagecreatetruecolor($width, $height);
				break;
			case 270:
				$newimg = @imagecreatetruecolor($height, $width);
				break;
			case 0:
				return $img;
				break;
			case 360:
				return $img;
				break;
		}
		if ($newimg) {
			for ($i = 0; $i < $width; $i++) {
				for ($j = 0; $j < $height; $j++) {
					$reference = imagecolorat($img, $i, $j);
					switch ($rotation) {
						case 90:
							if (!@imagesetpixel($newimg, ($height - 1) - $j, $i, $reference)) {
								return false;
							}
							break;
						case 180:
							if (!@imagesetpixel($newimg, $i, ($height - 1) - $j, $reference)) {
								return false;
							}
							break;
						case 270:
							if (!@imagesetpixel($newimg, $j, $width - $i, $reference)) {
								return false;
							}
							break;
					}
				}
			}
			return $newimg;
		}
		return false;
	}


	function _hw_io_tool_template() {
		include HW_IO_DIR_TEMPLATE . '/_hw_io_tool_template.php';
	}


	function _hw_io_ajax() {
		$R = array();
		if ($_POST['do'] == 'reorient') {
			$image = _hw_io_getOrientFromImagePost($_POST['id'], false);
			$R[$image['post']->ID] = array('name' => $image['post']->post_title);
			if ($image !== false && $image['orientation'] != 0 && $image['orientation'] != 1) {
				$meta = get_post_meta($image['post']->ID,'_wp_attachment_metadata',true);
				if(is_array($image['meta']['sizes'])) foreach ($image['meta']['sizes'] as $sizeName => $item){
					$file = dirname($image['path']).'/'.$item['file'];
					$R[$image['post']->ID]['files'][$file] = _hw_io_apply_orientation($file, $image['meta']['image_meta']['orientation']);
				}
				$meta['image_meta']['orientation'] = 0;
				$R[$image['post']->ID]['update_post_meta'] = update_post_meta($image['post']->ID,'_wp_attachment_metadata',$meta);
			}
		}
		echo json_encode($R);
		die;
	}

	/**
	 * @param $postOrId
	 * @param bool $returnOnlyOrientation
	 * @return array|bool
	 */
	function _hw_io_getOrientFromImagePost($postOrId, $returnOnlyOrientation = true) {
		$post = get_post($postOrId);
		if (!$post instanceof WP_Post) return false;
		if ($post->post_type != 'attachment') return false;
		$metaData = wp_get_attachment_metadata($post->ID);
		if (!is_array($metaData) || !isset($metaData['image_meta']) || !isset($metaData['image_meta']['orientation'])) return false;
		$upload_dir_arr = wp_upload_dir();
		return $returnOnlyOrientation ? $metaData['image_meta']['orientation'] : array(
			'path' => $upload_dir_arr['basedir'] . '/' . $metaData['file'],
			'url' => $upload_dir_arr['baseurl'] . '/' . $metaData['file'],
			'post' => $post,
			'meta' => $metaData,
			'orientation' => $metaData['image_meta']['orientation']
		);
	}