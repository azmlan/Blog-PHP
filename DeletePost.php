<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
isLogin(); ?>


<?php
$SearchQueryParameter = $_GET['idd'];
global $ConnectingDB;
$sql  = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
    $updatedTitle    = $DataRows['title'];
    $CategoryToBeDeleted = $DataRows['category'];
    $ImageToBeDeleted    = $DataRows['image'];
    $PostToBeDeleted     = $DataRows['post'];

    // code...
}
if (isset($_POST["Submit"])) {

    // Fetching Existing Content according to our
    // Query to Update Post in DB When everything is fine 
    $sql = "DELETE FROM posts where id='$SearchQueryParameter'";
    $execute = $ConnectingDB->query($sql);
    //var_dump($Execute);
    if ($execute) {
        $TargetToDeleteImage = "Uploads/$ImageToBeDeleted";
        unlink($TargetToDeleteImage);
        $_SESSION["successMessage"] = "تم حذف المقال رقم " . $SearchQueryParameter . " بنجاح ";
        Redirect_to("Posts.php");
    } else {
        $_SESSION["errorMessage"] = "حدث خطأ !";
        Redirect_to("Posts.php");
    }
} //Ending of Submit Button If-Condition
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- // FontAwesome -->
    <script src="https://kit.fontawesome.com/1ca8c65076.js" crossorigin="anonymous"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <title>اضافة مقال جديد </title>
</head>

<body class="text-right">
    <div style="height:10px; background:#27aae1;"></div>
    <nav class="navbar navbar-expand-lg bg-dark p-4">
        <div class="container-fluid ">
            <a href="#" class="navbar-brand">www.azmlan.com</a>
            <ul class="navbar nav  ml-auto">
                <li class="nav-item">
                    <a href="MyProfile.php" class="nav-link"><i class="fas fa-user-alt"></i> حسابي</a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link">لوحة التحكم</a>
                </li>
                <li class="nav-item">
                    <a href="Posts.php" class="nav-link">المنشورات</a>
                </li>
                <li class="nav-item">
                    <a href="Categories.php" class="nav-link">التصنيفات</a>
                </li>
                <li class="nav-item">
                    <a href="ManageAdmins.php" class="nav-link">ادارة الحسابات</a>
                </li>
                <li class="nav-item">
                    <a href="Comments.php" class="nav-link">التعليقات</a>
                </li>
                <li class="nav-item">
                    <a href="LiveBlogs.php?page=1" class="nav-link">مقالات نشطة</a>
                </li>
            </ul>
            <ul class="navbar nav mr-auto">
                <li class="nav-item text-danger">
                    <a class="nav-link" href="Logout.php"><i class="fas fa-sign-out-alt"></i> خروج</a>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <!-- Navbar Ends  -->

    <!-- Header Start -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1> <i class="fas fa-trash" style="color: #27aae1;"></i> حذف المقال </h1>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!-- Main Area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();

                ?>
                <form class="" action="DeletePost.php?idd=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"> عنوان المقال: </span></label>
                                <input type="text" class="jsDisable form-control " name="postTitle" title="postTitle" value="<?php echo $updatedTitle; ?>">
                            </div>
                            <div class="form-group">

                                <br>
                                <label for="CategoryTitle"> <span class="FieldInfo"> اختر تصنيف </span></label>
                                <select class="form-control jsDisable" id="CategoryTitle" name="category">
                                    <?php
                                    //Fetchinng all the categories from category table
                                    global $ConnectingDB;
                                    $sql  = "SELECT id,title FROM category";
                                    $stmt = $ConnectingDB->query($sql);
                                    while ($DataRows = $stmt->fetch()) {
                                        $Id            = $DataRows["id"];
                                        $CategoryName  = $DataRows["title"];
                                    ?>
                                        <option> <?php echo $CategoryName; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form=group mb-1">
                                <span class="FieldInfo">الصورة : </span>
                                <img class="mb-1 " src="Uploads/<?php echo $ImageToBeDeleted; ?>" width="170px" ; height="70px" ;>
                                <div class="custom-file">
                                    <input class="jsDisable custom-file-input" type="File" name="Image" id="imageSelect" value="">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Post"> <span class="FieldInfo"> المقال: </span></label>
                                <textarea class="form-control jsDisable" id="Post" name="PostDescription" rows="8" cols="80">
                <?php echo $PostToBeDeleted; ?>
              </textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Posts.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> عودة</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>



    <!-- End Main Area -->
    <!-- FOOTER -->
    <!-- Footer Start -->
    <footer class="bg-dark text-white">
        <div class="container ">
            <div class="row">
                <div class="col">
                    <p class="lead text-center tt"> تم تطوير الموقع بواسطة | عبدالعزيز | <span id="year"></span> &copy; ----- جميع الحقوق محفوظة </p>
                    <p class="text-center">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae asperiores eligendi corrupti odio, quisquam labore aliquam rerum! Ipsa, voluptates atque voluptate officia modi saepe quibusdam placeat quam error facere accusantium!
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <div style="height:10px; background:#27aae1;"></div>
    <!-- FOOTER END-->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());

        var dis = document.getElementsByClassName("jsDisable");
        for (var i = 0; i < dis.length; i++) {
            dis[i].disabled = true;
        }
    </script>
</body>

</html>