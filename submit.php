<?php
require('utility/base-url.php');
if(!isset($_COOKIE[SUBMIT])) {
    header('Location: ' . URL);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Response</title>
    <link rel="stylesheet" href="css/override.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/submit.css">
</head>
<body>
    <?php
    require('utility/submit-response.php');
    ?>
    <header>
        <div class="wrapper">
            <h1>
                <a href="#" title="Secure Site">Secure Site</a>
            </h1>
        </div>
    </header>
    <div class='wrapper'>
        <div class="submitted-data">
            <h2>User Registered Successfully!</h2>
            <h3>Submitted Data:</h3>
            <p><small>Name: </small><?php echo $name; ?></p>
            <p><small>Mobile Number: </small><?php echo $mobile; ?></p>
            <p><small>Gender: </small><?php echo $gender; ?></p>
            <p><small>City: </small><?php echo $city; ?></p>
            <p><small>Uploaded Image:</small></p>
            <figure><img src='profile-pic/<?php echo $filename; ?>' alt='Your Profile Picture'></figure>
        </div>
        <div class="login-div">
            <h2>Login Page</h2>
            <a href="<?php echo constant('URL').'/login.php'?>" title="Login">Login</a>
        </div>
    </div>
</body>
</html>