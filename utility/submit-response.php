<?php
if(isset($_COOKIE[SUBMIT])) {
    $submittedData = json_decode($_COOKIE[SUBMIT], true);
    $name = $submittedData['name'];
    $gender = $submittedData['gender'];
    $mobile = $submittedData['mobile'];
    $filename = $submittedData['file'];
    $city = $submittedData['city'];
}