<?php include("include/init.php"); ?>

<?php 
$booking_id = $_GET['booking_id'];
$user_id = $_GET['user_id'];
$links='booking_id='.$booking_id.'&user_id='.$user_id;

if(empty($_GET['id'])) {
	redirect_to("guest_list.php");
}

$guest = Guest::find_by_id($_GET['id']);

if($guest)
{
	$session->message("<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> The guest {$guest->id}  has been deleted.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
	$guest->delete();
	redirect_to("guest_list.php?$links");
} else {
	redirect_to("guest_list.php?$links");
}

?>
