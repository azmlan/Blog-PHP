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
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1> <i class="fas fa-blog" style="color: #27aae1;"></i> المقالات </h1>
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
    <?php echo errorMessage(); ?>
    <?php echo successMessage(); ?>
    <section class="container-fluid py-2 mb-4">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>#</th>
                            <th>العنوان</th>
                            <th>التصنيف</th>
                            <th>التاريخ والوقت</th>
                            <th>الكاتب </th>
                            <th>الواجهة</th>
                            <th>التعليقات</th>
                            <th>الافعال</th>
                            <th>معاينة </th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM posts";
                    $stmt = $ConnectingDB->query($sql);
                    $sr = 0;
                    while ($data = $stmt->fetch()) {
                        # code...
                        $id = $data['id'];
                        $date = $data['datetime'];
                        $category = $data['category'];
                        $author = $data['author'];
                        $postTitle = $data['title'];
                        $postDetails = $data['post'];
                        $image = $data['img'];
                        $sr++;

                    ?>
                        <tbody>
                            <tr>
                                <!-- There is tow ways to truncte the text (php and bootstrap)
                                oneway in the postTitle 
                                the the another in the rest of the td tags -->
                                <td><?php echo $sr ?></td>
                                <td><span class="d-inline-block text-truncate" style="max-width: 100px;">
                                        <?php
                                        echo $postTitle;
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo substr($category, 0, 13);
                                    if (strlen($category) > 13) {
                                        echo " <span class='text-dark'> ..... </span> ";
                                    }
                                    ?></td>
                                <td><?php echo $date ?></td>
                                <td><?php
                                    echo substr($author, 0, 5);
                                    if (strlen($author) > 5) {
                                        echo " <span class='text-dark'> ..... </span> ";
                                    }

                                    ?></td>
                                <td><img src="Uploads/<?php echo $image; ?>" width="130px" height="40px" /></td>
                                <!-- التعليقات -->
                                <td>
                                    <div class="row d-flex justify-content-around ">

                                        <div class="align-self-end">


                                            <?php $Total = ApproveCommentsAccordingtoPost($id);
                                            if ($Total > 0) {
                                            ?>
                                                <span class="badge  badge-success ">
                                                    <?php
                                                    echo $Total; ?>
                                                </span>
                                            <?php  }   ?>
                                        </div>
                                        <div class="align-self-start">
                                            <?php $Total = DisApproveCommentsAccordingtoPost($id);
                                            if ($Total > 0) {  ?>
                                                <span class="badge  badge-danger ">
                                                    <?php
                                                    echo $Total; ?>
                                                </span>
                                            <?php  }  ?>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <a href="EditPost.php?idd=<?php echo $id; ?>" class="btn btn-warning">تعديل</a>
                                    <a href="DeletePost.php?idd=<?php echo $id; ?>" class="btn btn-danger">حذف</a>
                                </td>
                                <td><a href="FullPost.php?idd=<?php echo $id ?>" target="_blank"><span class="btn btn-primary">معاينة</span></a></td>
                            <?php } ?>
                            </tr>
                        </tbody>

                </table>
            </div>
        </div>
    </section>
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