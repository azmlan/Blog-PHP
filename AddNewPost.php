<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
isLogin(); ?>
<?php
if (isset($_POST["submit"])) {
    $postTitle = $_POST["postTitle"];
    $postCategory = $_POST["category"];
    $image = $_FILES["image"]["name"];
    $target  = "Uploads/" . basename($_FILES["image"]["name"]);
    $postDetails = $_POST["postDetails"];
    $Admin = $_SESSION['UserName'];

    date_default_timezone_set("Asia/Riyadh");
    $currentTiem = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTiem);

    if (empty($postTitle)) {
        $_SESSION['errorMessage'] = 'يجب ملئ الحقول الفارغة  ';
        redirect_to("AddNewPost.php");
    }
    // strlrn -> طول السترنق
    elseif (strlen($postTitle) < 2) {
        $_SESSION['errorMessage'] = 'يجب ان يتكون العنوان من حرفين على الاقل و٥٠ حرف كحد اقصى';
        redirect_to("AddNewPost.php");
    } elseif (strlen($postDetails) > 9999) {
        $_SESSION['errorMessage'] = 'يجب ان يتكون المقال من حرفين على الاقل و ٩٩٩ حرف كحد اقصى';
        redirect_to("AddNewPost.php");
    } else {
        // Query to insert Post in DB When everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO posts(datetime,author,title,category,img,post)";
        // here using PDO name parameter to pass dummy vlaues to prevent the SQL injection;
        $sql .= "VALUES(:pDateTime,:pAuthor,:pTitle,:pCategory,:pimg,:pPost)";
        // Prepares an SQL statement to be executed by the PDOStatement::execute() method.
        // -> this is mean we using PDO opject notation;
        $stmt = $ConnectingDB->prepare($sql);
        // now after prepare() we will bind the dummy values to real values;
        $stmt->bindValue(':pDateTime', $DateTime);
        $stmt->bindValue(':pAuthor', $Admin);
        $stmt->bindValue(':pTitle', $postTitle);
        $stmt->bindValue(':pCategory', $postCategory);
        $stmt->bindValue(':pimg', $image);
        $stmt->bindValue(':pPost', $postDetails);
        // Now the Execution , every PDO prepared statment should use execution method;
        $execute = $stmt->execute();
        move_uploaded_file($_FILES["image"]["tmp_name"], $target);
        if ($execute) {
            $_SESSION['successMessage'] = "تم بنجاح اضافة المقال برقم الاي دي : " . $ConnectingDB->lastInsertId() . "  ";
            redirect_to('AddNewPost.php');
        } else {
            $_SESSION['errorMessage'] = 'حدث خطأ عند التنفيذ';
            redirect_to('AddNewPost.php');
        }
    }
};

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
                    <a href="Posts.php" class="nav-link">المقالات</a>
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
                    <h1> <i class="fas fa-edit" style="color: #27aae1;"></i> اضافة مقال </h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Main Area  Start-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8 " style="min-height:400px;">
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="postTitle"><span class="FieldInfo"> عنوان المقال : </span></label>
                                <input type="text" class="form-control" name="postTitle" id="postTitle" placeholder="اكتب عنوان المقال ">
                            </div>
                            <div class="form-group">
                                <label for=""><span class="FieldInfo"> اختر تصنيف : </span></label>
                                <select class="form-control" name="category" id="idCategory">
                                    <?php
                                    // if using php <= 5 u should use (global)
                                    global $ConnectingDB;
                                    $sql = "SELECT id, title FROM category";
                                    $stmt = $ConnectingDB->query($sql);
                                    while ($data = $stmt->fetch()) {
                                        # code...
                                        $id = $data['id'];
                                        $categoryTitle = $data['title'];
                                    ?>
                                        <option><?php echo $categoryTitle ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <label for="idimg" class="custom-file-label">اختر صورة </label>
                                    <input class="custom-file-input" type="File" name="image" id="idimg" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="post">مقال : </label>
                                <textarea name="postDetails" class="form-control" id="idPostDetails" cols="30" rows="10"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-primary btn-block"> <i class="fas fa-arrow-right"></i> رجوع الى لوحة التحكم </a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"> اضافة </i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </section>
    <!-- Main Area End-->

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
    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.rtlcss.com/bootstrap/v4.5.3/js/bootstrap.bundle.min.js" integrity="sha384-40ix5a3dj6/qaC7tfz0Yr+p9fqWLzzAXiwxVLt9dw7UjQzGYw6rWRhFAnRapuQyK" crossorigin="anonymous"></script>
    <script>
        $("#year").text(new Date().getFullYear());
    </script>
</body>

</html>