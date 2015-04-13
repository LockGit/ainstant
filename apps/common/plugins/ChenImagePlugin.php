<?php
namespace Chen\Plugins;

use \Phalcon\Mvc\User\Plugin;

/**
 * NotFoundPlugin
 *
 * Handles not-found controller/actions
 */
class ChenImagePlugin extends Plugin
{
	static public function test($value)
	{
		echo 'the input is '.$value;
	}

	/*
     * 根据指定的尺寸缩放图片，不关心原图比例
     */
    static public function thumbnail($path, $width, $height, $dstImgPath) {
        if (ImagePs::check ()) {
            $image = new ImagePs ( $path );
            $image->resize ( $width, $height );
            if ($image->save ()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /*
     * 自动根据指定的尺寸缩放图片,会根据原图长宽最小尺寸缩放，较长的一方会被裁剪
     */
    static public function autoThumbnail($path, $width, $height, $dstImgPath) {
        if (ImagePs::check ()) {
            $image = new ImagePs ();
            $imgWidth = $image->getWidth ();
            $imgHeight = $image->getHeight ();
            // 计算拉伸尺寸
            $widthRatio = $width / $imgWidth;
            $heightRatio = $height / $imgHeight;
            if ($widthRatio > $heightRatio) {
                $newWidth = $width;
                $newHeight = $imgHeight * $widthRatio;
            } else {
                $newHeight = $height;
                $newWidth = $imgWidth * $heightRatio;
            }
            // 最终裁剪
            $image->resize ( $newWidth, $newHeight );
            $image->crop ( $width, $height, ($newWidth - $width) / 2, ($newHeight - $height) / 2 );
            if ($image->save ( $dstImgPath )) {
                return true;
            } else {
                return false;
            }
        } else {
            return FALSE;
        }
    }
	
}
