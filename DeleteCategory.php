<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if (isset($_GET['idd'])) {
    $searchQueryParameter = $_GET['idd'];
    $admin = $_SESSION['AdminName'];

    global $ConnectingDB;
    $sql = "DELETE from category where id ='$searchQueryParameter' ";
    $execute = $ConnectingDB->query($sql);

    if ($execute) {
        $_SESSION['successMessage'] = 'تم حذف التصنيف بنجاح';
        redirect_to("Categories.php");
    } else {
        $_SESSION['errorMessage'] = 'حدث خطا اثناء محاولة حذف التصنيف';
        redirect_to("Categories.php");
    }
}

?>