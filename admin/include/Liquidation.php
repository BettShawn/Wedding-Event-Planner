<?php

class Liquidation extends DB_Object
{
    protected static $db_table = "tbl_liquidation";
    protected static $db_table_fields = array(
        'id',
        'event_id',
        'booking_id',
        'user_id',
        'payment',
        'cash',
        'credit',
        'date_modified',
        'date_issue'
    );

    public $id;
    public $event_id;
    public $booking_id;
    public $user_id;
    public $payment;
    public $cash;
    public $credit;
    public $date_issue;
    public $date_modified;
    public $title;

    public static function find_by_liquadate_all($id) {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE booking_id = $id ORDER BY booking_id DESC");
    }
    public static function getTotalAmount($id) {
        global $db;
        $sql = "SELECT SUM(payment) FROM " .static::$db_table." WHERE booking_id = $id";
        $result_count = $db->query($sql);
        $row = mysqli_fetch_array($result_count);
        return array_shift($row);
    }
    public static function getTotalAmountCash($id) {
        global $db;
        $sql = "SELECT SUM(cash) FROM " .static::$db_table." WHERE booking_id = $id";
        $result_count = $db->query($sql);
        $row = mysqli_fetch_array($result_count);
        return array_shift($row);
    }
    public static function getTotalAmountCredit($id) {
        global $db;
        $sql = "SELECT SUM(credit) FROM " .static::$db_table." WHERE booking_id = $id";
        $result_count = $db->query($sql);
        $row = mysqli_fetch_array($result_count);
        return array_shift($row);
    }
}

?>


