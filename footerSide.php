<!-- Side Area Start -->
<div class="col-sm-4">
    <div class="card mt-4">
        <div class="card-body">
            <img src="Images/person-icon.png" class="d-block img-fluid mb-3" alt="">
            <div class="text-center">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-dark text-light">
            <h2 class="lead">سجل معنا !</h2>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">سجل في المنتدى</button>
            <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">دخول</button>
            <div class="input-group mb-3">
                <input type="text" class="f§orm-control" name="" placeholder="Enter your email" value="">
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">اشترك</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-primary text-light">
            <h2 class="lead">التصنيفات</h2>
        </div>
        <div class="card-body">
            <?php
            global $ConnectingDB;
            $sql = "SELECT * from category order by id desc";
            $stmt = $ConnectingDB->query($sql);

            while ($data = $stmt->fetch()) {
                # code...
                $categoryName = $data['title'];
                $catId = $data['id'];

            ?>
                <a href="Blog.php?category=<?php echo $categoryName ?>"> <span class="heading " style="cursor: pointer;"><?php echo $categoryName ?> </span> </a><br>
            <?php } ?>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h2 class="lead"> المقالات الحديثة</h2>
        </div>
        <div class="card-body">
            <?php
            global $ConnectingDB;
            $sql = "SELECT * from posts limit 0,5";
            $stmt = $ConnectingDB->query($sql);

            while ($data = $stmt->fetch()) {
                # code...
                $id = $data['id'];
                $title = $data['title'];
                $image = $data['img'];
                $date = $data['datetime'];

            ?>
                <div class="media">
                    <img src="Images/img.png" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
                    <!-- <img src="Images/<?php echo htmlentities($image); ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="" /> -->
                    <div class="media-body ml-2">
                        <a href="FullPost.php?idd=<?php echo htmlentities($id) ?>" style="text-decoration:none;" target="_blank">
                            <h6 class="lead text-dark"><?php echo htmlentities($title) ?></h6>
                        </a>
                        <p class="small"><?php htmlentities($date) ?></p>
                    </div>
                </div>
                <hr>
            <?php } ?>
        </div>
    </div>

</div>
<!-- Side Area End -->


</div>

</div>

<!-- HEADER END -->
<br>
<!-- FOOTER -->
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center">تمت البرمجة بواسطة | عبدالعزيز ملفي | <span id="year"></span> &copy; ----كل الحقوق محفوظة.</p>
                <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="http://jazebakram.com/coupons/" target="_blank"> <br>&trade; azmlan.com &trade; github ; &trade; Skillshare ; &trade; StackSkills</a></p>
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