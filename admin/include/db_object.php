<?php

class DB_Object
{

    public static function find_all() {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " ORDER BY id DESC");
    }

     public static function find_booking_all() {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " ORDER BY booking_id DESC");
    }
   
    public static function find_by_event_all($id) {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE booking_id = $id ORDER BY id DESC");
    }

    public static function find_by_id($id) {
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $id ORDER BY id DESC  LIMIT 1 ");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }


    public static function find_by_feature_all($id) {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE category_id = $id ORDER BY category_id DESC LIMIT 10");
    }

    public static function find_by_feature_all_a($id) {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE category_id = $id ORDER BY category_id DESC");
    }

    public static function find_by_feature_no_limit($id) {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE category_id = $id ORDER BY category_id DESC");
    }

    public static function find_by_feature_id($id) {
        $the_result_array =  static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE feature_id = $id");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_by_user_id($id) {
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE user_id = $id ORDER BY user_id DESC  LIMIT 1 ");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_by_booking_id($id) {
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE booking_id = $id ORDER BY booking_id DESC  LIMIT 1 ");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }


    public static function find_by_customer_id($id) {
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE customer_id = $id LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_by_query($sql) {
        global $db;
        $result_set = $db->query($sql);
        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }

        return $the_object_array;
    }

    public static function instantiation($the_record){
        $calling_class = get_called_class();
        $the_object = new $calling_class;
        foreach($the_record as $the_attribute => $value)
        {
            if($the_object->has_the_attribute($the_attribute)) {
                $the_object->$the_attribute = $value;
            }
        }
        return $the_object;
    }

    private function has_the_attribute($the_attribute) {
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);
    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function save_booking() {
        return isset($this->booking_id) ? $this->update_booking() : $this->create();
    }

    public function save_user() {
        return isset($this->user_id) ? $this->update_user() : $this->create();
    }

    public function save_account() {
        return isset($this->user_id) ? $this->update_user_account() : $this->create();
    }
    
    public function update_user_account() {
        global $db;
        $properties = $this->clean_properties();
        $properties_pairs = array();

        foreach($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE user_id = " . $db->escape_string($this->user_id);
        $db->query($sql);
        return (mysqli_affected_rows($db->connection) == 1) ? true : false;
    }

    public function update_user() {
        global $db;
        $properties = $this->clean_properties();
        $properties_pairs = array();

        foreach($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE user_id = " . $db->escape_string($this->user_id);
        $db->query($sql);
        return (mysqli_affected_rows($db->connection) == 1) ? true : false;
    }

    public function update_booking() {
        global $db;
        $properties = $this->clean_properties();
        $properties_pairs = array();

        foreach($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE booking_id = " . $db->escape_string($this->booking_id);
        $db->query($sql);
        return (mysqli_affected_rows($db->connection) == 1) ? true : false;
    }

    protected function properties() {
        // return get_object_vars($this);
        $properties = array();
        foreach (static::$db_table_fields as $db_field) {
            if(property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    protected function clean_properties() {
        global $db;
        $clean_properties = array();
        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $db->escape_string($value);
        }
        return $clean_properties;
    }

    public function create() {
        global $db;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ") ";
        $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

        if($db->query($sql)) {
            $this->id = $db->the_insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update_feature($id) {
        global $db;
        $properties = $this->clean_properties();
        $properties_pairs = array();

        foreach($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE feature_id = " . $db->escape_string($id);
        $db->query($sql);
        return (mysqli_affected_rows($db->connection) == 1) ? true : false;
    }

    public function update() {
        global $db;
        $properties = $this->clean_properties();
        $properties_pairs = array();

        foreach($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id = " . $db->escape_string($this->id);
        $db->query($sql);
        return (mysqli_affected_rows($db->connection) == 1) ? true : false;
    }

    public function delete() {
        global $db;
        $sql = "DELETE FROM " . static::$db_table . "";
        $sql .= " WHERE id=" . $db->escape_string($this->id);
        $sql .= " LIMIT 1";
        $db->query($sql);
        return (mysqli_affected_rows($db->connection) == 1) ? true : false;
    }
    public function delete_feature($id) {
        global $db;
        $sql = "DELETE FROM " . static::$db_table . "";
        $sql .= " WHERE feature_id=" . $db->escape_string($id);
        $sql .= " LIMIT 1";
        $db->query($sql);
        return (mysqli_affected_rows($db->connection) == 1) ? true : false;
    }

    public static function count_all()
    {
        global $db;
        $sql = "SELECT COUNT(*) FROM " .static::$db_table;
        $result_count = $db->query($sql);
        $row = mysqli_fetch_array($result_count);
        return array_shift($row);
    }
}
?>