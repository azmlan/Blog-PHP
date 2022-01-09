<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
isLogin(); ?>
<?php
$SearchQueryParameter = $_GET['idd'];
if (isset($_POST["Submit"])) {
    $postTitle = $_POST["postTitle"];
    $postCategory = $_POST["category"];
    $image = $_FILES["Image"]["name"];
    $target  = "Uploads/" . basename($_FILES["Image"]["name"]);
    $postDetails = $_POST["postDetails"];
    $Admin = "Aziz";

    date_default_timezone_set("Asia/Riyadh");
    $currentTiem = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTiem);


    if (empty($postTitle)) {
        $_SESSION["errorMessage"] = "هنالك حقول فارغة";
        redirect_to("Posts.php");
    } elseif (strlen($postTitle) < 2) {
        $_SESSION["errorMessage"] = "عنوان المقال يجب ان يكون حرفين على الاقل";
        redirect_to("Posts.php");
    } elseif (strlen($postText) > 999) {
        $_SESSION["errorMessage"] = "لاحد الاقًصى ٩٩٩ حرف";
        redirect_to("Posts.php");
    } else {
        // Query to Update Post in DB When everything is fine
        global $ConnectingDB;
        if (!empty($_FILES["Image"]["name"])) {
            $sql = "UPDATE posts
              SET title='$postTitle', category='$postCategory', image='$image', post='$postDetails'
              WHERE id='$SearchQueryParameter'";
        } else {
            $sql = "UPDATE posts
              SET title='$postTitle', category='$postCategory', post='$postDetails'
              WHERE id='$SearchQueryParameter'";
        }
        $execute = $ConnectingDB->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        //var_dump($Execute);
        if ($execute) {
            $_SESSION["SuccessMessage"] = "تم تحديث المقال بنجاح";
            Redirect_to("Posts.php");
        } else {
            $_SESSION["ErrorMessage"] = "حدث خطأ !";
            Redirect_to("Posts.php");
        }
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
                    <h1> <i class="fas fa-edit" style="color: #27aae1;"></i> تعديل المقال </h1>
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
                // Fetching Existing Content according to our
                global $ConnectingDB;
                $sql  = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
                $stmt = $ConnectingDB->query($sql);
                while ($DataRows = $stmt->fetch()) {
                    $updatedTitle    = $DataRows['title'];
                    $CategoryToBeUpdated = $DataRows['category'];
                    $ImageToBeUpdated    = $DataRows['image'];
                    $PostToBeUpdated     = $DataRows['post'];
                    // code...
                }
                ?>
                <form class="" action="EditPost.php?idd=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"> عنوان المقال: </span></label>
                                <input type="text" class="form-control" name="postTitle" title="postTitle" value="<?php echo $updatedTitle; ?>">
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo text-warning">التصنيف السابق:

                                    <?php echo $CategoryToBeUpdated; ?>
                                </span>
                                <br>
                                <label for="CategoryTitle"> <span class="FieldInfo"> اختر تصنيف </span></label>
                                <select class="form-control" id="CategoryTitle" name="category">
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
                                <span class="FieldInfo">الصورة السابقة: </span>
                                <img class="mb-1" src="Uploads/<?php echo $ImageToBeUpdated; ?>" width="170px" ; height="70px" ;>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">اختر صورة </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Post"> <span class="FieldInfo"> المقال: </span></label>
                                <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
                <?php echo $PostToBeUpdated; ?>
              </textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Posts.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> عودة</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> تعديل
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
    </script>
</body>

</html>