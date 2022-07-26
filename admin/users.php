<?php include 'include/init.php'; ?>
<?php
     if (!isset($_SESSION['id'])) {
         redirect_to("../");
     }
     $users =  Users::find_all();

?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard - Administrator</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!--    <link href="css/bootstrap.css" rel="stylesheet">-->
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
            padding-top: 20px;
            padding-left:6px;
            /*padding-bottom:10px !important;*/
            margin-top:10px;
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
    <h4 class="h4 mt-4 ml-3">User Management</h4>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class="btn btn-md btn-success" style="font-size: 12px;" href="users_add.php"><i class="mdi mdi-account-plus mr-2"></i> Add New User</a>
        </div>
    </div>
</div>
<?php
    if ($session->message()) {
        echo $session->message();
    }
?>
<table id="example" class="table table-striped table-hover table-bordered table-sm" cellspacing="0" width="100%" style="background: white;padding: 0 5px;">

    <thead>
        <tr>
            <th>Photo</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Username</th>
            <th>Designation</th>
            <th>Address</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    
    <tbody>

    <?php foreach ($users as $user) : ?>
        
        <?php 
            if( $user->id == $_SESSION['id']) {
                continue;
            } 
        ?>

        <tr>
            <td>
                <div class="text-center">
                <img src="<?= $user->profile_picture_picture(); ?>" alt="" class="img-fluid rounded-circle" style="width: 34px;height: 34px;"></td></div>
            <td class="special"><?= $user->firstname . ' ' . $user->lastname;?></td>
            <td class="special"><?= $user->email; ?></td>
            <td class="special"> <?= $user->username; ?></td>
            <td class="special"> <?php if($user->designation  == '1') { echo 'Moderator';} else { echo 'admin';} ?></td>
            <td class="special"> <?= trim_body($user->address, 50); ?></td>
            <td class="special"> <?= $user->date_created; ?></td>
            <td>
                <a href="users_edit.php?id=<?= $user->id; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="
                    Edit This User"><i class="mdi mdi-pencil"></i></a>

                <a href="users_delete.php?id=<?= $user->id; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete This User"><i class="mdi mdi-delete"></i></a>
            </td>
        </tr>

    <?php endforeach; ?>


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
        $('#example').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
    
</script>

</body>
</html>
