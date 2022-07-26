<?php include 'include/init.php'; ?>

<?php
     if (!isset($_SESSION['id'])) { redirect_to("../");}

     // $booking_id = $_GET['booking_id'];
     // $user_id = $_GET['user_id'];
     // $links='booking_id='.$booking_id.'&user_id='.$user_id;
     // $guest_list =  Guest::getGuest($booking_id);
     $category = Category::find_all(); 
     $features = Features::getAllfeatures(); 
?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Services And Modules - Administrator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <style>
        table.table.table-striped.table-bordered.table-sm {
            font-size:12px;
        }
        .tooltip {
            font-size: 12px;
        }

        td.special {
            /*padding: 0;*/
            padding-top: 10px;
            /*padding-left:6px;*/
            /*padding-bottom:6px;*/
            /*margin-top:5px;*/
            text-transform: capitalize;
        }
       
        div.dataTables_wrapper div.dataTables_paginate {
            font-size: 11px;
        }

        /* SuperBox */
        .superbox-list {
            display:inline-block;
            *display:inline;
            zoom:1;
            width:12.5%;
        }
        .superbox-img {
            max-width:100%;
            width:100%;
            cursor:pointer;
        }
        .superbox-show {
            text-align:center;
            position:relative;
            background:#333;
            box-shadow:inset 0 1px 5px #111;
            -webkit-box-shadow:inset 0 1px 5px #111;
            -moz-box-shadow:inset 0 1px 5px #111;
            width:100%;
            float:left;
            padding:25px;
            display:none;
        }
        .superbox-current-img {
            max-width:100%;
            box-shadow:0 1px 4px #222;
            border:1px solid #222;
        }
        .superbox-img:hover {
            opacity:0.8;
        }
        .superbox-float {
            float:left;
        }
        .superbox-close {
            opacity:0.7;
            cursor:pointer;
            position:absolute;
            top:25px;
            right:25px;
            background:url(../img/close.gif) no-repeat center center;
            width:35px;
            height:35px;
        }
        .superbox-close:hover {
            opacity:1;
        }
        @media only screen and (min-width: 320px) {
            .superbox-list {
                width:50%;
            }
        }
        @media only screen and (min-width: 486px) {
            .superbox-list {
                width:25%;
            }
        }
        @media only screen and (min-width: 768px) {
            .superbox-list {
                width:16.66666667%;
            }
        }
        @media only screen and (min-width: 1025px) {
            .superbox-list {
                width:12.5%;
            }
        }

    </style>
</head>

<body>

<?php include_once 'include/sidebar.php'; ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="h4 mt-4">All Albums</h4>
     <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class="btn btn-sm btn-light mr-2" style="font-size: 12px;" href="package_add.php"><i class="mdi mdi-account-plus mr-2"></i> New Package</a>
        </div>
    </div>
</div>
<?php
    if ($session->message()) { 
        echo $session->message();
    }
?>

    <div class="col-md-12">
     
    </div><!-- end of col-md-6 -->
    <div class="col-md-12 mt-4">
       
       
    </div><!-- end of col-md-12 -->
 


<?php include_once 'include/footer.php';?>