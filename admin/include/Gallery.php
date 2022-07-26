<?php

class Gallery extends DB_Object
{
    protected static $db_table = "tblgallery";

    protected static $db_table_fields = array(
        'id',
        'booking_id',
        'title',
        'caption',
        'description',
        'filename',
        'alternate_text',
        'type',
        'size'
    );

    public $id;
    public $booking_id;
    public $title;
    public $caption;
    public $description;
    public $filename;
    public $alternate_text;
    public $type;
    public $size;

    public $tmp_path;
    public $upload_directory = "upload/gallery";
    public $image_placeholder = "http://placehold.it/64x64&text=images";
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
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }
    

    public function picture_path() {
        return empty($this->filename) ? $this->image_placeholder : $this->upload_directory. '/' .$this->filename;
    }

    // saving image
    public function save_image()
    {
            if(!empty($this->errors))
            {
                return false;
            }

            if(empty($this->filename) || empty($this->tmp_path))
            {
                $this->errors[] = "The file was not available";
                return false;
            }
            
            $target_path =  SITE_ROOT . DS .  $this->upload_directory . DS . $this->filename;
                     
            if(file_exists($target_path))
            {
                $this->errors[] = "The file {$this->filename} already exists";
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
    
    

    public function save() {

        if ($this->id) {

            $this->update();

        } else {

            if (!empty($this->errors)) {
                return false;
            }

            if (empty($this->filename) || empty($this->tmp_path)) {
                $this->errors[] = "The file was not available";
                return false;
            }

            $target_path = SITE_ROOT . '/'  . $this->upload_directory . '/' . $this->filename;

            if (file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists";
                return false;
            }

            if (move_uploaded_file($this->tmp_path, $target_path)) {
                if ($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }
                
            } else {
                $this->errors[] = "The File directory probably does not have permession";
                return false;
            }

        }

    }

    public function delete_photo()
    {
        if ($this->delete()) {
            $target_path = SITE_ROOT . '/' . $this->picture_path();
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }
}

?>