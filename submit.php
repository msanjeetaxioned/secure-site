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
            <?php
            if(isset($_COOKIE[UPDATE])) {
            ?>
            <h2>User '<?php echo $_COOKIE[UPDATE]; ?>' Updated!</h2>
            <?php
            } else {
            ?>
            <h2>User Registered Successfully!</h2>
            <?php 
            } ?>
            <h3>Submitted Data:</h3>
            <p><small>Name: </small><?php echo $name; ?></p>
            <p><small>Mobile Number: </small><?php echo $mobile; ?></p>
            <p><small>Gender: </small><?php echo $gender; ?></p>
            <p><small>City: </small><?php echo $city; ?></p>
            <p><small>Uploaded Image:</small></p>
            <figure><img src='profile-pic/<?php echo $filename; ?>' alt='Your Profile Picture'></figure>
        </div>
        <?php
        if(isset($_COOKIE[UPDATE])) {
        ?>
        <div class="login-div">
            <h2>Users Page</h2>
            <a href="<?php echo constant('URL').'/users.php'?>" title="Users">Users</a>
        </div>
        <?php } else { ?>
        <div class="login-div">
            <h2>Login Page</h2>
            <a href="<?php echo constant('URL').'/login.php'?>" title="Login">Login</a>
        </div>
        <?php } ?>
    </div>
    <?php
    if(isset($_COOKIE[UPDATE])) {
        // Delete 'Update' Cookie after successfull Update of DB
        setcookie(UPDATE, "", time() - 300, "/", "", 0);
        setcookie(SUBMIT, "", time() - 300, "/", "", 0);
    }
    ?>
</body>
</html>