<?php
session_start();
include_once __DIR__ . '/../constants/user_roles.php';

if(!isset($_SESSION['isLogin']) && $_SESSION['isLogin'] !== true){
    header('location:login.php?notLogin'); die;
};

$user_role = $_SESSION['user_role'];
$isAuthorize = false;

if(isset(ROLES[$user_role])){
    foreach(ROLES[$user_role] as $role)
    if ($role === basename($_SERVER['REQUEST_URI'])) {
    $isAuthorize = true;
    break;
    }
}
if($isAuthorize !== true){
    header('location:login.php?notAuthorized'); die;
}