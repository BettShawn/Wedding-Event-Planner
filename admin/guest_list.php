<?php include 'include/init.php'; ?>

<?php
     if (!isset($_SESSION['id'])) { redirect_to("../");}

     $booking_id = $_GET['booking_id'];
     $user_id = $_GET['user_id'];
     $links='booking_id='.$booking_id.'&user_id='.$user_id;
     $guest_list =  Guest::getGuest($booking_id);
?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard - Administrator</title>
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
            padding: 0;
            padding-top: 8px;
            padding-left:6px;
            padding-bottom:6px;
            margin-top:5px;
            text-transform: capitalize;
        }
        .datepicker {
            font-size: 12px;
        }
       
        div.dataTables_wrapper div.dataTables_paginate {
            font-size: 11px;
        }

    </style>
</head>

<body>

<?php include_once 'include/sidebar.php'; ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="h4 mt-4">Master Guest List</h4>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class="btn btn-sm btn-primary mr-2 " style="font-size: 12px;" href="client_manage_account_details.php?<?= $links; ?>"><i class="mdi mdi-buffer mr-2"></i> Overview</a>
            <a class="btn btn-sm btn-info mr-2 " style="font-size: 12px;" href="guest_list.php?<?= $links; ?>"><i class="mdi mdi-account-plus mr-2"></i> Master List Guest</a>
            <a class="btn btn-sm btn-success mr-2 " style="font-size: 12px;" href="budget.php?<?= $links; ?>"><i class="mdi mdi-currency-usd mr-2"></i> Budget</a>
            <a class="btn btn-sm btn-warning mr-2 " style="font-size: 12px;" href="task_calendar.php?<?= $links; ?>"><i class="mdi mdi-calendar-text mr-2"></i> Task Calendar</a>
        </div>
    </div>
</div>
<?php
    if ($session->message()) {
        echo $session->message();
    }
?>
<div class="text-right mr-2 mb-3">
    <a class="btn btn-sm btn-success mr-2" href="guest_add.php?<?= $links; ?>"><i class="mdi mdi-account-plus mr-2"></i> Add New Guest</a>
</div>
<table id="guest_list" class="table table-striped table-hover table-bordered table-sm" cellspacing="0" width="100%" style="background: white;padding: 0 5px;">

    <thead>
        <tr>
            <th>Fullname</th>
            <th>Guest Name</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zipcode</th>
            <th>Priority-type</th>
            <th>Out of town</th>
            <th>Relationship</th>
            <th>Track Gifts &amp; Thank you</th>
            <th>Tools</th>
        </tr>
    </thead>
    
    <tbody>
    <?php foreach ($guest_list as $guest_list_rows) : ?>
        <tr>
            
            <td class="special"><?= trim_body($guest_list_rows->fullname);?></td>
            <td class="special"><?= $guest_list_rows->guestname; ?></td>
            <td class="special"><?= trim_body($guest_list_rows->address); ?></td>
            <td class="special"><?= $guest_list_rows->city; ?></td>
            <td class="special"> <?= $guest_list_rows->state; ?></td>
            <td class="special"><?= $guest_list_rows->zipcode; ?></td>
            <td class="special"><?= $guest_list_rows->priority; ?></td>
            <td class="special"><?= ($guest_list_rows->out_of_town == 'y') ? 'Yes' : 'No'; ?></td>
            <td class="special"><?= ($guest_list_rows->relationship == 'b') ? 'Bride': 'Groom'; ?></td>
            <td class="special"><?= trim_body($guest_list_rows->tracks_and_gifts); ?></td>
            <td class="special">

                <a href="guest_edit.php?id=<?= $guest_list_rows->id; ?>&<?= $links; ?>" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit This Guest"><i class="mdi mdi-account-edit"></i></a>

                <a href="guest_delete.php?id=<?= $guest_list_rows->id; ?>&<?= $links; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete This Guest"><i class="mdi mdi-account-remove"></i></a>


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
<script>

    $(document).ready(function() {
        $('#guest_list').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>

</body>
</html>