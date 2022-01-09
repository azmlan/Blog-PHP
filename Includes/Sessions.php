<?php
session_start();

function errorMessage()
{
    if (isset($_SESSION["errorMessage"])) {
        $outPut = "<div class='alert alert-danger'>";
        // htmlentities -> اذا بضيف هتمل او نص 
        $outPut .= htmlentities($_SESSION['errorMessage']);
        $outPut .= "</div>";
        $_SESSION["errorMessage"] = null;
        return $outPut;
    };
}

function successMessage()
{
    if (isset($_SESSION["successMessage"])) {
        $outPut = "<div class=\"alert alert-success\">";
        $outPut .= htmlentities($_SESSION['successMessage']);
        $outPut .= "</div>";
        $_SESSION["successMessage"] = null;
        return $outPut;
    };
}
