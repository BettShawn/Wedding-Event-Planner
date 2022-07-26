<?php include("include/init.php"); ?>

<?php 

if(empty($_GET['id'])) {
	redirect_to("photos_view.php");
}

$gallery = Gallery::find_by_id($_GET['id']);

if($gallery)
{
	$session->message("<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> The {$gallery->title} has been deleted.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
	$gallery->delete_photo();
	redirect_to("photos_view.php");
} else {
	redirect_to("photos_view.php");
}

?>
