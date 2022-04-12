<?php
	class abeManagement {
		function resizeImage($filepath, $desiredwidth, $desiredheight) {
			$imagesource = imagecreatefromjpeg($filepath);
			$sourcewidth = imagesx($imagesource);
			$sourceheight = imagesy($imagesource);
			if (imagesx($imagesource)>imagesy($imagesource)) {
				if ((($desiredheight * imagesx($imagesource)) / imagesy($imagesource))>=$desiredwidth) {
					$desiredwidth = ($desiredheight * imagesx($imagesource)) / imagesy($imagesource);
				} else {
					$desiredheight = ($desiredwidth * imagesy($imagesource)) / imagesx($imagesource);
				}
			} else {
				$desiredheight = ($desiredwidth*imagesy($imagesource))/imagesx($imagesource);
			}
			$imagedestination = imagecreatetruecolor($desiredwidth, $desiredheight);
			imagecopyresampled($imagedestination, $imagesource, 0, 0, 0, 0, $desiredwidth, $desiredheight, $sourcewidth, $sourceheight);
			imagejpeg($imagedestination,$filepath);
		}

		function cropImage($filepath, $cropwidth, $cropheight) {
			$imagesource = imagecreatefromjpeg($filepath);
			$sourcewidth = imagesx($imagesource);
			$sourceheight = imagesy($imagesource);
			$imagedestination = imagecreatetruecolor($cropwidth, $cropheight);
			imagecopy($imagedestination, $imagesource, 0, 0, 0, 0, $sourcewidth, $sourceheight);
			imagejpeg($imagedestination, $filepath);
		}

		function unlinkFile($filepath) {
			unlink($filepath);
		}
	}
?>