<?php 
    include 'include/init.php'; 
    $count = 0;
    $error = '';
    if (!isset($_SESSION['id'])) { redirect_to("../"); }

    // $booking_id = $_GET['category'];
    // $user_id = $_GET['user_id'];
    $category = Category::find_all();
    $event_wedding =  new EventWedding();
    // $account_detail =  new Account_Details();
    // $booking_detail =  new category();

    if (isset($_POST['submit']) || isset($_FILES['preview_image'])) {

        $title = clean($_POST['title']);
        $description = clean($_POST['description']);
        $wedding_date = clean($_POST['wedding_date']);
        $location = clean($_POST['location']);
        $status = clean($_POST['status']);
        $wedding_type = clean($_POST['wedding_type']);
        
         if (empty($title) || empty($description) || empty($wedding_date) || empty($location)) {
            redirect_to("blog_events_add.php");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert mr-2'></i></strong> Please Fill up all the information.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        if ($status == 1) {
            $event_wedding->date_published = date("F j, Y, g:i a");
        }

        $event_wedding->wedding_type = $wedding_type;
        $event_wedding->title = $title;
        $event_wedding->description = $description;
        $event_wedding->wedding_date = $wedding_date;
        $event_wedding->location = $location;
        $event_wedding->status  = $status;
        $event_wedding->date_created  = date("F j, Y, g:i a");
        $event_wedding->set_file($_FILES['preview_image']);
        $event_wedding->save_image();

         if ($event_wedding->save()) {
            redirect_to("blog_events.php");
            $session->message("
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert mr-2'></i></strong> The {$event_wedding->title} is successfully added.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        } else {
            $msg = join("<br>", $event_wedding->errors);
        }
    }
?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add New Article - Administrator</title>
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

<?php include 'include/sidebar.php'; ?>

    <div class="container">

        <div class="row">

            <div class="col-lg-8 pl-3 pb-3 box-shadow mt-4">
               
                <form action="" method="post" enctype="multipart/form-data">
                    <?= isset($msg) ? $msg : ''; ?>
                    <h4 class="h4 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">New Article 

                        <a href="blog_events.php" class="btn btn-sm btn-danger float-right" style="font-size: 12px;"><i class="mdi mdi-close-circle mr-2"></i> Cancel</a>

                        <button type="submit" name="submit" class="btn btn-sm btn-success float-right mr-2" style="font-size: 12px;"><i class="mdi mdi-account-plus mr-2"></i> Save article</button>

                    </h4>
                        <?php
                            if ($session->message()) {
                                echo  $session->message();
                            }
                        ?>
                        <div class="form-group">
                            <label for="booking_id">Wedding Type:</label>
                            <select class="custom-select form-control" id="wedding_type" name="wedding_type">
                              <?php foreach($category as $category_item) : ?>
                                  <option value="<?= $category_item->wedding_type; ?>" selected><?= ucfirst($category_item->wedding_type); ?></option>
                              <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="wedding_post">Related Wedding Post:</label>
                            <select class="custom-select form-control" id="wedding_type" name="wedding_post">
                              <?php foreach($category as $category_item) : ?>
                                  <option value="<?= $category_item->wedding_type; ?>" selected><?= ucfirst($category_item->wedding_type); ?></option>
                              <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" 
                            class="form-control" 
                            id="title"  
                            placeholder="Enter article title">
                        </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Enter description and vendor of this wedding"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="file" name="preview_image" onchange="document.getElementById('preview_image').src = window.URL.createObjectURL(this.files[0])">
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control"
                                   name="wedding_date"  data-provide="datepicker" id="wedding_date"
                                   placeholder="Wedding Date">
                            <div class="input-group-append">
                                    <span class="input-group-text"
                                          style="background: white;">
                                        <i style="color:#19b5bc;" class="mdi mdi-calendar-check"
                                            id="review" aria-hidden="true"></i>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" class="form-control"  id="location" placeholder="Enter Bride's Name">
                    </div>

                    <div class="form-group">
                        <label for="">Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="0">Draft</option>
                            <option value="1">Publish</option>
                        </select>
                    </div>
                </form><!-- end of input form -->
            </div>
            <div class="col-lg-3 mt-4">
                <img id="preview_image" src="https://via.placeholder.com/350x350" width="300" height="350" alt="">
            </div>
        </div>
    </div>

</main>
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-3.2.1.slim.min.js"></script>
<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="js/popper.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.min.js"></script>
<script>
  
    $(document).ready(function() {
        $('#wedding_date').datepicker();
        $('[data-toggle="tooltip"]').tooltip();
    });
    
</script>

</body>
</html>
