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

    </style>
</head>

<body>

<?php include_once 'include/sidebar.php'; ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="h4 mt-4 ml-3">Services And Packages</h4>
     <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class="btn btn-md btn-success mr-2" style="font-size: 12px;" href="package_add.php"><i class="mdi mdi-buffer mr-2"></i> Add New Package</a>
        </div>
    </div>
</div>

<?php
    if ($session->message()) { 
        echo $session->message();
    }
?>

        <div class="col-md-12">
            <table id="example" class="table table-striped table-hover table-bordered table-sm" cellspacing="0" width="100%" style="background: white;padding: 5px">

                <thead>
                    <tr>
                        <th>Wedding Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
              
                <tbody>
                    <?php foreach ($category as $category_row) : ?>
                    <tr>
                        
                        <td class="special"><b><?= $category_row->wedding_type . ' Wedding Package';?></b></td>
                        <td class="special">KES <b><?= number_format($category_row->price, 2);?></b></td>
                        <td>

                            <a href="package_edit.php?id=<?= $category_row->id; ?>" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit This Package">
                                <i class="mdi mdi-pen"></i></a>

                            <a href="package_delete.php?id=<?= $category_row->id; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete This Package"><i class="mdi mdi-delete"></i></a>
                            <button type="button" name="view" value="view" id="<?= $category_row->id; ?>" class="btn btn-info btn-sm view_data">
                                <i class="mdi mdi-eye-outline"></i> 
                            </button>

                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
        </div><!-- end of col-md-12 -->

        <div class="col-md-12 mt-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h4 class="h4 mt-4 ml-3">Wedding Features</h4>
                 <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a class="btn btn-md btn-success mr-2" style="font-size: 12px;" href="feature_add.php"><i class="mdi mdi-clipboard-outline mr-2"></i> Add New Feature</a>
                    </div>
                </div>
            </div>

           <table id="features" class="table table-striped table-hover table-bordered table-sm" cellspacing="0" width="100%" style="background: white;padding: 5px;">
                <thead>
                    <tr>
                        <th>Wedding Type</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
             
                <tbody>
                    <?php foreach ($features as $features_row) : ?>
                    <tr>
                        
                        <td class="special"><?= $features_row->wedding_type;?></td>
                        <td class="special"><?= $features_row->title;?></td>
                        <td class="special"><?= trim_body($features_row->description);?></td>
                        <td>

                            <a href="feature_edit.php?id=<?= $features_row->feature_id; ?>" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit This feature">
                                <i class="mdi mdi-pen"></i></a>

                            <a href="feature_delete.php?id=<?= $features_row->feature_id; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete This feature"><i class="mdi mdi-delete"></i></a>

                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div><!-- end of col-md-12 -->




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
        $('#features').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
    
</script>


  <div id="dataModal" class="modal fade" tabindex="-1" role="dialog">  
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">  
           <div class="modal-content">  
                <div class="modal-header">  
                    <h4 class="modal-title">Package Features Details</h4>  
                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                </div>  
                <div class="modal-body" id="package_detail">  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  


<script>
     $(document).on('click', '.view_data', function(){  
           var id = $(this).attr("id");  
           if(id != '')  
           {  
                $.ajax({  
                     url:"select.php",  
                     method:"POST",  
                     data:{id:id},  
                     success:function(data){  
                          $('#package_detail').html(data);  
                          $('#dataModal').modal('show');  
                     }  
                });  
           }            
      }); 
</script>
</body>
</html>
