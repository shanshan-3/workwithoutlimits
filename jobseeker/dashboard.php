<?php
require_once '../includes/session.php';
require_once '../config/database.php';
require_once '../functions/user-functions.php';
include '../includes/header.php';

require_role('seeker');

$stmt = $pdo-> prepare("SELECT full_name FROM seeker_profiles WHERE users_id = ?");
$stmt-> execute([$_SESSION['user_id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$profile){
    header("Location: profile.php?setup=1");
    exit();
}
?>