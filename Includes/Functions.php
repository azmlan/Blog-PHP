<?php require_once("Includes/DB.php"); ?>

<?php
function redirect_to($NewLocation)
{
    header('Location:' . $NewLocation);
    exit;
};
function checkUserNameExist($Username)
{

    global $ConnectingDB;
    $sql = "SELECT username from admins where username=:uName";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':uName', $Username);
    $stmt->execute();
    $result = $stmt->rowcount();
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}

function Login($username, $password)
{
    global $ConnectingDB;
    $sql = "SELECT * from admins where username=:UserName and password=:Password limit 1";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':UserName', $username);
    $stmt->bindValue(':Password', $password);
    $stmt->execute();

    $result = $stmt->rowcount();
    if ($result == 1) {
        return $foundAccount  = $stmt->fetch();
    } else {
        return null;
    }
}
function isLogin()
{
    if (isset($_SESSION["UserId"])) {
        return true;
    } else {
        $_SESSION["errorMessage"] = 'يجب تسجيل الدخول ';
        redirect_to("Login.php");
    }
};

function TotalPosts()
{
    global $ConnectingDB;
    $sql = "SELECT count(*) from posts";
    $stmt = $ConnectingDB->query($sql);
    $totalArray = $stmt->fetch();
    $total = array_shift($totalArray);
    echo $total;
}

function TotalCategories()
{
    global $ConnectingDB;
    $sql = "SELECT count(*) from category";
    $stmt = $ConnectingDB->query($sql);
    $totalArray = $stmt->fetch();
    $total = array_shift($totalArray);
    echo $total;
}

function TotalAdmins()
{
    global $ConnectingDB;
    $sql = "SELECT count(*) from admins";
    $stmt = $ConnectingDB->query($sql);
    $totalArray = $stmt->fetch();
    $total = array_shift($totalArray);
    echo $total;
}

function  TotalComments()
{
    global $ConnectingDB;
    $sql = "SELECT count(*) from comments";
    $stmt = $ConnectingDB->query($sql);
    $totalArray = $stmt->fetch();
    $total = array_shift($totalArray);
    echo $total;
}

function ApproveCommentsAccordingtoPost($id)
{
    global $ConnectingDB;
    $sql = "SELECT count(*) from comments where post_id ='$id' and status ='ON' ";
    $stmt = $ConnectingDB->query($sql);
    $result = $stmt->fetch();
    $total = array_shift($result);
    return $total;
}

function DisApproveCommentsAccordingtoPost($id)
{
    global $ConnectingDB;
    $sql = "SELECT count(*) from comments where post_id ='$id' and status ='OFF' ";
    $stmt = $ConnectingDB->query($sql);
    $result = $stmt->fetch();
    $total = array_shift($result);
    return $total;
}


?>