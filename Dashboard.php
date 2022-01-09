<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
isLogin();
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

    <title>المقالات</title>
</head>

<body>
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
                    <a href="Admins.php" class="nav-link">ادارة الحسابات</a>
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
                    <h1> <i class="fas fa-cog" style="color: #27aae1;"></i> لوحة التحكم </h1>
                </div>
                <div class="col-lg-3">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block  mb-2">
                        <i class="fas fa-edit"></i> اضف مقال
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="Categories.php" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-folder-plus"></i>اضف تصنيف
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="#" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-user-plus"></i>اضف مستخدم
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="#" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-check"></i>قبول التعليق
                    </a>
                </div>

            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Main Area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <!-- Left Side Area Start -->
            <div class="col-lg-2 d-none d-md-block">
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Posts</h1>
                        <h6 class="display-5">
                            <i class="fab fa-readme"></i>
                            <?php TotalPosts(); ?>
                        </h6>
                    </div>
                </div>

                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Categories</h1>
                        <h6 class="display-5">
                            <i class="fas fa-folder"></i>
                            <?php TotalCategories(); ?>
                        </h6>
                    </div>
                </div>

                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Admins</h1>
                        <h6 class="display-5">
                            <i class="fas fa-users"></i>
                            <?php TotalAdmins(); ?>
                        </h6>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Comments</h1>
                        <h6 class="display-5">
                            <i class="fas fa-comments"></i>
                            <?php TotalComments(); ?>
                        </h6>
                    </div>
                </div>

            </div>
            <!-- Left Side Area End -->
            <!-- Right Side Area Start -->
            <div class="col-lg-10">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <h1>اخر المقالات</h1>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>رقم.</th>
                            <th>العنوان</th>
                            <th>التاريخ</th>
                            <th>الكاتب</th>
                            <th>التعليقات</th>
                            <th>التفاصيل</th>
                        </tr>
                    </thead>
                    <?php
                    $SrNo = 0;
                    global $ConnectingDB;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,6";
                    $stmt = $ConnectingDB->query($sql);
                    while ($DataRows = $stmt->fetch()) {
                        $PostId = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $Author  = $DataRows["author"];
                        $Title = $DataRows["title"];
                        $SrNo++;
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo $SrNo; ?></td>
                                <td><?php echo $Title; ?></td>
                                <td><?php echo $DateTime; ?></td>
                                <td><?php echo $Author; ?></td>
                                <td>
                                    <?php $Total = ApproveCommentsAccordingtoPost($PostId);
                                    if ($Total > 0) {
                                    ?>
                                        <span class="badge  badge-success ">
                                            <?php
                                            echo $Total; ?>
                                        </span>
                                    <?php  }   ?>


                                    <?php $Total = DisApproveCommentsAccordingtoPost($PostId);
                                    if ($Total > 0) {  ?>
                                        <span class="badge  badge-danger ">
                                            <?php
                                            echo $Total; ?>
                                        </span>
                                    <?php  }  ?>
                                </td>
                                <td> <a target="_blank" href="FullPost.php?idd=<?php echo $PostId; ?>">
                                        <span class="btn btn-info">معاينة</span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    <?php  }  ?>
                </table>

            </div>
            <!-- Right Side Area End -->


        </div>
    </section>
    <!-- Main Area End -->


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