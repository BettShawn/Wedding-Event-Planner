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
        redirect_to("sign_up.php");
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
        redirect_to("sign_up.php");
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
        redirect_to("sign_up.php");
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
        redirect_to("sign_up.php");
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Free Register - Wedding Planner</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datepicker.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Open Sans', 'Roboto', sans-serif;
            line-height: 1.5em;
            margin-bottom: 0%;
            width: 100%;
            margin-top: 4%;
            overflow-x: hidden;
            background: #f1f1f1;
        }

        .navbar-light .navbar-brand {
            color: #1a1a1a;
            font-weight: bold;
            line-height: 22px;
        }

        .navbar {
            font-weight: 700;
            padding: 12px;
            font-style: normal;
            font-size: 14px;
            text-transform: uppercase;
            color: black;
            border-bottom: 1px solid #ddd;
        }

        li.nav-item > a.nav-link {
            color: black !important;
            font-weight: bold !important;
        }

        #review {
            font-size: 16px;
            font-weight: bold;
            margin-right: 5px;
        }

        .form-inline > a.mr-2, .btn.btn-sm.my-2.my-sm-0 {
            color: black;
            font-size: 14px;
            font-weight: 700;
            margin-left: 10px;
        }

        .form-inline > a.mr-2:hover, .btn.btn-sm.my-2.my-sm-0:hover {
            color: #17b4bc;
            text-decoration: none;
        }

        a.btn.btn-sm.my-2.my-sm-0.mr-2.loginbtn {
            background: #dc3545;
            font-size: 14px;
            color: white;
            padding: 5px;
            border: 2px solid transparent;
            width: 85px;
        }

        a.btn.btn-sm.my-2.my-sm-0.mr-2.loginbtn:hover {
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .navbar-expand-lg .navbar-nav .nav-link {
            padding-right: .9rem;
        }

        .navbar-brand {
            margin-left: 20px;
            width: 200px;
        }

        .hero {
            height: 550px;
            width: 100%;
            border-color: rgba(0, 0, 0, 0.02);
            background: url(images/carousel2.jpg);
            background-size: contain;
            background-size: 100% 100%;

        }

        .form-control {
            font-size: 14px;
        }

        .hero-lead {
            font-size: 36px;
            color: white;
            font-style: normal;
        }

        .form-control {
            outline: none;
            border-radius: 0;
        }

        .btn.btn-info.text-uppercase {
            font-size: 14px;
        }

        .btn.btn-info.text-uppercase.font-weight-bold {
            width: 150px;
            padding: 6px;
            border-radius: 0;
        }

        .btn.btn-danger.text-uppercase {
        font-size: 14px;
        }

        .btn.btn-danger.text-uppercase.fb {
        width: 150px;
        padding: 6px;
        border-radius: 0;
        }

        .datepicker {
            width: 250px;
            font-size: 12px;
        }

        .pricing {
            width: 18%;
            min-height: 200px;
            float: left;
            background: gray;
            margin-left: 2%;
        }

        .container-fluid.custom-container {
            width: 90%;
        }

        a.btn.btn-custom {
            background: none;
            border-radius: 0;
            font-size: 12px;
            width: 100%;
            border: 2px solid #17a2b8;
            color: #17a2b8;
            font-weight: 700;
            text-transform: uppercase;
        }

        a.btn.btn-custom:hover {
            background: #17a2b8;
            color: white;
        }

        .list-group-item.text-center.text-uppercase {
            background: white;
            color: black;
            font-weight: 700;
            font-size: 18px;
            padding: 10px;
        }

        .list-group-item {
            font-size: 12px;
            padding: 5px 10px;
        }

        .card-columns {
            column-count: 4;
        }
        .modal-content {
            -webkit-border-radius:0;
            -moz-border-radius:0;
            border-radius:0;
            font-size: 14px;
        }
        .btn.btn-primary.mr-2.custom-btn {
            background: #22adb5;
            border: 1px solid #22adb5;
        }
        .btn.btn-primary.mr-2.custom-btn:hover {
            background: #2d98b5;
        }
        .modal-header {
            border-bottom: 0;
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 10px;
            padding-bottom: 0;
        }
        .modal-body {
            padding-bottom: 0;
        }
        .bgact{
                /* background: rgba(255, 255,255, 0.4); */
                background: rgb(14 14 14 / 49%);
                padding: 15px;
        }
    </style>
</head>
<body>

<?php include 'include/nav.php';?>

<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="hero">
            <div class="row justify-content-md-center">
                <div class="col col-lg-3">
                </div>
                <div class="col col-lg-5" style="margin-top: 7%;">
                    <!-- <h2 class="text-center hero-lead">Wedding Planning Starts Here</h2>
                    <p class="lead text-center" style="color:white;">START BY CREATING YOUR FREE ACCOUNT</p> -->
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
</div><!-- end of container-fluid  -->.

<footer class="pt-3">
    <div class="row">
        <div class="col-12 col-md">
            <div class="text-center">
                <small class="d-block mb-3 text-muted">All Right Reserved &copy; <?php echo date('Y')?></small>
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