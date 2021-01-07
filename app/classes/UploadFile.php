<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 03/08/2018
 * Time: 3:28 PM
 */

namespace App\Classes;


use Symfony\Component\Debug\Tests\Fixtures2\RequiredTwice;

class UploadFile
{

    protected $_filename, $_maxFileSize = 500000, $_extension, $_path,$_optimisePath, $newWidth, $newHeight ;

    public function getFilename(){
        return $this->_filename;
    }

    public function setFilename($file, $name = ''){
        if($name === ''){
            //GET THE REAL FILENAME OF THE FILE
            $name = pathinfo($file, PATHINFO_FILENAME);
        }

        if ($name === 'profile_pic'){
            $name = strtolower(str_replace(['_', ' '], '-', $name));//REPLACE UNDERSCORES AND SPACES WITH A HYPHEN
            $ext = $this->getFileExtension($file);//GET THE FILE EXTENSION

            //THIS IS THE NEW FILE NAME
             $this->_filename = "{$name}.{$ext}";
        }else if ($name === 'id_card'){
            $name = strtolower(str_replace(['_', ' '], '-', $name));//REPLACE UNDERSCORES AND SPACES WITH A HYPHEN
            $ext = $this->getFileExtension($file);//GET THE FILE EXTENSION

            //THIS IS THE NEW FILE NAME
            $this->_filename = "{$name}.{$ext}";
        }else if ($name === 'cert'){
            $name = strtolower(str_replace(['_', ' '], '-', $name));//REPLACE UNDERSCORES AND SPACES WITH A HYPHEN
            $ext = $this->getFileExtension($file);//GET THE FILE EXTENSION

            //THIS IS THE NEW FILE NAME
            $this->_filename = "{$name}.{$ext}";
        }else{

            $name = strtolower(str_replace(['_', ' '], '-', $name));//REPLACE UNDERSCORES AND SPACES WITH A HYPHEN
            $hash = md5(microtime());//CREATE A HASH
            $ext = $this->getFileExtension($file);//GET THE FILE EXTENSION

            //THIS IS THE NEW FILE NAME
            $this->_filename = "{$name}-{$hash}.{$ext}";
        }


    }



    public function getFileExtension($file){
        return $this->_extension = pathinfo($file, PATHINFO_EXTENSION);//GET THE FILE EXTENSION
    }

    public static function fileSize($file){
        $fileobj = new static;
        return $file > $fileobj->_maxFileSize ? true: false;
    }


    public static function isImage($file){
        //VALIDATE FILE UPLOADED
        $fileobj = new static;
        $ext = $fileobj->getFileExtension($file);
        $validExt = array('jpg', 'jpeg', 'png', 'bmp');

        if(!in_array(strtolower($ext), $validExt)){
            return false;
        }
        return true;
    }


    public static function isDoc($file){
        //VALIDATE FILE UPLOADED
        $fileobj = new static;
        $ext = $fileobj->getFileExtension($file);
        $validExt = array('pdf', 'docx');

        if(!in_array(strtolower($ext), $validExt)){
            return false;
        }
        return true;
    }

    public function path(){
        return $this->_path;
    }

    public function optimisedPath(){
        return $this->_optimisePath;
    }

    public static function move($tmpLocation, $folder, $optimisedTo, $file, $newFilename ='' ){
        $fileobj = new static;

        $fileobj->setFilename($file, $newFilename);//SET NEW FILE NAME BEFORE MOVING THE FILE
        $filename = $fileobj->getFilename();

        //IF NO DIRECTORY EXIST, CREATE A NEW DIRECTORY
        if(!is_dir($folder)){
            mkdir($folder, 0775, true);
        }elseif (!is_dir($optimisedTo)){
            mkdir($optimisedTo, 0775, true);
        };

        $fileobj->_path = $folder.DS.$filename; //FILE PATH
        $destination = PROOT.'public'.DS.$fileobj->_path; //PERMANENT LOCATION OR DESTINATION OF THE FILE



        if(move_uploaded_file($tmpLocation, $destination)){
            $fileobj->_optimisePath = UploadFile::compressImage($destination, $optimisedTo, 75, $filename);
            return $fileobj;

        }

        return false;
    }


    public static function compressImage($sourceImage, $optmisedDestination, $quality, $filename){
        $imageInfo = getimagesize($sourceImage);
        $imageMime = $imageInfo['mime'];
        $obj = new UploadFile();
        $optimisedFile = $optmisedDestination.DS.$filename;



        switch ($imageMime){
            case 'image/jpeg':
            case 'image/JPEG':
            case 'image/JPG':
            case 'image/jpg':
                $image = imagecreatefromjpeg($sourceImage);
                $image = $obj->resize_image($sourceImage,$image,300, 400);
                imagejpeg($image, $optimisedFile, $quality);
                break;

            case 'image/png':
                $image = imagecreatefrompng($sourceImage);
                imagepng($image, $optimisedFile, $quality);
                break;

            case 'image/gif':
                $image = imagecreatefromgif($sourceImage);
                imagegif($image, $optimisedFile, $quality);
                break;

            default:
                return false;
        }

        return $optimisedFile;

    }

    public function resize_image($file, $src, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $this->newWidth= $h*$r;
                $this->newHeight = $h;
            } else {
                $this->newHeight = $w/$r;
                $this->newWidth = $w;
            }
        }
//        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($this->newWidth, $this->newHeight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height);

        return $dst;
    }


}
?>