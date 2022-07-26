<?php include 'include/init.php'; ?>
<?php


    if (!isset($_SESSION['id'])) { redirect_to("../"); }
    $gallery = new Gallery();
    $booking = Booking::find_booking_all();
    if (isset($_POST['submit']) || isset($_FILES['file'])) {

        $gallery->title = clean($_POST['title']);
        $gallery->caption = clean($_POST['caption']);
        $gallery->alternate_text = clean($_POST['alternate_text']);
        $gallery->description = clean($_POST['description']);
        $gallery->booking_id = clean($_POST['booking_id']);
        $gallery->set_file($_FILES['file']);
       
         if ($gallery->save()) {
           redirect_to("photos_view.php");
        } else {
            $msg = join("<br>",$gallery->errors);
        }
    }
?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Upload Photos - Administrator</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <link rel="stylesheet" href="css/dropzone.css">
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
            .btn.btn-light.btn-sm {
                background-color: #e2e6ea;
            }
            .dropzone {
                    border: 6px dashed #17b4bc
            }
            .dz-default.dz-message {
                color: #17b4bc;
                font-size: 24px;
            }
        </style>
    </head>

<body>

<?php include_once 'include/sidebar.php'; ?>

    <div class="container">
    
        <div class="row">

            <div class="col-lg-8 offset-2 pl-3 pb-3 box-shadow mt-4 pt-3">
                <h5>Upload New Image</h5>
                <?= (isset($msg) ? $msg : ''); ?>
                <form method="post" action="" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="booking_id">Related:</label>
                        <select class="custom-select form-control" id="booking_id" name="booking_id">
                          <?php foreach($booking as $booking_user) : ?>
                            <?php if ($booking_user->booking_id == $gallery->booking_id) : ?>
                              <option value="<?= $booking_user->booking_id; ?>" selected><?= $booking_user->bride . ' + ' . $booking_user->groom; ?></option>
                            <?php else : ?>
                              <option value="<?= $booking_user->booking_id; ?>"><?= $booking_user->bride . ' + ' . $booking_user->groom; ?></option>
                            <?php endif ?>
                          <?php endforeach; ?>
                        </select>
                    </div>
                   <div class="form-group">
                       <label for="">Title:</label>
                       <input type="text" name="title" class="form-control" placeholder="Enter title">
                   </div>
                   <div class="form-group">
                       <label for="">Caption:</label>
                       <input type="text" name="caption" value="<?= $gallery->caption; ?>" class="form-control" placeholder="Enter caption">
                   </div>
                    <div class="form-group">
                       <label for="">Alternate Text:</label>
                       <input type="text" name="alternate_text" value="<?= $gallery->alternate_text; ?>" class="form-control" placeholder="Enter text">
                   </div>
                   <div class="form-group">
                       <textarea name="description" rows="10" class="form-control" placeholder="Enter a description"><?= $gallery->description; ?></textarea>
                   </div>
                   <div class="form-group">
                       <input type="file" name="file">
                   </div>
                   <button type="submit" name="submit" value="" class="btn btn-success btn-sm">Save image</button>
                   <a href="photos_view.php" class="btn btn-danger btn-sm">Go Back</a>
                </form><!-- end of input form -->
<br>
                <h5 class="h5">OR Drag Your Images</h5>
                <div id="dropzone-area">
                    <form action="photos_add.php" class="dropzone"></form>  
                </div>
            </div>
        </div>
    </div>



<?php include_once 'include/footer.php';?>
