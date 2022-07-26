<?php include("include/init.php"); ?>

<?php 

if(empty($_GET['id'])) {
	redirect_to("users.php");
}

$user = Users::find_by_id($_GET['id']);

if($user)
{
	$session->message("<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> The {$user->firstname} {$user->lastname} has been deleted.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
	$user->delete_photo();
	redirect_to("users.php");
} else {
	redirect_to("users.php");
}

?>
