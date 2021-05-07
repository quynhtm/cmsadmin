<?php
/*
* @Created by: QuynhTM
* @Author	 : manhquynh1984@gmail.com
* @Date 	 : 04/2019
* @Version	 : 1.0
*/
namespace App\Library\AdminFunction;

use App\Library\PHPZip\Zip;

class CZips{
    public function dirToArray($dir) {
        $result = array();
        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if(substr( $value, 0, 1 ) === ".") {
                continue;
            }
            if (!in_array($value,array(".","..",".DS_STORE"))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                }
                else {
                    $result[] = $value;
                }
            }
        }
        return $result;
    }
    //Using zipArchive class
    public function zipClss($data, $name='Archive.zip'){
        $zip = new Zip();
        $zip->zip_start($name);
        if(isset($data['directory'])){
            if(is_array($data['directory']) && !empty($data['directory'])){
                foreach($data['directory'] as $item){
                    if(is_dir($item)){
                        $zip->zip_add($item);
                    }
                }
            }else{
                if(is_dir($data['directory'])){
                    $zip->zip_add($data['directory']);
                }
            }
        }
        if(isset($data['arrFile']) && !empty($data['arrFile'])){
            $zip->zip_add($data['arrFile']);
        }
        if(isset($data['file']) && is_file($data['file'])){
            $zip->zip_add($data['file']);
        }
        $zip->zip_end(1);
    }
    //Using PclZip class
    public function zipPclZip($data, $name='Archive.zip'){
        $zip = new Zip();
        $zip->zip_start($name);
        if(isset($data['directory'])){
            if(is_array($data['directory']) && !empty($data['directory'])){
                foreach($data['directory'] as $item){
                    if(is_dir($item)){
                        $zip->zip_add($item);
                    }
                }
            }else{
                if(is_dir($data['directory'])){
                    $zip->zip_add($data['directory']);
                }
            }
        }
        if(isset($data['arrFile']) && !empty($data['arrFile'])){
            $zip->zip_add($data['arrFile']);
        }
        if(isset($data['file']) && is_file($data['file'])){
            $zip->zip_add($data['file']);
        }
        $zip->zip_end(2);
    }
    //Unzip
    public function unZip($pathZip='', $pathUnZip=''){
        if($pathZip != '' && is_file($pathZip) && $pathUnZip != '' && is_dir($pathUnZip)){
            $extract = new Zip();
            $extract->unzip_file($pathZip);
            $extract->unzip_to($pathUnZip);
        }
    }
    //Delete
    public function zDelete($data=array()){
        if(isset($data['directory'])){
            if(is_array($data['directory']) && !empty($data['directory'])){
                foreach($data['directory'] as $item){
                    if(is_dir($item)){
                        exec("rm -rf ".$item);
                    }
                }
            }else{
                if(is_dir($data['directory'])){
                    exec("rm -rf ".$data['directory']);
                }
            }
        }
        if(isset($data['file']) && is_file($data['file'])){
            unlink($data['file']);
        }
    }
}