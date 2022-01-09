<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php
$SearchQueryParameter = $_GET["idd"];
if (isset($_POST["Submit"])) {
    $name = $_POST["commenterName"];
    $email = $_POST["commenterEmail"];
    $comment = $_POST["commenterThoughts"];

    date_default_timezone_set("Asia/Riyadh");
    $currentTiem = time();
    $DateTime = strftime("%B-%d-%Y", $currentTiem);

    if (empty($name) || empty($email) || empty($comment)) {
        $_SESSION['errorMessage'] = 'يجب ملئ الحقول الفارغة  ';
        redirect_to("FullPost.php?idd=$SearchQueryParameter");
    }
    // strlrn -> طول السترنق
    elseif (strlen($name) < 2) {
        $_SESSION['errorMessage'] = 'يجب ان يتكون الاسم من حرفين على الاقل و ٥٠ حرف كحد اقصى';
        redirect_to("FullPost.php?idd=$SearchQueryParameter");
    } elseif (strlen($email) < 2) {
        $_SESSION['errorMessage'] = 'يجب ان يتكون الايميل من حرفين على الاقل ١٠٠ حرف كحد اقصى';
        redirect_to("FullPost.php?idd=$SearchQueryParameter");
    } elseif (strlen($comment) > 899) {
        $_SESSION['errorMessage'] = 'يجب ان يتكون التعليق من حرفين على الاقل و ٩٠٠ حرف كحد اقصى';
        redirect_to("FullPost.php?idd=$SearchQueryParameter");
    } else {
        // Query to insert Post in DB When everything is fine
        global $ConnectingDB;
        $sql  = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
        $sql .= "VALUES(:BdateTime,:Bname,:Bemail,:Bcomment,'Pending','OFF',:BidFromURL)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':BdateTime', $DateTime);
        $stmt->bindValue(':Bname', $name);
        $stmt->bindValue(':Bemail', $email);
        $stmt->bindValue(':Bcomment', $comment);
        $stmt->bindValue(':BidFromURL', $SearchQueryParameter);

        $Execute = $stmt->execute();
        if ($Execute) {
            $_SESSION["successMessage"] = "تم اضافة التعليق بنجاح";
            Redirect_to("FullPost.php?idd={$SearchQueryParameter}");
        } else {
            $_SESSION["errorMessage"] = "حدث خطأ  !";
            Redirect_to("FullPost.php?idd={$SearchQueryParameter}");
        }
    }
};

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>المقال </title>
    <style media="screen">
        .heading {
            font-family: Bitter, Georgia, "Times New Roman", Times, serif;
            font-weight: bold;
            color: #005E90;
        }

        .heading:hover {
            color: #0090DB;
        }

        .CommentBlock {
            background-color: #f6f7f9;

        }

        .FieldInfo {
            color: rgb(251, 174, 44);
            font-size: 2.2rem;
        }

        .text-right {
            text-align: right;
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
                    <li class="nav-item">
                        <a href="#" class="nav-link">المميزات</a>
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
                    $stmt->bindValue('pSearch', "%" . $search . "%");
                    $stmt->execute();
                } else {
                    $postIdFromURL = $_GET['idd'];
                    if (!isset($postIdFromURL)) {
                        redirect_to("Blog.php");
                        $_SESSION['errorMessage'] = "طلب غير متاح";
                    };
                    $sql = "SELECT * FROM posts WHERE id = '$postIdFromURL'  ";
                    $stmt = $ConnectingDB->query($sql);
                    $result = $stmt->rowCount();
                    if ($result != 1) {
                        $_SESSION['errorMessage'] = 'حدث خطأ عند التنفيذ';
                        redirect_to("Blog.php?page=1");
                    }
                }

                while ($data = $stmt->fetch()) {
                    # code...
                    $id = $data['id'];
                    $date = $data['datetime'];
                    $category = $data['category'];
                    $author = $data['author'];
                    $postTitle = $data['title'];
                    $postDetails = $data['post'];
                    $img = $data['img'];

                ?>
                    <div class="text-right card">
                        <!-- <img src="Uploads/<?php echo htmlentities($img); ?>" style="max-height:450px;" class="img-fluid card-img-top" /> -->
                        <img src="Uploads/img.png" style="max-height:450px;" class="img-fluid card-img-top" />
                        <div class="card-body">

                            <h4 class="card-title"><?php echo htmlentities($postTitle); ?></h4>
                            <small class="text-muted"><span class="text-dark"> <a> </a></span> كتبت بواسطة<span class="text-white badge badge-info mx-1"> <?php echo htmlentities($author) ?> <a></a></span>
                                <br>
                                في <?php echo htmlentities($date); ?></small>
                            <br>
                            <span class="badge badge-dark text-light">التعليقات


                            </span>
                            <hr>
                            <p class="card-text">
                                <?php echo htmlentities($postDetails); ?>
                            </p>
                        </div>
                    </div>
                    <br>
                <?php } ?>

                <!-- Pagination -->
                <nav>
                    <ul class="pagination pagination-lg">
                        <!-- Creating Backward Button -->

                        <li class="page-item">
                            <a class="page-link">&laquo;</a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link"></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link"></a>
                        </li>

                        <!-- Creating Forward Button -->

                        <li class="page-item">
                            <a>&raquo;</a>
                        </li>

                    </ul>
                </nav>

                <!--   START comment  -->


                <div style="text-align: right;">
                    <?php echo errorMessage();
                    echo successMessage(); ?>

                    <form class="" action="FullPost.php?idd=<?php echo $SearchQueryParameter; ?>" method="post">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="FieldInfo">شاركنا تعليقك هنا </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="ml-3 input-group-text"><i class=" fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control" type="text" name="commenterName" placeholder="اسمك" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="ml-3 input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" type="text" name="commenterEmail" placeholder="إيميلك" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea name="commenterThoughts" class="form-control" rows="6" cols="80"></textarea>
                                </div>
                                <div class="">
                                    <button type="submit" name="Submit" class="btn btn-primary">تأكيد</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--   End Comment  -->

                <!--   START fetch Comment  -->
                <div class="FieldInfo text-right">التعليقات</div>
                <br>
                <?php

                global $ConnectingDB;

                $sql = "SELECT * from comments where post_id = $SearchQueryParameter  and status ='ON' ";
                $stmt = $ConnectingDB->query($sql);
                while ($data = $stmt->fetch()) {
                    $date = $data['datetime'];
                    $name = $data['name'];
                    $comment = $data['comment'];

                ?>
                    <div class="media CommentBlock text-right">
                        <img class="d-block img-fluid align-self-start" width="100" height="100" src="Images/person-icon.png" alt="icon">
                        <div class="media">
                            <div class="media-body ml-2">
                                <h6 class="lead"><?php echo $name ?></h6>
                                <p class="small"><?php echo $date ?></p>
                                <p><?php echo $comment ?></p>
                            </div>
                        </div>
                    </div>
                    <br>
                <?php } ?>
                <!--   END fetch Comment  -->
            </div>
            <!-- Main Area End-->
            <?php require_once("footerSide.php") ?>