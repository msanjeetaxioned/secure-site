<?php
if(isset($_COOKIE[SUBMIT])) {
    $submittedData = json_decode($_COOKIE[SUBMIT], true);
    $name = $submittedData['name'];
    $gender = $submittedData['gender'];
    $mobile = $submittedData['mobile'];
    $filename = $submittedData['file'];
    $city = $submittedData['city'];
}

if(isset($_COOKIE[UPDATE])) {
    // Delete 'Update' Cookie after successfull Update of DB
    setcookie(UPDATE, "", time() - 300, "/", "", 0);
    setcookie(SUBMIT, "", time() - 300, "/", "", 0);
}