<?php include 'include/init.php'; ?>
<?php


    if (!isset($_SESSION['id'])) { redirect_to("../"); }

    $users = Users::find_by_id($_GET['id']);

    if (isset($_POST['submit'])) {
        $firstname   = clean($_POST['firstname']);
        $lastname    = clean($_POST['lastname']);
        $address     = clean($_POST['address']);
        $email       = clean($_POST['email']);
        $username    = clean($_POST['username']);
        $gender      = clean($_POST['gender']);
        $designation = clean($_POST['designation']);

         if (empty($firstname) || empty($lastname) || empty($address) || empty($email) || empty($username)) {
            redirect_to("users_add.php");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> Please Fill up all the information.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        if ($users) {
            $users->firstname = $firstname;
            $users->lastname = $lastname;
            $users->address = $address;
            $users->email = $email;
            $users->username = $username;
            $users->gender = $gender;
            $users->designation = $designation;
            // $users->date_created = date("F j, Y, g:i a"); 

            if(empty($_FILES['profile_picture'])) {
              $users->save();
               redirect_to("users.php");
              $session->message("The photo has been updated");
            } else {
              $users->set_file($_FILES['profile_picture']);
              $users->save_image();
              $users->save();
              redirect_to("users.php");
              $session->message("
                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                  <strong><i class='mdi mdi-check'></i></strong>The {$users->firstname} {$users->lastname} is successfully updated.
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>");
            }
        }
    }
?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add New User - Administrator</title>
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
        .custom-file-label {
            color: #212529;
        }
    </style>
</head>

<body>

<?php include_once 'include/sidebar.php'; ?>

<div class="container">

    <div class="row">

        <div class="col-lg-8 offset-2 pl-3 pb-3 box-shadow mt-4">
        
            <form method="post" action="" enctype="multipart/form-data">
            
                <h6 class="h6 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">Edit User Information
                    <a href="users.php" class="btn btn-sm btn-danger float-right" style="font-size: 12px;"><i class="mdi mdi-close-circle mr-2"></i> Cancel</a>

                    <button type="submit" name="submit" class="btn btn-sm btn-success float-right mr-2" style="font-size: 12px;"><i class="mdi mdi-account-plus mr-2"></i> Edit User</button>
                </h6>

                <?php
                    if ($session->message()) {
                        echo ' <div class="form-group col-md-12">' . $session->message() . '</div>';
                    }
                ?>

                <div class="text-center mb-3 mt-3">
                    <img src="<?= $users->profile_picture_picture(); ?>" style="border-radius: 50%; width: 300px;height: 300px;diplay:block;" alt="">
                       
                </div>
               <!--   <div class="form-group">
                    <label for="inputProfilePicture">Insert New Image</label>
                    <input type="file" name="profile_picture" class="form-control-file" id="inputProfilePicture">
                </div>
 -->
                <div class="custom-file mb-3" style="font-size: 13px;">
                  <input type="file" class="custom-file-input" id="customFile" name="profile_picture">
                  <label class="custom-file-label" for="customFile">Edit Profile Picture</label>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputFirstname">Firstname:</label>
                        <input type="text" name="firstname" class="form-control" value="<?= $users->firstname; ?>" id="inputFirstname"  placeholder="Enter firstname">
                    </div>
                   <div class="form-group col-md-6">
                        <label for="inputLastname">Lastname:</label>
                        <input type="text" name="lastname" class="form-control" value="<?= $users->lastname; ?>" id="inputLastname"  placeholder="Enter lastname">
                    </div>
                   
                </div>
                
                <div class="form-group">
                    <label for="inputEmail">Email:</label>
                    <input type="text" name="email" class="form-control"  value="<?= $users->email; ?>" id="inputEmail" placeholder="Enter email">
                </div>

                <div class="form-group">
                    <label for="inputUsername">Username:</label>
                    <input type="text" name="username" class="form-control"  value="<?= $users->username; ?>" id="inputUsername" placeholder="Enter username">
                </div>

                 <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select name="gender" class="custom-select" id="gender">
                            <?php if($users->gender == 'm') : ?>
                                <option value="m" selected>Male</option>
                                <option value="f">Female</option>
                            <?php else: ?>
                                <option value="m">Male</option>
                                <option value="f" selected>Female</option>
                            <?php endif; ?>
                        </select>
                    </div>

                <div class="form-group">
                    <label for="inputAddress">Address</label>
                    <textarea rows="5" name="address" class="form-control" id="inputAddress"  placeholder="Enter address"><?= $users->address;  ?></textarea>
                </div>

                 <div class="form-group">
                    <label for="designation">Designation:</label>
                    <select name="designation" id="designation" class="custom-select">
                        <?php if($users->designation == 0) : ?>
                            <option value="0" selected>Administrator</option>
                            <option value="1">Moderator</option>
                        <?php else: ?>
                            <option value="0">Administrator</option>
                            <option value="1" selected>Moderator</option>
                        <?php endif; ?>
                    </select>
                </div>
                  
            </form><!-- end of input form -->
        </div>
    </div>
</div>



<?php include_once 'include/footer.php';?>
