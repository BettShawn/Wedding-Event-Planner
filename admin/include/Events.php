<?php

class Events extends DB_Object
{
    protected static $db_table = "events";
    protected static $db_table_fields = array(
        'id',
        'booking_id',
        'title',
        'location',
        'date_created',
        'color',
        'start',
        'end'
    );

    public $id;
    public $booking_id;
    public $title;
    public $location;
    public $start;
    public $end;
    public $color;
    public $date_created;
    public $payment;
    public $date_issue;
    public $cash;
    public $credit;

    public static function find_by_event_all_budget($id) {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE booking_id = $id ORDER BY booking_id DESC");
    }

    public static function getLiquidation_by_id($id) {
        global $db;
        $sql = "SELECT * FROM tbl_liquidation INNER JOIN events ON events.id = tbl_liquidation.event_id WHERE tbl_liquidation.booking_id = $id";
        $result_set = $db->query($sql);

        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }
        return $the_object_array;
    }

    public static function find_by_event_by_all($id) {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $id ORDER BY id DESC");
    }




}

?>


