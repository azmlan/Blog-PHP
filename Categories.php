<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
isLogin(); ?>
<?php
if (isset($_POST['submit'])) {
    $CategoryTitle = $_POST['CategoryTitle'];
    $Admin = $_SESSION['UserName'];

    date_default_timezone_set("Asia/Riyadh");
    $currentTiem = time();
    // $DateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTiem);
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTiem);



    if (empty($CategoryTitle)) {
        $_SESSION['errorMessage'] = 'يجب ملئ الحقل ';
        redirect_to("Categories.php");
    }
    // strlrn -> طول السترنق
    elseif (strlen($CategoryTitle) < 2) {
        $_SESSION['errorMessage'] = 'يجب ان يتكون من حرفين على الاقل';
        redirect_to("Categories.php");
    } elseif (strlen($CategoryTitle) > 50) {
        $_SESSION['errorMessage'] = 'الحد الاقصى ٥٠ حرف فقط';
        redirect_to("Categories.php");
    } else {
        $sql = "INSERT INTO category(title,author,datetime)";
        // here using PDO name parameter to pass dummy vlaues to prevent the SQL injection;
        $sql .= "VALUES(:categoryTitle,:categoryAuthor,:categorydateTime)";
        // Prepares an SQL statement to be executed by the PDOStatement::execute() method.
        // -> this is mean we using PDO opject notation;
        $stmt = $ConnectingDB->prepare($sql);
        // now after prepare() we will bind the dummy values to real values;
        $stmt->bindValue(':categoryTitle', $CategoryTitle);
        $stmt->bindValue(':categoryAuthor', $Admin);
        $stmt->bindValue(':categorydateTime', $DateTime);
        // Now the Execution , every PDO prepared statment should use execution method;
        $execute = $stmt->execute();

        if ($execute) {
            $_SESSION['successMessage'] = "تم بنجاح اضافة التصنيف برقم الاي دي : " . $ConnectingDB->lastInsertId() . " ";
            "";
            redirect_to('Categories.php');
        } else {
            $_SESSION['errorMessage'] = 'حدث خطأ عند التنفيذ';
            redirect_to('Categories.php');
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

    <title>التصنيفات </title>
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
                    <h1> <i class="fas fa-edit" style="color: #27aae1;"></i> ادارة التصنيفات </h1>
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
                <form class="" action="Categories.php" method="post">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-header">
                            <h2>اضف تصنيف جديد </h2>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="FieldInfo"> عنوان التصنيف : </span></label>
                                <input type="text" class="form-control" name="CategoryTitle" id="title" placeholder="اكتب اسم التصنيف ">
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

    <section class="container text-right py-2 mb-4 ">
        <div class="row " style="min-height:30px;">
            <div class="col-lg-12" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <div style="text-align: right; width: 100%;">
                    <h2>التصنيفات المتاحة</h2>
                </div>
                <table class="table table-striped table-hover ">
                    <thead class="thead-dark">
                        <tr>
                            <th>رقم. </th>
                            <th>التاريخ</th>
                            <th>التصنيف</th>
                            <th>منشئ التصنيف</th>
                            <th>اجراء</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * from category ";
                    $stmt = $ConnectingDB->query($sql);
                    $snum = 0;
                    while ($data = $stmt->fetch()) {
                        $catId = $data['id'];
                        $date = $data['datetime'];
                        $title = $data['title'];
                        $author = $data['author'];
                        $snum++;

                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($snum); ?></td>
                                <td><?php echo htmlentities($date); ?></td>
                                <td><?php echo htmlentities($title); ?></td>
                                <td><?php echo htmlentities($author); ?></td>
                                <td> <a href="DeleteCategory.php?idd=<?php echo $catId; ?>" class="btn btn-danger">حذف</a> </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>

    </section>
    <!--  Main Area End -->
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