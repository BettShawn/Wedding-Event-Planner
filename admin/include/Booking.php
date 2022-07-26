<?php

class Booking extends DB_Object
{
    protected static $db_table = "tblweddingbook";
    protected static $db_table_fields = array(
        'booking_id',
        'user_id',
        'bride',
        'groom',
        'wedding_type',
        'user_email',
        'wedding_date',
        'organizer_id'
    );

    public $booking_id;
    public $user_id;
    public $bride;
    public $groom;
    public $wedding_date;
    public $firstname;
    public $lastname;
    public $user_email;
    public $wedding_type;
    public $phone;
    public $organizer_id;

     public function check_wedding_date($date) {
        global $db;
        
        $sql = "SELECT * FROM " . self::$db_table . " WHERE wedding_date = '{$date}'";
        $result = $db->query($sql);

        if(mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }
    }


    public static function getBooking() {
        global $db;
        $sql = "SELECT * FROM tblaccounts_detail INNER JOIN tblweddingbook ON tblweddingbook.user_id = tblaccounts_detail.user_id WHERE tblaccounts_detail.status = 'pending' ORDER BY booking_id ASC";
        $result_set = $db->query($sql);

        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }
        return $the_object_array;
    }
     public static function ConfirmedBooking() {
        global $db;
        $sql = "SELECT * FROM tblaccounts_detail INNER JOIN tblweddingbook ON tblweddingbook.user_id = tblaccounts_detail.user_id WHERE tblaccounts_detail.status = 'confirm' ORDER BY booking_id ASC";
        $result_set = $db->query($sql);

        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }

        return $the_object_array;
    }
    public static function count_booking() {
        global $db;
        $sql = "SELECT count(booking_id) FROM ". self::$db_table;
        $result_count = $db->query($sql);
        $row = mysqli_fetch_array($result_count);
        return array_shift($row);
    }

}

?>


