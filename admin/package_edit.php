<?php include 'include/init.php'; ?>
<?php


    if (!isset($_SESSION['id'])) { redirect_to("../"); }
    $category = Category::find_by_id($_GET['id']);

    if (isset($_POST['submit'])) {

        $wedding_type = clean($_POST['wedding_type']);
        $price = clean($_POST['price']);
       
         if (empty($wedding_type) || empty($price)) {
            redirect_to("services_list.php");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> Please Fill up all the information.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }
        if ($category) {

            if(empty($_FILES['preview_image'])) {
                $category->wedding_type = $wedding_type;
                $category->price = $price;
                $category->update();
                redirect_to("service_list.php");
                $session->message("
                    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                      <strong><i class='mdi mdi-check'></i></strong>The {$category->wedding_type} is successfully Updated.
                      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                      </button>
                    </div>");
            } else {
                $category->wedding_type = $wedding_type;
                $category->price = $price;
              $category->set_file($_FILES['preview_image']);
              $category->save_image();
              $category->save();
              // redirect_to("edit_user.php?id={$room->id}");
              $session->message("
                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                  <strong><i class='mdi mdi-check'></i></strong>The {$category->title} is successfully updated.
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>");
              redirect_to("service_list.php");
            }
        }
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

            <div class="col-lg-8 pl-3 pb-3 box-shadow mt-4">
            
                <form method="post" action="" enctype="multipart/form-data">

                    <h4 class="h4 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">Edit Package</h4>
            
                    <?php
                        if ($session->message()) {
                            echo ' <div class="form-group col-md-12">' . $session->message() . '</div>';
                        }
                    ?>
                    
                    <div class="form-group">
                        <label for="wedding_type">Package Title</label>
                        <input type="text" name="wedding_type" class="form-control" id="wedding_type"  placeholder="Enter package name" value="<?= $category->wedding_type ?>">
                    </div>

                    <div class="form-group">
                        <label for="price">Price Of This Package</label>
                        <input type="text" name="price" class="form-control" id="price"  placeholder="Enter the price"  value="<?= $category->price ?>">
                    </div>

                    <div class="form-group">
                        <label for="preview_image">Preview Image</label>
                        <input type="file" name="preview_image" id="preview_image">
                   </div>

                    <a href="service_list.php" class="btn btn-sm btn-danger float-right" style="font-size: 12px;">Cancel</a>

                   <button type="submit" name="submit" class="btn btn-sm btn-success float-right mr-2" style="font-size: 12px;">Edit</button>

               
            </div>
            <div class="col-lg-4 mt-4">
                <img src="<?= $category->preview_image_picture(); ?>" width="380" height="306"  alt="">
            </div>
             </form><!-- end of input form -->
        </div>
    </div>



<?php include_once 'include/footer.php';?>
