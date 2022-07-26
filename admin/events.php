<?php include 'include/init.php'; ?>

<?php
     if (!isset($_SESSION['id'])) { redirect_to("../");}

    $booking_id = $_GET['booking_id'];
    $user_id = $_GET['user_id'];
    $links='booking_id='.$booking_id.'&user_id='.$user_id;
    
    $events =  Events::find_by_event_all($booking_id);
    
    $booking = Booking::find_by_booking_id($booking_id);

?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Events - Administrator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <style>
        table.table.table-bordered.table-sm {
            font-size:12px;
        }
        .tooltip {
            font-size: 12px;
        }

        div.dataTables_wrapper div.dataTables_paginate {
            font-size: 11px;
        }
        .special-budget {
            padding-top: 10px !important;
        }

    </style>
</head>

<body>

<?php include_once 'include/sidebar.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h5 class="h5 mt-4">All Events Of <?= $booking->bride; ?> + <?= $booking->groom; ?></h5>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2" >
            <a class="btn btn-sm btn-light mr-2 active" style="font-size: 12px;" href="client_manage_account_details.php?<?= $links; ?>"><i class="mdi mdi-account-plus mr-2"></i> Overview</a>

            <a class="btn btn-sm btn-light mr-2 active" style="font-size: 12px;" href="guest_list.php?<?= $links; ?>"><i class="mdi mdi-account-plus mr-2"></i> Master List Guest</a>

            <a class="btn btn-sm btn-light mr-2 active" style="font-size: 12px;" href="budget.php?<?= $links; ?>"><i class="mdi mdi-currency-usd mr-2"></i> Budget</a>

            <a class="btn btn-sm btn-light mr-2 active" style="font-size: 12px;" href="task_calendar.php?<?= $links; ?>"><i class="mdi mdi-file-tree mr-2"></i> Task Calendar</a>
        </div>
    </div>
</div>
<?php
    if ($session->message()) {
        echo $session->message();
    }
?>
<table id="example" class="table table-bordered table-sm" cellspacing="0" width="100%">

    <thead>
        <tr>
            <th>Event Name</th>
            <th>Total Families Invited</th>
            <th>Total Individual Guest Invited</th>
            <th>Yes</th>
            <th>No</th>
            <th>Has Not Responded</th>
            <th>Tools</th>
        </tr>
    </thead>

    <tbody>
        
        <?php foreach($events  as $events_name) :  ?>
       <tr>
            <td><?= $events_name->title; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <a href="" title="" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i></a>
                <a href="" title="" class="btn btn-danger btn-sm"><i class="mdi mdi-delete-forever"></i></a>
            </td>
       </tr>
   <?php endforeach; ?>
    </tbody>
</table>


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
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<script src="js/dropzone.js"></script>
<script>
  
    $(document).ready(function() {
        $('#example').DataTable();
        $('[data-toggle="tooltip"]').tooltip();

    });
    
</script>

</body>
</html>

