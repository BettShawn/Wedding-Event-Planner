<?php include 'include/init.php'; ?>
<?php


    if (!isset($_SESSION['id'])) { redirect_to("../"); }
    
    $booking_id = $_GET['booking_id'];
    $user_id = $_GET['user_id'];
    $budget_id = $_GET['budget_id'];
    $links='booking_id='.$booking_id.'&user_id='.$user_id;

    $luquidate =  Liquidation::find_by_id($budget_id);
    $events =  Events::find_all($booking_id);

    if (isset($_POST['submit'])) {

        $event_id = clean($_POST['event_id']);
        $payment = clean($_POST['payment']);
        $cash = clean($_POST['cash']);

        if( $payment < $cash) {
            redirect_to("budget_edit.php?$links&budget_id=$budget_id");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> Please check your cash detailed.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

         if (empty($event_id) || empty($payment)) {
            redirect_to("budget_edit.php?$links&budget_id=$budget_id");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> Please Fill up all the information.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        } else {
             $luquidate->event_id = $event_id;
             $luquidate->payment = $payment;
             $luquidate->cash = $cash;
             $luquidate->credit = $payment - $cash;
             $luquidate->booking_id = $booking_id;
             $luquidate->user_id = $user_id;
             $luquidate->date_modified = date("F j, Y, g:i a");
             $luquidate->save();
             redirect_to("budget_edit.php?$links&budget_id=$budget_id");
             $session->message("
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-check'></i></strong> Successfully added.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
         }
    }
?>

<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add New Events - Administrator</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <style>
            body {
                margin-bottom: 2%;
            }
            .box-shadow {
                box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.3);
                font-size: 12px;
            }
            .form-control {
                font-size: 12px;
            }
            
        </style>
    </head>

<body>

<?php include_once 'include/sidebar.php'; ?>

    <div class="container">

        <div class="row">

            <div class="col-lg-8 offset-2 pl-3 pb-3 box-shadow mt-4">
            
                <form method="post" action="">

                    <h4 class="h4 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">Luquidation for
                        <span class="text-right"><a href="budget.php?<?=$links; ?>" class="btn btn-sm btn-light active float-right" style="font-size: 12px;">Back</a></span>
                    </h4>

                    <?= ($session->message()) ? $session->message() : ''; ?>

                     <div class="form-group">
                        <label for="event_id">Event To Related:</label>
                        <select class="custom-select form-control" id="event_id" name="event_id">
                          <?php foreach($events as $events_title) : ?>
                                <?php if($events_title->id == $luquidate->event_id) : ?>
                                    <option value="<?= $events_title->id; ?>" selected><?= ucfirst($events_title->title); ?></option>
                                <?php else : ?>
                                    <option value="<?= $events_title->id; ?>"><?= ucfirst($events_title->title); ?></option>
                                <?php endif;?>
                          <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="payment">Payment:</label>
                        <input type="text" name="payment" class="form-control" value="<?= $luquidate->payment; ?>" id="payment"  placeholder="Payment">
                    </div>

                    <div class="form-group">
                        <label for="cash">Cash:</label>
                        <input type="text" name="cash" class="form-control" id="cash" value="<?= $luquidate->cash; ?>"  placeholder="Cash">
                    </div>


                    <a href="budget.php?<?=$links; ?>" class="btn btn-sm btn-danger float-right" style="font-size: 12px;">Cancel</a>
                    <button type="submit" name="submit" class="btn btn-sm btn-light float-right mr-2" style="font-size: 12px;">Modify</button>

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
</body>
</html>