<?php include 'include/init.php'; ?>
<?php

    $count = 0;
    $error = '';
    $firstname = $lastname = $email = $wedding_date = $bride = $groom = $phone = $city = '';
    if (!isset($_SESSION['id'])) { redirect_to("../"); }

    // $booking_id = $_GET['booking'];
    // $user_id = $_GET['user_id'];
    $category = Category::find_all();

    $accounts =  new Accounts();
    $account_detail =  new Account_Details();
    $booking_detail =  new Booking();

    if (isset($_POST['submit'])) {

        $user_password1 = htmlspecialchars($_POST['user_password1']);
        $user_password2 = htmlspecialchars($_POST['user_password2']);

        if ($user_password1 != $user_password2) {
              redirect_to("client_add.php");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert-circle-outline'></i></strong>  Password is mismatched. Please Try Again!
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        

        if ($booking_detail) {

            $firstname = clean($_POST['firstname']);
            $lastname = clean($_POST['lastname']);
            $email = clean($_POST['email']);
            $wedding_date = clean($_POST['wedding_date']);
            $bride = clean($_POST['bride']);
            $groom = clean($_POST['groom']);
            $phone = clean($_POST['phone']);
            $city = clean($_POST['city']);
            $wedding_type = clean($_POST['wedding_type']);
            $organizer_id = clean($_POST['organizer_id']);

             if (empty($firstname) || empty($lastname) || empty($email) || empty($bride) || empty($groom)) {
                redirect_to("client_add.php");
                $session->message("
                <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                  <strong><i class='mdi mdi-account-alert mr-2'></i></strong> Please Fill up all the information.
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>");
                die();
            }

            // if($error == '' ) {
               
                $account_detail->firstname = $firstname;
                $account_detail->lastname = $lastname;
                $account_detail->phone = $phone;
                $account_detail->city = $city;
                $account_detail->status =  'pending';
                $account_detail->datetime_created  = date("y-m-d h:m:i");
            
                if ($account_detail->save()) {
                    $account_detail->user_id = mysqli_insert_id($db->connection);
                    if($account_detail->update()) {
                        $accounts->user_id = $account_detail->user_id;
                        $accounts->user_email= $email;
                        $accounts->user_password = $user_password1;
                        $accounts->user_password= md5($user_password1);

                        if($accounts->save()) {
                            $booking_detail->user_id = $accounts->user_id;
                            $booking_detail->bride = $bride;
                            $booking_detail->groom = $groom;
                            $booking_detail->wedding_type = $wedding_type;
                            $booking_detail->user_email = $email;
                            $booking_detail->wedding_date = $wedding_date;
                            $booking_detail->organizer_id = $organizer_id;
                            $booking_detail->wedding_date =  $wedding_date;
                            
                            $booking_detail->save();
                            redirect_to("client.php");
                            $session->message("
                            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                              <strong><i class='mdi mdi-alert-circle-outline'></i></strong>  New Client has been added.
                              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">&times;</span>
                              </button>
                            </div>");
                            die();
                         }
                    }
                }
            // }
        }
    }


?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add New Client Information - Administrator</title>
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

            <div class="col-lg-8 offset-2 pl-3 pb-3 box-shadow mt-4">
            
                <form action="client_add.php" method="post">
                    <h4 class="h4 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">New Client Information
                        <a href="client.php" class="btn btn-sm btn-danger float-right" style="font-size: 12px;"><i class="mdi mdi-close-circle mr-2"></i> Cancel</a>
                        <button type="submit" name="submit" class="btn btn-sm btn-success float-right mr-2" style="font-size: 12px;"><i class="mdi mdi-account-plus mr-2"></i> Save Client</button>
                    </h4>
                    <div class="form-row">
                        <?php
                            if ($session->message()) {
                                echo ' <div class="form-group col-md-12">' . $session->message() . '</div>';
                            }
                        ?>
                        <div class="form-group col-md-6">
                            <label for="">Firstname</label>
                            <input type="text" name="firstname" 
                            class="form-control" 
                            id="inputFirstname"  
                            placeholder="Enter firstname" 
                            value="<?= $firstname;?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Lastname</label>
                            <input type="text" name="lastname" class="form-control" id="inputLastname" placeholder="Enter lastname">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" class="form-control" id="inputEmail" placeholder="Enter email">
                    </div>

                    <!-- <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="user_password1" class="form-control" id="inputPassword1"  placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" name="user_password2" class="form-control" id="inputPassword2" placeholder="Re-enter password">
                    </div> -->

                    <div class="form-row form-group">

                        <div class="col-md-6">
                            <label for="wedding_date">Wedding Date</label>
                        </div>

                        <div class="col-md-6">
                            <label for="wedding_type">Wedding Type</label>
                        </div>

                        <div class="input-group col-md-6">
                            <input type="text" class="form-control"
                                   name="wedding_date" value="<?= $booking_detail->wedding_date; ?>" data-provide="datepicker" id="wedding_date"
                                   placeholder="Wedding Date">
                            <div class="input-group-append">
                                    <span class="input-group-text"
                                          style="background: white;">
                                        <i style="color:#19b5bc;" class="mdi mdi-calendar-check"
                                            id="review" aria-hidden="true"></i>
                                    </span>
                            </div>
                        </div>

                        <div class="input-group col-md-6">
                            <select class="custom-select form-control" id="wedding_type" name="wedding_type">
                                <?php foreach($category as $category_item) : ?>
                                    <option value="<?= $category_item->id; ?>" selected><?= ucfirst($category_item->wedding_type); ?></option>
                                <?php endforeach; ?>
                              </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Bride's name</label>
                        <input type="text" name="bride" class="form-control" value="<?= $booking_detail->bride; ?>" id="brideName" placeholder="Enter Bride's Name">
                    </div>
                    <div class="form-group">
                        <label for="">Groom's name</label>
                        <input type="text" name="groom" class="form-control" value="<?= $booking_detail->groom; ?>" id="GroomsName" placeholder="Enter Groom's Name">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Phone</label>
                            <input type="text" class="form-control" value="<?= $account_detail->phone; ?>" id="inputPhone" name="phone" placeholder="Enter Phone Number">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">City</label>
                            <input type="text" class="form-control" value="<?= $account_detail->city; ?>" id="inputcity" name="city" placeholder="Enter City">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Assigned Organizer</label>
                            <select class="form-control" id="inputOrganizer" name="organizer_id">
                                <option value="1">Big Day Planners</option>
                                <option value="2">Joyful Events</option>
                                <option value="3">Roses and Co</option>
                            </select>
                        </div><!-- form-group col-md-6 -->
                    </div><!-- end of form-row -->
                </form><!-- end of input form -->
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

