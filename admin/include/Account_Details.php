<?php

class Account_Details extends DB_Object
{
    protected static $db_table = "tblaccounts_detail";
    protected static $db_table_fields = array(
        'id',
        'user_id',
        'firstname',
        'lastname',
        'phone',
        'city',
        'datetime_created',
        'description',
        'location',
        'expectation_visitor',
        'cash_advanced',
        'status',
        'date_signed'
    );

    public $id;
    public $user_id;
    public $firstname;
    public $lastname;
    public $phone;
    public $city;
    public $datetime_created;
    public $description;
    public $location;
    public $cash_advanced;
    public $status;
    public $expectation_visitor;
    public $date_signed;
    public $organizer_id;


    public static function count_user() {
        global $db;
        $sql = "SELECT count(id) FROM tblaccounts_detail";
        $result_count = $db->query($sql);
        $row = mysqli_fetch_array($result_count);
        return array_shift($row);
    }

}



?>


