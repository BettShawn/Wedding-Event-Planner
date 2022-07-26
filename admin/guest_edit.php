<?php include 'include/init.php'; ?>
<?php

    $booking_id = $_GET['booking_id'];
    $user_id = $_GET['user_id'];
    $id = $_GET['id'];
    $links='id='.$id.'&booking_id='.$booking_id.'&user_id='.$user_id;

    if (!isset($_SESSION['id'])) { redirect_to("../"); }

    
    $guest_query = Guest::find_by_id($id);

    if (isset($_POST['submit'])) {

        $fullname = clean($_POST['fullname']);
        $guestname = clean($_POST['guestname']);
        $address = clean($_POST['address']);
        $city = clean($_POST['city']);
        $state = clean($_POST['state']);
        $zipcode = clean($_POST['zipcode']);
        $priority = clean($_POST['priority']);
        $out_of_town = clean($_POST['out_of_town']);
        $relationship = clean($_POST['relationship']);
        $gifts = clean($_POST['gifts']);

         if (empty($fullname) || empty($guestname) || empty($address) || empty($city) || empty($state) || empty($zipcode) || empty($priority) || empty($out_of_town) || empty($relationship)) {
            redirect_to("guest_edit.php?$links");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> Please Fill up all the information.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        if ($guest_query) {
            $guest_query->fullname = $fullname;
            $guest_query->guestname = $guestname;
            $guest_query->address = $address;
            $guest_query->city = $city;
            $guest_query->state = $state;
            $guest_query->zipcode = $zipcode;
            $guest_query->priority = $priority;
            $guest_query->out_of_town = $out_of_town;
            $guest_query->relationship = $relationship;
            $guest_query->tracks_and_gifts = $gifts;
            $guest_query->update();
            redirect_to("guest_list.php?$links");
            $session->message("
                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                  <strong><i class='mdi mdi-check'></i></strong> {$guest_query->fullname} is successfully updated.
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
        <title>Edit Client Information - Administrator</title>
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

<?php include_once 'include/sidebar.php'; ?>

    <div class="container">

        <div class="row">

            <div class="col-lg-8 offset-2 pl-3 pb-3 box-shadow mt-4">
            
                <form method="post" action="">

                    <h4 class="h4 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">Edit Guest Information
                        <a href="guest_list.php?<?= $links;?>" class="btn btn-sm btn-danger float-right" style="font-size: 12px;"><i class="mdi mdi-close-circle mr-2"></i> Cancel</a>

                        <button type="submit" name="submit" class="btn btn-sm btn-success float-right mr-2" style="font-size: 12px;"><i class="mdi mdi-account-edit mr-2"></i> Edit</button>
                    </h4>

                    <?php
                        if ($session->message()) {
                            echo ' <div class="form-group col-md-12">' . $session->message() . '</div>';
                        }
                    ?>

                    <div class="form-group">
                        <label for="inputfullname">Fullname</label>
                        <input type="text" name="fullname" class="form-control" id="inputfullname"  placeholder="Enter fullname" value="<?= $guest_query->fullname; ?>">
                       
                    </div>


                    <div class="form-group">
                        <label for="inputGuestname">Guest Name</label>
                        <input type="text" name="guestname" class="form-control" id="inputGuestname" placeholder="Enter guestname" value="<?= $guest_query->guestname; ?>">
                    </div>

                     <div class="form-group">
                            <label for="relationship">Relationship</label>
                            <select name="relationship" class="form-control" id="relationship">
                                <?php 
                                    if ($guest_query->relationship == 'b') {
                                        echo '<option value="b" selected>Bride</option>';
                                        echo '<option value="g">Groom</option>';
                                    } else {
                                        echo '<option value="b">Bride</option>';
                                        echo '<option value="g" selected>Groom</option>';
                                    }
                                ?>
                            </select>
                        </div>

                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <textarea rows="5" name="address" class="form-control" id="inputAddress"  placeholder="Enter address"><?= $guest_query->address; ?></textarea>
                    </div>

                    <div class="form-row">
                         <div class="form-group col-md-6">
                            <label for="inputPriority">Priority Type</label>
                            <select name="priority" id="inputPriority" class="form-control">
                                <?php 
                                    if ($guest_query->priority == 'A') {
                                        echo '<option value="A" selected>A</option>
                                              <option value="B">B</option>
                                              <option value="C">C</option>
                                              <option value="D">D</option>
                                              <option value="E">E</option>';
                                    }
                                    if ($guest_query->priority == 'B') {
                                        echo '<option value="A">A</option>
                                              <option value="B" selected>B</option>
                                              <option value="C">C</option>
                                              <option value="D">D</option>
                                              <option value="E">E</option>';
                                    }
                                    if ($guest_query->priority == 'C') {
                                        echo '<option value="A">A</option>
                                              <option value="B">B</option>
                                              <option value="C" selected>C</option>
                                              <option value="D">D</option>
                                              <option value="E">E</option>';
                                    }
                                    if ($guest_query->priority == 'D') {
                                        echo '<option value="A">A</option>
                                              <option value="B">B</option>
                                              <option value="C">C</option>
                                              <option value="D" selected>D</option>
                                              <option value="E">E</option>';
                                    }
                                    if ($guest_query->priority == 'E') {
                                        echo '<option value="A">A</option>
                                              <option value="B">B</option>
                                              <option value="C">C</option>
                                              <option value="D">D</option>
                                              <option value="E" selected>E</option>';
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputOutOfTown">Out Of Town</label>
                            <select class="form-control" id="inputOutOfTown" name="out_of_town">
                                <?php 
                                    if ($guest_query->out_of_town == 'y') {
                                        echo '<option value="y" selected>Yes</option>
                                              <option value="n">No</option>';
                                    } else {
                                        echo '<option value="y">Yes</option>
                                              <option value="n" selected>No</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputstate">City</label>
                            <input value="<?= $guest_query->city; ?>" type="text" name="city" class="form-control" id="inputstate" placeholder="Enter state">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputstate">State</label>
                            <input type="text" name="state" class="form-control" id="inputstate" placeholder="Enter state" value="<?= $guest_query->state; ?>">
                        </div>


                        <div class="form-group col-md-4">
                            <label for="inputZipcode">Zipcode</label>
                            <input type="text" name="zipcode" class="form-control" id="inputZipcode" placeholder="Enter zipcode" value="<?= $guest_query->zipcode; ?>">
                        </div>

                       

                    </div>

                    <div class="form-group">
                        <label for="inputgift">Track Gifts &amp; Thank you's</label>
                        <textarea rows="5" name="gifts" class="form-control" id="inputgift"  placeholder="Enter address"><?= $guest_query->tracks_and_gifts; ?></textarea>
                    </div>

                </form><!-- end of input form -->
            </div>
        </div>
    </div>



<?php include_once 'include/footer.php';?>
