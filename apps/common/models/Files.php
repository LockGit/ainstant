<?php 
namespace Chen\Models;

use \Phalcon\Image\Adapter\GD as ImageGD;
use \Phalcon\Image\Adapter\Imagick as ImageImagick;

//类型
class Files extends \Phalcon\Mvc\Model
{
	/**
     * @var integer
     *      id
     */
    public $id;

    /**
     * @var string
     *		名称
     */
    public $file_name;

    /**
     * @var string
     *		途径
     */
    public $file_path;

    /**
     * @var string
     *		url
     */
    public $file_url;

    /**
     * @var string
     *      md5
     */
    public $file_md5;

    /**
     * @var string
     *      后缀
     */
    public $file_suffix;

    /**
     * @var int
     *      类型
     */
    public $file_type;

    /**
     * @var int
     *      上传时间
     */
    public $upload_time;

    /**
     * @var int
     *      大小
     */
    public $file_size;

    /**
     * @var int
     *      宽度
     */
    public $image_width;

    /**
     * @var int
     *      高度
     */
    public $image_height;

    public function beforeCreate()
    {
        $this->upload_time = time();
    }

    public function initialize()
    {
        $this->hasOne('id', 'Chen\Models\Posts', 'post_picture',array(
            'alias' => 'posts'
        ));
    }

    /**
     *  缩略图
     *  @ruturn string   
     */
    public function getThumbnail($width = 0, $height = 0) {
        if (empty($width) || empty($height)) {
            return $this->file_url;
        } else {
            $imageTempPath = APP_PATH.'/public';
            $imageTempUrl = '/upload/temp/'.$this->file_md5.'-'.$width.'x'.$height.'.'.$this->file_suffix;
            $imageTemp = $imageTempPath.$imageTempUrl;
            
            if (file_exists($imageTemp)) {
                return $imageTempUrl;
            } else {
                
                $imagePath = APP_PATH.'/public'.$this->file_url;
                               
                if (extension_loaded('Imagick')) {
                    $this->object = new ImageImagick($imagePath);
                } elseif (extension_loaded('gd')) {
                    $this->object = new ImageGD($imagePath);
                } else {
                    return false;
                }

                if (is_object($this->object)) {
                    //$image = new ImageGD($imagePath);
                    $imgWidth = $this->object->getWidth();
                    $imgHeight = $this->object->getHeight();
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
                    $this->object->resize ( $newWidth, $newHeight );
                    $this->object->crop ( $width, $height, ($newWidth - $width) / 2, ($newHeight - $height) / 2 );
                    if ($this->object->save($imageTemp,90)) {
                        return $imageTempUrl;
                    } else {
                        return $this->file_url;
                    }
                } else {
                    return false;
                }
            }
        }
    }

    public function uploadFiles($file)
    {
        $fileMd5 = md5_file($file);
        $flieName = $file->getName();
        //  获取文件后缀
        $fileSuffix = $this->fileSuffix($flieName);
        //  获取修改后的文件名(文件的 MD5 + 扩展名)
        $flieNameRevise = $fileMd5.'.'.$fileSuffix;
        //  获取文件类型
        //$fileType = $file->getRealType();
        //  获取文件大小(字节)
        $fileSize = $file->getSize();
        //  获取错误码
        $fileError = $file->getError();
        //  定义图片扩展名
        $imageSuffix = array('bmp','gif','jpeg','jpg','png');
                
        //  根据文件扩展名判断文件上传目录
        if ( in_array($fileSuffix, $imageSuffix)) {
            $fileCatalog = 'images';
            $fileTypeId = '1';
            $imageSize = getimagesize($file);
        } else {
            $fileCatalog = 'files';
            $fileTypeId = '2';
        }
        //  获取当前日期 (年/月)
        $currentDate = (string)date('Y/m');
        //  获取文件上传路径
        $filePath = APP_PATH.'/public/upload/'.$fileCatalog.'/'.$currentDate.'/';
        $filePathRelative = '/upload/'.$fileCatalog.'/'.$currentDate.'/';
        //  获取文件移动目录
        $movePath = $filePath.$flieNameRevise;
        //  获取文件url
        $fileUrl = '/upload/'.$fileCatalog.'/'.$currentDate.'/'.$flieNameRevise;
                
        //  检查目录是否存在，如果不存在就创建               
        if (!is_dir($filePath)) {
            if (!mkdir($filePath,0777,true)) {
                return 'error';
            }
        }
                
        $file_find = Files::findFirst(array("file_md5 = '$fileMd5'"));

        if ($file_find != false) {
            $fileUrl = $file_find->file_url;
        } else {
            $fileSave = new Files();
            $fileSave->file_name = $flieNameRevise;
            $fileSave->file_path = $filePathRelative;
            $fileSave->file_url = $fileUrl;
            $fileSave->file_md5 = $fileMd5;
            $fileSave->file_suffix = $fileSuffix;
            $fileSave->file_type = $fileTypeId;
            $fileSave->file_size = $fileSize;
                    
            if (!empty($imageSize)) {
                $fileSave->image_width = $imageSize['0'];
                $fileSave->image_height = $imageSize['1'];
            }
                    
            if ($fileSave->save() != false) {
                $file->moveTo($movePath);
            } else {
                return '['.$fileError.']';
            }
        }

        $fileInfo = array('movePath' => $movePath, 'fileUrl' => $fileUrl);
        return $fileInfo;
    }

    /*
    *   获取文件后缀
    *   2015-2-1
    */
    protected function fileSuffix($filename){
        //return strtolower(trim(substr(strrchr($filename, '.'), 1)));
        $suffix = strtolower(trim(substr(strrchr($filename, '.'), 1)));
        if ($suffix == ''){
            //  解决 simditor 编辑器粘贴图片无法获取文件扩展名的问题
            return 'png';
        } else {
            return $suffix;
        }
    }

    /*
    *   文件大小单位转换
    *   2015-2-1
    */
    protected function formatBytes($size) { 
        $units = array(' B', ' KB', ' MB', ' GB', ' TB'); 
        for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024; 
        return round($size, 2).$units[$i]; 
    }
      
     
}