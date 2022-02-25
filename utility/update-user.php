<?php

$fields;
if(isset($_COOKIE[UPDATE])) {
    $email = $_COOKIE[UPDATE];

    DatabaseConnection::startConnection();
    $stmt = DatabaseConnection::$conn->prepare("SELECT name, email, mobile, gender, city FROM users where email=?;");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $fields = $result->fetch_assoc();
    $stmt->close();
    DatabaseConnection::closeDBConnection();
}