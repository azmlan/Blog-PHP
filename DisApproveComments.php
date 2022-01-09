<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if (isset($_GET['idd'])) {
    $searchQueryParameter = $_GET['idd'];
    $admin = $_SESSION['AdminName'];

    global $ConnectingDB;
    $sql = "UPDATE comments set status = 'OFF' , approvedby='$admin' where id ='$searchQueryParameter' ";
    $execute = $ConnectingDB->query($sql);

    if ($execute) {
        $_SESSION['successMessage'] = 'تم رفض التعليق بنجاح';
        redirect_to("Comments.php");
    } else {
        $_SESSION['errorMessage'] = 'حدث خطا اثناء محاولة رفض التعليق';
        redirect_to("Comments.php");
    }
}

?>