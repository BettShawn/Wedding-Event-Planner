<?php include 'include/init.php'; ?>
<?php


    if (!isset($_SESSION['id'])) { redirect_to("../"); }
    $features = new Features();
    $category = category::find_all();

    if (isset($_POST['submit'])) {

        $wedding_type = clean($_POST['wedding_type']);
        $title = clean($_POST['title']);
        $description = clean($_POST['description']);
       
         if (empty($wedding_type) || empty($title) || empty($description)) {
            redirect_to("feature_add.php");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> Please Fill up all the information.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        $features->title = $title;
        $features->category_id = $wedding_type;
        $features->description = $description;
        $features->save();
        redirect_to("feature_add.php");
        $session->message("
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-check'></i></strong> {$features->title} is successfully added.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
    }


?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add New Package Information - Administrator</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
        <style>
            body {
                margin-bottom: 2%;
            }
            .box-shadow {
                box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.3);
                font-size: 12px;
            }
            .form-control {
                font-size: 12px;
            }
            .datepicker {
                font-size: 12px;
            }
        </style>
    </head>

<body>

<?php include_once 'include/sidebar.php'; ?>

    <div class="container">

        <div class="row">

            <div class="col-lg-8 offset-2 pl-3 pb-3 box-shadow mt-4">
                    
            
                <form method="post" action="">
                
                    <h4 class="h4 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">Add New Feature
                     <a href="service_list.php" class="btn btn-sm btn-light active float-right" style="font-size: 12px;"><i class="mdi mdi-left-arrow"></i> Back</a></h4>

                    <?php
                        if ($session->message()) {
                            echo  $session->message();
                        }
                    ?>

                    <div class="form-group">
                        <label for="title">Feature Title</label>
                        <input type="text" name="title" class="form-control" id="title"  placeholder="Enter feature name">
                    </div>
                    <div class="form-group">
                        <label for="wedding_type">Wedding Type</label>
                        <select name="wedding_type" id="wedding_type" class="form-control">
                        <?php foreach ($category as $categories) : ?>
                            <option value="<?= $categories->id; ?>"><?= $categories->wedding_type; ?> - Price: <?= number_format($categories->price, 2); ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3" placeholder="Leave description about this feature"></textarea>
                    </div>
                     <a href="service_list.php" class="btn btn-sm btn-danger float-right" style="font-size: 12px;">Cancel</a>

                        <button type="submit" name="submit" class="btn btn-sm btn-light float-right mr-2" style="font-size: 12px;">Save</button>
                </form><!-- end of input form -->
            </div>
        </div>
    </div>



<?php include_once 'include/footer.php';?>
