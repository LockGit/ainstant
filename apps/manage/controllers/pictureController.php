<?php
namespace Chen\Manage\Controllers;

use \Phalcon\Mvc\Controller;
use \Phalcon\Mvc\View;
use \Phalcon\Image\Adapter\GD as ImageGD;
use \Phalcon\Image\Adapter\Imagick as ImageImagick;
use Chen\Models\Files;
use Chen\Plugins\ChenImagePlugin;

class PictureController extends Controller
{

	public function initialize()
    {
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

    public function imageViewAction($file_value)
    {
        
        $image = Files::findFirst(1);
        $thumbnail = $image->getThumbnail(720,405);

        //var_dump($thumbnail);
        //Header ('Content-type: image/jpg');

        //$file_path = APP_PATH.'/public'.$thumbnail;
        //$image2 = file_get_contents($file_path);
        //echo $image2;




        //  检查GD库是否安装
        print_r(extension_loaded('gd'));
        print_r(extension_loaded('Imagick'));
        //  检测是否存在某个函数
        //function_exists('imap_open');
        //echo $file_value;
        /*
        $width = $this->request->getQuery("width", "int");
        $height = $this->request->getQuery("height", "int");
        $quality = $this->request->getQuery("quality", "int");

        if (ImageGD::check()) {
            Header ('Content-type: image/jpg');
            $file_path = APP_PATH.'/public/upload/images/2015/03/56d9a21490fae2045000655ef3b1e038.720x405.jpg';
            //$image = new ImageGD($file_path);
            //$image->resize(720, 405);

            //echo $image->render();
            //return $file_path;
            
            //echo '123';
            $image = file_get_contents($file_path);
            echo $image;

        } else {
            return FALSE;
        }
        */

        



        // $picture = new ChenImagePlugin();

        // $picture->test('111111');

        //ChenImagePlugin::test('111111');






        // $height = 300;
        // $width = 300;
        //创建背景图
        // $im = ImageCreateTrueColor($width, $height);
        // //分配颜色
        // $white = ImageColorAllocate ($im, 255, 255, 255);
        // $blue = ImageColorAllocate ($im, 0, 0, 64);
        // //绘制颜色至图像中
        // ImageFill($im, 0, 0, $blue);
        // //绘制字符串：Hello,PHP
        // ImageString($im, 10, 100, 120, 'Hello,PHP', $white);
        // //输出图像，定义头
        // Header ('Content-type: image/png');
        // //将图像发送至浏览器
        // ImagePng($im);

        // //$this->view->im = $im;
        // //清除资源
        // ImageDestroy($im);
        
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