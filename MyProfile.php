<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
isLogin();
$AdminId = $_SESSION['UserId'];
global $ConnectingDB;
$sql = "SELECT * from admins where id = '$AdminId'";
$stmt = $ConnectingDB->query($sql);
while ($data = $stmt->fetch()) {
    $ExsistingAdmin = $data['aname'];
    $ExsistingUsername = $data['username'];
    $ExsistingHeadline = $data['aheadline'];
    $ExsistingBio = $data['abio'];
    $ExsistingImage = $data['aimage'];
}
if (isset($_POST["submit"])) {
    $aName = $_POST["name"];
    $aheadline = $_POST["headline"];
    $abio = $_POST["bio"];
    $aimage = $_FILES["image"]["name"];
    $target = "Images/" . basename($_FILES["image"]["name"]);

    if (empty($aName) && empty($aheadline) && empty($abio) && empty($aimage)) {
        $_SESSION['errorMessage'] = ' لايمكن التعديل بينما جميع الحقول فارغة';
        redirect_to("MyProfile.php");
    } elseif (empty($aName)) {
        $_SESSION['errorMessage'] = 'لايمكن ترك حقل الاسم فارغ';
        redirect_to("MyProfile.php");
    } elseif (strlen($aName) < 2) {
        $_SESSION['errorMessage'] = 'الاسم يجب ان يكون حرفين على الاقل';
        redirect_to("MyProfile.php");
    } elseif (strlen($abio) > 500 || strlen($aheadline) > 30) {
        $_SESSION['errorMessage'] = 'الحد الاقصى للعنوان ٣٠ حرف  و الحد الاقصى للمعلومات العامة ٥٠٠ حرف ';
        redirect_to("MyProfile.php");
    } else {
        global $ConnectingDB;
        if (!empty($_FILES["image"]["name"])) {
            $sql = "UPDATE admins set aname =:aName , aheadline=:aheadline, abio=:abio,aimage=:aimage where id = :AdminId ";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':aName', $aName);
            $stmt->bindValue(':aheadline', $aheadline);
            $stmt->bindValue(':abio', $abio);
            $stmt->bindValue(':aimage', $aimage);
            $stmt->bindValue(':AdminId', $AdminId);
            $execute = $stmt->execute();
        } else {
            $sql = "UPDATE admins set aname =:aName , aheadline=:aheadline, abio=:abio where id = :AdminId ";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':aName', $aName);
            $stmt->bindValue(':aheadline', $aheadline);
            $stmt->bindValue(':abio', $abio);
            $stmt->bindValue(':AdminId', $AdminId);
            $execute = $stmt->execute();
        }

        // OR 

        // if (!empty($_FILES["image"]["name"])) {
        //     $sql = "UPDATE admins set aname ='$aName' , aheadline='$aheadline', abio='$abio',aimage='$aimage' where id = '$AdminId' ";
        // } else {
        //     $sql = "UPDATE admins set aname ='$aName' , aheadline='$aheadline', abio='$abio' where id = '$AdminId' ";
        // }
        // $execute = $ConnectingDB->query($sql);

        move_uploaded_file($_FILES["image"]["tmp_name"], $target);

        if ($execute) {
            $_SESSION['successMessage'] = 'تم التعديل بنجاح';
            redirect_to("MyProfile.php");
        } else {
            $_SESSION['errorMessage'] = 'حدث خطأ عند التنفيذ';
            redirect_to("MyProfile.php");
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
    <title>حسابي </title>
</head>

<body>
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
    <!-- NAVBAR END -->
    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-user text-success mr-2"></i>@<?php echo $ExsistingUsername ?></h1>
                    <small><?php echo $ExsistingHeadline ?></small>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!-- Main Area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <!-- Left Area -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3> <?php echo $ExsistingAdmin ?></h3>
                    </div>
                    <div class="card-body">
                        <!-- <img src="images/<?php  ?>" class="block img-fluid mb-3" alt=""> -->
                        <img src="Images/camelAvatar.png" class="block img-fluid mb-3" alt="">
                        <div class="">
                            <?php echo $ExsistingBio ?>


                        </div>
                    </div>

                </div>

            </div>
            <!-- Righ Area -->
            <div class="col-md-9" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-dark text-light">
                        <div class="card-header bg-secondary text-light">
                            <h4>تحديث البيانات</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input class="form-control" type="text" name="name" id="title" placeholder="الاسم" value="<?php echo $ExsistingAdmin ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="title" placeholder="العنوان" name="headline" value="<?php echo $ExsistingHeadline ?>">
                                <small class="text-muted"> اضف عنوان للحساب مثال : مبرمج ، رسام الخ... </small>
                                <span class="text-danger">٣٠ حرف حد اقصى</span>
                            </div>
                            <div class="form-group">
                                <textarea placeholder="معلومات عامة" class="form-control" id="Post" name="bio" rows="8" cols="80"><?php echo $ExsistingBio ?></textarea>
                            </div>

                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">اختر صورة </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>رجوع</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-block">
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
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">Theme By | Jazeb Akram | <span id="year"></span> &copy; ----All right Reserved.</p>
                    <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="http://jazebakram.com/coupons/" target="_blank"> This site is only used for Study purpose jazebakram.com have all the rights. no one is allow to distribute copies other then <br>&trade; jazebakram.com &trade; Udemy ; &trade; Skillshare ; &trade; StackSkills</a></p>
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