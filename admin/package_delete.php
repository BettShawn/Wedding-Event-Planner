<?php include("include/init.php"); ?>

<?php 

if(empty($_GET['id'])) {
	redirect_to("service_list.php");
}

$category = Category::find_by_id($_GET['id']);

if($category) {
	$session->message("<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> The category {$category->wedding_type}  has been deleted.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
	$category->delete_photo();
	redirect_to("service_list.php");
} else {
	redirect_to("service_list.php");
}

?>
