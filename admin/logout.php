<?php
/**
 * Created by PhpStorm.
 * User: ACLC
 * Date: 2/20/2018
 * Time: 3:36 AM
 */
session_start();
session_unset();
session_destroy();
header("Location: login.php");