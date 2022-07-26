<?php 
class BookingEvent
{
	protected static $db_table = "tbleventbooking";
    protected static $db_table_fields = array(
        'id',
        'booking_id',
        'wedding_id',
        'features_id',
        'family',
        'individual',
    );

    public $id;
    public $booking_id;
    public $wedding_id;
    public $features_id;
    public $individual;
    public $family;


    
}
?>