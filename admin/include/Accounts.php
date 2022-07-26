<?php

class Accounts extends DB_Object
{
    protected static $db_table = "tblaccounts";
    protected static $db_table_fields = array(
        'user_id',
        'user_email',
        'user_password',
        'access_level'
    );

    public $user_id;
    public $user_email;
    public $user_password;
    public $access_level;

    public static function login_user($email, $password)
    {
        global $db;
        $email = $db->escape_string($email);
        $password = $db->escape_string($password);
        $password = md5($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE user_email = '{$email}' AND user_password='{$password}'";
        $the_result_array = self::find_by_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function email_exists($email) {
        global $db;
        $sql = "SELECT user_id FROM " . self::$db_table . " WHERE user_email = '$email'";
        $result = $db->query($sql);
        if(mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }
    }

}

?>


