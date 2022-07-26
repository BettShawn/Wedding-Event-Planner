<?php include 'admin/include/init.php'; ?>
<?php
    $count = 0;
    $error = '';
    $user_firstname = $user_lastname = $user_password = $user_email = $wedding_date = '';

    $account_details = new Account_Details();
    $accounts = new Accounts();
    $booking = new Booking();
    $category = Category::find_all();
    $blogEvent = EventWedding::getEventBlogs();

    if (isset($_POST['register'])) {

        $user_firstname = clean($_POST['user_firstname']);
        $user_lastname = clean($_POST['user_lastname']);
        $user_email = clean($_POST['user_email']);
        $user_phone = clean($_POST['user_phone']);
        $wedding_date = clean($_POST['wedding_date']);

        $checkdate = $booking->check_wedding_date($wedding_date);

        if ($checkdate) {
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  The wedding you enter is already booked. Please Try another set of date!
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        if (empty($user_firstname) ||
            empty($user_phone) ||
            empty($user_email) ||
            empty($user_lastname) ||
            empty($wedding_date)) {
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  Please Fill up all the fields.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  Incorrect email format.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();

        }

        $check_email = $accounts->email_exists($user_email);

        if ($check_email) {
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  Email is already Exists.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        } else {
            if ($error == '') {
                $count = $count + 1;
                $account_details->firstname = $user_firstname;
                $account_details->lastname = $user_lastname;
                $account_details->status = 'pending';
                $account_details->datetime_created  = date("y-m-d h:m:i");
                $account_details->phone= $user_phone;
                if ($account_details->save()) {
                    $account_details->user_id = mysqli_insert_id($db->connection);

                    if($account_details->update()) {
                        $accounts->user_id = $account_details->user_id;
                        $accounts->user_email= $user_email;


                         if($accounts->save()) {
                             $booking->user_id = $accounts->user_id;
                             $booking->user_email = $user_email;
                             $booking->wedding_date =  $wedding_date;
                             $booking->save();
                             redirect_to("thank_you.php");
                         }
                    }
                }
            }
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wedding Planner</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .alert {
            font-size: 12px;
        }
        .error {
            background-color: #F2DEDE;
        }
        .alert.alert-danger.text-center {
            font-size: 16px;
        }
        .mdi.mdi-alert-circle.mr-3 {
            font-size: 16px;
        }

        .bgact{
                /* background: rgba(255, 255,255, 0.4); */
                background: rgb(14 14 14 / 49%);
                padding: 15px;
        }

    </style>
</head>
<body>
<?php include 'include/nav.php'; ?>

<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="hero">
            <div class="row justify-content-md-center">
                <div class="col col-lg-3">
                </div>
                <div class="col col-lg-5" style="margin-top: 10%;">
                    
                    <?php
                        if ($session->message()) {
                            echo $session->message();
                        }
                    ?>
                    <form class="bgact" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <h2 class="text-center hero-lead">Wedding Planning Starts Here</h2>
                    <p class="lead text-center" style="color:white;">START BY FILLING UP THE FORM</p>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="user_firstname" placeholder="First Name" id="user_firstname">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" id="user_lastname" class="form-control" name="user_lastname" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="user_email" id="user_email" placeholder="youremailaddress@mail.com">
                        </div>
                        <div class="form-group">
                            <input type="text" aria-describedby="phoneHelpBlock" class="form-control" name="user_phone" id="user_phone" placeholder="Contact Number">
                        </div>
                        <div class="form-row">
                            <div class="input-group col-md-5">
                                <input type="text" class="form-control" name="wedding_date" data-provide="datepicker" id="wedding_date"
                                       placeholder="Wedding Date">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background: white;"><i
                                                style="font-size: 20px;color:#19b5bc;" class="mdi mdi-calendar-check"
                                                id="review" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <p style="font-size: 11px;color:white;">By clicking "Sign Up" you agree to WPMS's <a
                                        href="" title="" style="color: #b81717;font-weight: bold;">Terms of Use</a></p>
                            <button type="submit" name="register" class="btn btn-danger btn-sm text-uppercase fb"
                                    style="margin-top: -5px;">Sign Up
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col col-lg-3">
                </div>
            </div>
        </div><!-- end of hero -->
    </div> <!-- end of row justify-content-md-center -->
</div><!-- end of container-fluid  -->

<div class="container-fluid custom-container">
    <div class="row">
        <div class="col-lg-12">
            <!-- <h3 class="h5 text-uppercase text-center text-muted mt-4">Wedding</h3> -->
            <hr>
            <h2 class="h2 text-uppercase text-center mb-4">Our Wedding Packages</h2>

            <?php foreach ($category as $category_row) : ?>
                <div class="pricing">
                    <ul class="list-group list-unstyled">
                        <li class="list-group-item text-center text-uppercase"><?= $category_row->wedding_type; ?></li>
                        <li><img src="admin/<?= $category_row->preview_image_picture(); ?>" class="img-fluid" alt=""></li>
                        <li class="list-group-item text-center"><b>THIS PACKAGE INCLUDES:</b></li>
                        <?php $feature = Features::find_by_feature_all($category_row->id); ?>
                            <?php foreach ($feature as $feature_item) : ?>
                                <li class="list-group-item"><?= $feature_item->title; ?></li>
                            <?php endforeach; ?>
                        <li class="list-group-item font-weight-bold">Price:KES <?= number_format($category_row->price); ?>
                         </li>
                        <li class="list-group-item font-weight-bold">
                            <a href="package_detail.php?id=<?= $category_row->id; ?>" class="btn btn-custom">View Details</a>
                        </li>
                    </ul>
                </div>
             <?php endforeach; ?>
        </div><!-- end of col-lg-12 -->
    </div><!-- end of row -->
</div><!-- end of container-fluid -->

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="h2 text-uppercase text-center mb-3">THE LATEST INSPIRATION</h2>
            <h6 class="h6 text-uppercase text-center text-muted mb-3">Discover the best ideas, tips and articles to
                inspire
                your wedding.</h6>

            <div class="card-columns">

                <?php foreach($blogEvent as $blog_item) : ?>
                   <div class="card">
                    <img class="card-img-top" src="admin/<?= $blog_item->preview_image_picture(); ?>" alt="Card image cap">
                        <div class="card-body">
                            <a href="wedding_details.php?id=<?= $blog_item->id; ?>" class="btn-stamp">
                                <h6 class="card-title mt-0 mb-0 text-center font-weight-bold font-custom text-uppercase"><?= $blog_item->title; ?></h6>
                                <p class="card-text mt-0 mb-0 text-center color_gray"><?= $blog_item->wedding_type; ?> Wedding</p>
                                <p class="card-text mt-0 mb-0 text-center color_light text-capitalize"><i class="mdi mdi-map-marker"></i>
                                    <?= $blog_item->location; ?></p>
                            </a>
                        </div>
                    </div> 
                <?php endforeach; ?>

                <a href="real-weddings.php" class="btn btn-lg btn-block btn-explore">EXPLORE MORE INSPIRATION</a>
            </div>
        </div><!-- end of col-lg-12 -->
    </div><!-- end of row -->
</div><!-- end of container -->


<div class="container-fluid" style="width: 100%;background: white;margin-top: 50px;padding-bottom: 20px;">
    <div class="row">
        <div class="col-lg-6">
            <div class="row img-control">
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <img src="DESIGN/checklist-ea253352239433deb24f2ed8ae110aac1840ff8fa5df43967027e880b5f5385b.svg"
                         alt="">
                    <div class="font-custom">CheckList</div>
                </div>
                <div class="col-md-2">
                    <img src="DESIGN/seating-chart-084bbdaabe84a638edf344224d7a92b1bc792db53c5fcf7ab16fcd5a6109ff79.svg"
                         alt="">
                    <div class="font-custom">Seating Chart</div>
                </div>
                <div class="col-md-2">
                    <img src="DESIGN/guest-list-eaaf9277c60be7449e41e2f72f358ae3c94c1b31726b894e064498a9536cac9a.svg"
                         alt="">
                    <div class="font-custom">Guess List</div>
                </div>
                <div class="col-md-2">
                    <img src="DESIGN/budget-6eca6d3898f15dd5682ce3664d8d9ff9bdd271db03857ba8a99e90b9181db46c.svg"
                         alt="">
                    <div class="font-custom">Budget</div>
                </div>
                <div class="col-md-2">
                    <img src="DESIGN/vendor-manager-102fbe8fdbab3e176a6d29bd05c6f26dcd35cfa0f55ff50b1bfd9e70c8fdcdda.svg"
                         alt="">
                    <div class="font-custom">Vendor Manager</div>
                </div>

            </div>
                <h1 class="h1 text-center mt-4">Take the Stress Out of Planning</h1>
                <p class="lead text-muted text-center ml-5" style="font-size: 14px;">Check things off your personalized to-do list all the way to your big day!</p>
        </div>
        <div class="col-lg-6">
            <div class="feature">
                <ul class="list-group rounded-0">
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center ">Announcement your engagement
                        <span class="badge badge-pill" style="font-size: 12px;font-weight: bold;color:#888;">OverDue <i class="mdi mdi-checkbox-blank-outline ml-3" ></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Plan your engagement party
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">Today <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Schedule an engagement photo shoot
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">Tomorrow <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Set up your registry
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">May 15 <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Start your guest list
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">Today <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Decide on your wedding
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">June 10 <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                    <li class="list-group-item rounded-0 d-flex justify-content-between align-items-center">Select your wedding date
                        <span class="badge badge-pill" style="font-size: 12px;color:#888">June 20 <i class="mdi mdi-checkbox-blank-outline ml-3"></i></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<footer class="pt-3">
    <div class="row">
        <div class="col-12 col-md">
            <div class="text-center">
                <small class="d-block mb-3 text-muted">&copy; <?php echo date('Y')?> - Developed By Bruce Wayne</small>
            </div>
        </div>
    </div>
</footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.2.1.slim.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/savy.js"></script>
<script>

    $(document).ready(function () {
        $('#wedding_date').datepicker();
    <?php
        if($count == 0) {
    ?>
        $('#user_firstname').savy('load');
        $('#user_lastname').savy('load');
        $('#user_email').savy('load');
        $('#user_phone').savy('load');
        $('#wedding_date').savy('load');
    <?php } else { ?>
        $('#user_firstname').savy('destroy');
        $('#user_email').savy('destroy');
        $('#user_lastname').savy('destroy');
        $('#user_phone').savy('destroy');
        $('#wedding_date').savy('destroy');
    <?php } ?>
    });
</script>
</body>
</html>