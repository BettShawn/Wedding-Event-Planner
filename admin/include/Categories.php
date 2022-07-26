<?php

class Category extends DB_Object
{
    protected static $db_table = "tblweddingcategories";
    protected static $db_table_fields = array(
        'id',
        'wedding_type',
        'price',
        'preview_image'
    );

    public $id;
    public $wedding_type;
    public $price;
    public $preview_image;


    public $upload_directory = "upload/categories";
    public $image_placeholder = "http://placehold.it/300x300&text=images";
    public $errors = array();

    public $upload_errors_array = array(
    UPLOAD_ERR_OK         => "There is no error",
    UPLOAD_ERR_INI_SIZE   => "The uploaded file exceeds the upload_max_filesize disc",
    UPLOAD_ERR_FORM_SIZE  => "The uploaded file exceeds the MAX_FILE_SIZE directives",
    UPLOAD_ERR_PARTIAL    => "The uploaded file was only partially uploaded.",
    UPLOAD_ERR_NO_FILE    => "No file was uploaded",
    UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
    UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
    UPLOAD_ERR_EXTENSION  => "A PHP extension stopped the file upload."
    );

    public function set_file($file)
    {
        if(empty($file) || !$file || !is_array($file))
        {
           
            $this->errors[] = "There was no file uploaded here";
            return false;
        } elseif($file['error'] != 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->preview_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    // saving image
    public function save_image()
    {
            if(!empty($this->errors))
            {
                return false;
            }

            if(empty($this->preview_image) || empty($this->tmp_path))
            {
                $this->errors[] = "The file was not available";
                return false;
            }
            
            $target_path =  SITE_ROOT . DS .  $this->upload_directory . DS . $this->preview_image;
                     
            if(file_exists($target_path))
            {
                $this->errors[] = "The file {$this->preview_image} already exists";
                return false;
            }

            if(move_uploaded_file($this->tmp_path, $target_path))
            {
                unset($this->tmp_path);
                return true;
            } else {
                $this->errors[] = "The File directory probably does not have permession";
                return false;
            }
    }
    public function preview_image_picture() {
        return empty($this->preview_image) ? $this->image_placeholder : $this->upload_directory. '/' .$this->preview_image;
    }
    
    public function picture_path() {
        return $this->upload_directory . '/' . $this->filename;
    }


    public function delete_photo() {
        if($this->delete()) {
            $target_path = SITE_ROOT.DS.$this->upload_directory.DS.$this->preview_image;
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }
    
}

?>


