<?php 

namespace Apps\Core;

class Files{
    private $FileType = ["image/png","image/jpeg","image/jpg"];
    private $dir = "/var/www/html/appro_release_2/public/Assets/Images/users/";
    public function load($nameFile){
        if (isset($_FILES[$nameFile]) && $_FILES[$nameFile]['error'] === UPLOAD_ERR_OK) {
            if(in_array($_FILES[$nameFile]['type'], $this->FileType)){
                $photo_name = $_FILES[$nameFile]['name'];
                $photo_tmp_name = $_FILES[$nameFile]['tmp_name'];
                $photo_destination = $this->dir . $photo_name;
                move_uploaded_file($photo_tmp_name, $photo_destination);
            }
        }
    }

    public function getDir(){
        return $this->dir;
    }
    public function setDir($dir){
        $this->dir = $dir;
    }

    public function getFileType(){
        return $this->FileType;
    }
    public function setFileType($FileType){
        $this->FileType = $FileType;
    }
    
}


