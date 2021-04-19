<?php
class upload{
    public $tmp;
    public $src = "./uploads/";
    public $filename;
    public $uploadfiles;
    public $fileType;
    public $fileSize;

    public function setFunctionVal(){
        $this->filename = $_FILES['file']['name'];
        $this->tmp = $_FILES['file']['tmp_name'];
        $this->fileType = $_FILES['file']['type'];
        $this->fileSize = $_FILES['file']['size'];
        $this->uploadfiles = $this->src.basename($this->filename);
    }

    public function uploadFile(){
        if(move_uploaded_file($this->tmp,$this->uploadfiles)){
            return true;
        }
    }
}
