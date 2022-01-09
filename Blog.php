<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>المدونة</title>
    <style media="screen">
        .heading {
            font-family: Bitter, Georgia, "Times New Roman", Times, serif;
            font-weight: bold;
            color: #005E90;
        }

        .heading:hover {
            color: #0090DB;
        }
    </style>
</head>

<body class="text-right">
    <!-- NAVBAR -->
    <div style="height:10px; background:#27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand"> azmlan.com</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="Login.php" class="nav-link"><i class="fas fa-user-alt"></i> </a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">من نحن</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">المدونة</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">تواصل معنا</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form class="form-inline d-none d-sm-block" action="Blog.php">
                        <div class="form-group">
                            <input class="form-control ml-2" type="text" name="search" placeholder="ابحث هنا " value="">
                            <button class="btn btn-primary" name="searchButton">بحث</button>
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height:10px; background:#27aae1;"></div>
    <!-- NAVBAR END -->
    <!-- HEADER -->
    <div class="container">
        <div class="row mt-4">

            <!-- Main Area Start-->
            <div class="col-sm-8 ">
                <h1>مدونة مع ادرة المحتوى</h1>
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <h1 class="lead">مدونة مع ادارة محتوى باستخدام PHP تم برمجتها بواسطة عبدالعزيز ملفي </h1>
                <?php
                // if using php6 of less 
                // u should use global for the connection
                global $ConnectingDB;

                if (isset($_GET['searchButton'])) {
                    $search = $_GET['search'];
                    $sql = "SELECT * FROM posts WHERE
                    datetime LIKE :pSearch OR
                    author LIKE :pSearch OR
                    title LIKE :pSearch OR
                    category LIKE :pSearch OR
                    post LIKE :pSearch
                    ";
                    $stmt = $ConnectingDB->prepare($sql);
                    // هذي(٪)  تعني ان 
                    // ابحث عن اي شي بمحرك البحث ومايهم الي قبل او بعد كلمة البحث المكتوبة
                    $stmt->bindValue(':pSearch', "%" . $search . "%");
                    $stmt->execute();
                } elseif (isset($_GET['page'])) {
                    $Page = $_GET['page'];
                    if ($Page == 0 || $Page < 0) {
                        $showPostFrom = 0;
                    } else {
                        $showPostFrom = ($Page * 5) - 5;
                    }
                    $sql = "SELECT * from posts order by id desc limit $showPostFrom,5";
                    $stmt = $ConnectingDB->query($sql);
                } elseif (isset($_GET['category'])) {
                    $postCategory = $_GET['category'];
                    $sql = "SELECT * from posts where category =:cName ORDER BY id desc";
                    $stmt = $ConnectingDB->prepare($sql);
                    $stmt->bindValue(":cName", $postCategory);
                    $stmt->execute();
                }
                // Blog without search or pagination
                else {
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
                    $stmt = $ConnectingDB->query($sql);
                }
                while ($data = $stmt->fetch()) {
                    # code...
                    $id = $data['id'];
                    $date = $data['datetime'];
                    $category = $data['category'];
                    $author = $data['author'];
                    $postTitle = $data['title'];
                    $postDetails = $data['post'];
                    $image = $data['img'];

                ?>
                    <div class="card text-right">
                        <!-- <img src="Images/<?php echo htmlentities($image); ?>" style="max-height:450px;" class="img-fluid card-img-top" /> -->
                        <img src="Images/img.png" style="max-height:450px;" class="img-fluid card-img-top" />
                        <div class="card-body">
                            <h4 class="card-title"><?php echo htmlentities($postTitle); ?></h4>
                            <small class="text-muted"><span class="text-dark"> <a> </a></span> كتبت بواسطة : <span class="text-white badge badge-info mx-1"> <a href="Profile.php?username=<?php echo htmlentities($author) ?>"> <?php echo htmlentities($author) ?></a></span></small>
                            <small class="text-muted"><span class="text-dark"> <a> </a></span> التصنيف<span class=" mx-1">( <?php echo htmlentities($category) ?> )<a></a></span>

                                كتبت في <?php echo htmlentities($date); ?></small>

                            <br>
                            <div class="badge badge-dark text-light">
                                التعليقات
                                <?php
                                echo ApproveCommentsAccordingtoPost($id);
                                ?>

                            </div>
                            <hr>
                            <p class="card-text">
                                <?php if (strlen($postDetails) > 150) {
                                    $postDetails = substr($postDetails, 0, 150) . "...";
                                }


                                ?>
                                <?php echo htmlentities($postDetails); ?>
                            </p>
                            <a href="FullPost.php?idd=<?php echo $id ?>" style="float:right;">
                                <span class="btn btn-info">المزيد &rang;&rang; </span>
                            </a>
                        </div>
                    </div>
                    <br>
                <?php } ?>

                <!-- Pagination  Start -->
                <nav>

                    <ul class="pagination pagination-lg">
                        <!--  Backward Button Start-->
                        <?php
                        if (isset($Page)) {
                            if ($Page > 1) {
                        ?>
                                <a class="page-link " style="text-align:right" href="Blog.php?page=<?php echo $Page - 1; ?>">&laquo;</a>
                        <?php  }
                        } ?>
                        <!--  Backward Button End-->

                        <?php
                        global $ConnectingDB;
                        $sql = "SELECT count(*) from posts";
                        $stmt = $ConnectingDB->query($sql);
                        $allPosts = $stmt->fetch();
                        $totalPosts = array_shift($allPosts);
                        $postPagination = $totalPosts / 5;
                        $postPagination = ceil($postPagination);

                        for ($i = 1; $i <= $postPagination; $i++) {
                            # code...
                            if (isset($Page)) {
                                if ($i == $Page) {
                        ?>

                                    <li class="page-item active ">
                                        <a class="page-link" href="Blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php } else { ?>

                                    <li class="page-item">
                                        <a class="page-link" href="Blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>

                                    </li>
                                <?php } ?>
                        <?php }
                        } ?>
                        </li>
                        <!-- Back Botton start -->
                        <?php
                        if (isset($Page) && !empty($Page) && $Page >= 0) {
                            if ($Page + 1 <= $postPagination) {
                        ?>
                                <a class="page-link " style="text-align:right" href="Blog.php?page=<?php echo $Page + 1; ?>">&raquo;</a>
                        <?php  }
                        } ?>
                        <!-- Back Botton End -->
                    </ul>
                </nav>
                <!-- Pagination  END -->
            </div>
            <!-- Main Area End-->
            <?php require_once("footerSide.php") ?>