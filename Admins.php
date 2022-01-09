<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
isLogin(); ?>
<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $Admin = $_SESSION['UserName'];
    date_default_timezone_set("Asia/Riyadh");
    $currentTiem = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTiem);

    if (empty($username) || empty($password) || empty($confirmPassword) || empty($name)) {
        $_SESSION['errorMessage'] = 'يجب ملئ جميع الحقول';
        redirect_to("Admins.php");
    } elseif (strlen($name) < 2) {
        $_SESSION['errorMessage'] = 'الاسم يجب ان يكون حرفين على الاقل';
        redirect_to("Admins.php");
    } elseif ($password !== $confirmPassword) {
        $_SESSION['errorMessage'] = 'كلمات المرور ليست متطابقة';
        redirect_to("Admins.php");
    } elseif (checkUserNameExist($username)) {
        $_SESSION['errorMessage'] = 'يوجد مستخدم بهذا الاسم';
        redirect_to("Admins.php");
    } else {
        global $ConnectingDB;

        $sql = "INSERT into admins (datetime , username , password , aname , addedby)";
        $sql .= "VALUES (:time , :username , :pass , :newAdmin ,:admin )";

        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':time', $DateTime);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':pass', $password);
        $stmt->bindValue(':newAdmin', $name);
        $stmt->bindValue(':admin', $Admin);

        $execute = $stmt->execute();
        if ($execute) {
            $_SESSION['successMessage'] = 'تم اضافة مشرف بنجاح ';
            redirect_to('Admins.php');
        } else {
            $_SESSION['errorMessage'] = 'حدث خطأ عند التنفيذ';
            redirect_to('Admins.php');
        }
    }
}


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

    <title>ادمن</title>
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
    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class=" col-md-12">
                    <h1><i class="fas fa-user" style="color:#27aae1;"></i> ادارة الحسابات</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!-- Main Area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:400px;">

                <form class="" action="Admins.php" method="post">
                    <?php
                    echo errorMessage();
                    echo successMessage();
                    ?>
                    <div class=" card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>اضافة مشرف </h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="username"> <span class="FieldInfo"> اسم المستخدم :</span></label>
                                <input class="form-control" type="text" name="username" id="username" value="">
                            </div>
                            <div class="form-group">
                                <label for="Name"> <span class="FieldInfo"> الاسم :</span></label>
                                <input class="form-control" type="text" name="name" id="name" value="">
                                <small class="text-muted">*اختياري</small>
                            </div>
                            <div class="form-group">
                                <label for="Password"> <span class="FieldInfo"> كلمة المرور : </span></label>
                                <input class="form-control" type="password" name="password" id="password" value="">
                            </div>
                            <div class="form-group">
                                <label for="ConfirmPassword"> <span class="FieldInfo"> تأكد كلمة المرور :</span></label>
                                <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" value="">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> الرجوع للوحة التحكم</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> اضافة
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div style="text-align: right; width: 100%;">
                    <h2>المشرفين</h2>
                </div>
                <table class="table table-striped table-hover ">
                    <thead class="thead-dark">
                        <tr>
                            <th>رقم. </th>
                            <th>التاريخ</th>
                            <th>اسم الحساب</th>
                            <th>اسم المستخدم </th>
                            <th>مضاف بواسطة</th>
                            <th>اجراء</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * from admins ";
                    $stmt = $ConnectingDB->query($sql);
                    $snum = 0;
                    while ($data = $stmt->fetch()) {
                        $id = $data['id'];
                        $date = $data['datetime'];
                        $username = $data['username'];
                        $aname = $data['aname'];
                        $addedby = $data['addedby'];
                        $snum++;

                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($snum); ?></td>
                                <td><?php echo htmlentities($date); ?></td>
                                <td><?php echo htmlentities($username); ?></td>
                                <td><?php echo htmlentities($aname); ?></td>
                                <td><?php echo htmlentities($addedby); ?></td>
                                <td> <a href="DeleteAdmin.php?idd=<?php echo $id; ?>" class="btn btn-danger">حذف</a> </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>

    </section>



    <!-- End Main Area -->
    <!-- FOOTER -->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">تمت البرمجة بواسطة | عبدالعزيز ملفي | <span id="year"></span> &copy; ----كل الحقوق محفوظة.</p>
                    <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="http://azmlan.com" target="_blank"> <br>&trade; azmlan.com &trade; github ;</a></p>
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