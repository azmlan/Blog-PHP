<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if (isset($_SESSION['UserId'])) {
    redirect_to("Dashboard.php");
}
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['errorMessage'] = 'يجب ملئ جميع الحقول';
        redirect_to("Login.php");
    } else {
        $account = Login($username, $password);
        if ($account) {
            $_SESSION['UserId'] = $account['id'];
            $_SESSION['UserName'] = $account['username'];
            $_SESSION['AdminName'] = $account['aname'];


            $_SESSION['successMessage'] = ' مرحبا ' . $_SESSION['UserName'];
            if (isset($_SESSION['TrackingURL'])) {
                redirect_to($_SESSION['TrackingURL']);
            } else {
                redirect_to("Dashboard.php");
            }
        } else {
            $_SESSION['errorMessage'] = 'اسم المستخدم او كلمة المرور خاطئة';
            redirect_to("Login.php");
        }
    }
}


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
    <title>دخول</title>
</head>

<body class=" text-right">
    <!-- NAVBAR -->
    <div style="height:10px; background:#27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="Blog.php" class="navbar-brand"> azmlan.com</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            </div>
        </div>
    </nav>
    <div style="height:10px; background:#27aae1;"></div>
    <!-- NAVBAR END -->
    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->
    <!-- Main Area Start -->
    <section class="container py-2 mb-4">
        <div class="row d-flex justify-content-center">
            <div class=" col-sm-6" style="min-height:500px;">
                <br><br><br>
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h4> ! مرحبا </h4>
                    </div>
                    <div class="card-body bg-dark">
                        <form class="" action="Login.php" method="post">
                            <div class="form-group">
                                <label for="username"><span class="FieldInfo"> اسم المستخدم : </span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class=" ml-2 input-group-text text-white bg-info"> <i class="fas fa-user"></i> </span>
                                    </div>
                                    <input type="text" class="form-control" name="username" id="username" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password"><span class="FieldInfo"> كلمة المرور :</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="ml-2 input-group-text text-white bg-info"> <i class="fas fa-lock"></i> </span>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="password" value="">
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-info btn-block" value="دخول">
                        </form>

                    </div>

                </div>

            </div>

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
    <!-- FOOTER END-->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>

</html>