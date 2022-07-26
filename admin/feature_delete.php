<?php include("include/init.php"); ?>

<?php 

if (!isset($_SESSION['id'])) {
	redirect_to("../login.php");
}

if(empty($_GET['id'])) {
	redirect_to("service_list.php");
}

$features = Features::find_by_feature_id($_GET['id']);

if($features) {
	$session->message("<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> The features {$features->title}  has been deleted.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
	$features->delete_feature($_GET['id']);
	redirect_to("service_list.php");
} else {
	redirect_to("service_list.php");
}

?>
