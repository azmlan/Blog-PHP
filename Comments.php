<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
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
    <title>التعليقات</title>
</head>

<body class="text-right">
    <!-- NAVBAR -->
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
    <div style="height:10px; background:#27aae1;"></div>
    <!-- NAVBAR END -->
    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 " style="text-align: right;">
                    <h1><i class="fas fa-comments" style="color:#27aae1;"></i> ادارة التعليقات</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->
    <!-- Main Area Start -->
    <section class="container text-right py-2 mb-4 ">
        <div class="row " style="min-height:30px;">
            <div class="col-lg-12" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <div style="text-align: right; width: 100%;">
                    <h2>التعليقات المعلّقة</h2>
                </div>
                <table class="table table-striped table-hover ">
                    <thead class="thead-dark">
                        <tr>
                            <th>رقم. </th>
                            <th>التاريخ</th>
                            <th>الاسم</th>
                            <th>التعليقات</th>
                            <th>قبول</th>
                            <th>اجراء</th>
                            <th>التفاصيل</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * from comments where status ='OFF'";
                    $stmt = $ConnectingDB->query($sql);
                    $snum = 0;
                    while ($data = $stmt->fetch()) {
                        $CommentId = $data['id'];
                        $date = $data['datetime'];
                        $CommenterName = $data['name'];
                        $CommentContent = $data['comment'];
                        $CommentPostId = $data['post_id'];
                        $snum++;

                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($snum); ?></td>
                                <td><?php echo htmlentities($date); ?></td>
                                <td><?php echo htmlentities($CommenterName); ?></td>
                                <td><?php echo htmlentities($CommentContent); ?></td>
                                <td> <a href="ApproveComments.php?idd=<?php echo $CommentId; ?>" class="btn btn-success">قبول</a> </td>
                                <td> <a href="DeleteComments.php?idd=<?php echo $CommentId; ?>" class="btn btn-danger">حذف</a> </td>
                                <td style="min-width:140px;"> <a class="btn btn-primary" href="FullPost.php?idd=<?php echo $CommentPostId; ?>" target="_blank">معاينة</a> </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
                <div style="text-align: right; width: 100%;">
                    <h2>التعليقات المقبولة</h2>
                </div>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>رقم. </th>
                            <th>التاريخ</th>
                            <th>الاسم</th>
                            <th>التعليق</th>
                            <th>قبول بواسطة </th>
                            <th>تراجع</th>
                            <th>اجراء</th>
                            <th>التفاصيل</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $CommentId         = $DataRows["id"];
                        $DateTimeOfComment = $DataRows["datetime"];
                        $CommenterName     = $DataRows["name"];
                        $ApprovedBy        = $DataRows["approvedby"];
                        $CommentContent    = $DataRows["comment"];
                        $CommentPostId     = $DataRows["post_id"];
                        $SrNo++;
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                                <td><?php echo htmlentities($CommenterName); ?></td>
                                <td><?php echo htmlentities($CommentContent); ?></td>
                                <td><?php echo htmlentities($ApprovedBy); ?></td>
                                <td style="min-width:140px;"> <a href="DisApproveComments.php?idd=<?php echo $CommentId; ?>" class="btn btn-warning">رفض</a> </td>
                                <td> <a href="DeleteComments.php?idd=<?php echo $CommentId; ?>" class="btn btn-danger">حذف</a> </td>
                                <td style="min-width:140px;"> <a class="btn btn-primary" href="FullPost.php?idd=<?php echo $CommentPostId; ?>" target="_blank">معاينة</a> </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </section>
    <!--  Main Area End -->
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