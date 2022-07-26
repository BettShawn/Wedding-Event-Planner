<?php include 'include/init.php'; ?>
<?php
     if (!isset($_SESSION['id'])) {
         redirect_to("../");
     }
    $event_wedding =   EventWedding::find_all();
?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Articles - Administrator</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!--  <link href="css/bootstrap.css" rel="stylesheet">-->
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
            padding-right:6px;
            margin-top:5px;
            text-transform: capitalize;
        }
      
        div.dataTables_wrapper div.dataTables_paginate {
            font-size: 11px;
        }

    </style>
</head>

<body>

<?php include_once 'include/sidebar.php'; ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="h4 mt-4 ml-3">Events And Wedding's Information Section</h4>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class="btn btn-md btn-success" style="font-size: 12px;" href="blog_events_add.php"><i class="mdi mdi-account-plus mr-2"></i> Add New Info.</a>
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
            <th>Title</th>
            <th>Description</th>
            <th>Location</th>
            <th>Status</th>
            <th>Wedding Date</th>
            <th>Date Created</th>
            <th>Date Published</th>
            <th>Tools</th>
        </tr>
    </thead>
  
    <tbody>
       <?php foreach ($event_wedding as $events) : ?>
        <tr>
            
            <td class="special"><?= trim_body($events->title, 30); ?></td>
          
            <td class="special"><?= trim_body($events->description, 20);  ?></td>
            
            <td class="special"><?= trim_body($events->location, 20); ?></td>
            
            <td class="special"><?= ($events->status == 0) ? 'Drafted' : 'Published'; ?></td>
            
            <td class="special"> <?= $events->wedding_date; ?></td>
            
            <td class="special"><?= $events->date_created; ?></td>
            <td class="special"><?= empty($events->date_published) ? 'Unpublished' : $events->date_published; ?></td>
            
            <td>
                <a href="blog_events_edit.php?id=<?= $events->id; ?>" class="btn btn-info btn-sm active"><i class="mdi mdi-account-edit"></i></a>
                <a href="blog_events_delete.php?id=<?= $events->id; ?>" class="btn btn-danger btn-sm active"><i class="mdi mdi-delete"></i></a>
                <a href="../wedding_details.php?id=<?= $events->id; ?>" target="_blank" class="btn btn-warning btn-sm active"><i class="mdi mdi-eye"></i></a>
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
        $('#example').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });

    
    
</script>

</body>
</html>