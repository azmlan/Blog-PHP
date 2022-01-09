<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if (isset($_GET['idd'])) {
    $searchQueryParameter = $_GET['idd'];
    $admin = $_SESSION['AdminName'];

    global $ConnectingDB;
    $sql = "DELETE from admins where id ='$searchQueryParameter' ";
    $execute = $ConnectingDB->query($sql);

    if ($execute) {
        $_SESSION['successMessage'] = 'تم حذف المستخدم بنجاح';
        redirect_to("Admins.php");
    } else {
        $_SESSION['errorMessage'] = 'حدث خطا اثناء محاولة حذف المستخدم';
        redirect_to("Admins.php");
    }
}

?>