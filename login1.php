<?php include_once 'admin/include/init.php';?>
<?php
if (isset($_POST['login'])) {
    $input_email = $_POST['email'];
    $input_password = $_POST['password'];
    $logged = Accounts::login_user($input_email, $input_password);
    echo $logged;
}
?>