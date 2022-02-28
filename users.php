<?php
require('utility/base-url.php');
if(!isset($_COOKIE[EMAIL])) {
    header('Location: ' . URL . '/login.php');
}
if(isset($_COOKIE[UPDATE])) {
    setcookie(UPDATE, "", time() - 300, "/", "", 0);
}
if(isset($_GET["logout"])) {
    setcookie(EMAIL, "", time() - 300, "/", "", 0);
    header('Location: ' . URL . '/login.php');
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    setcookie(EMAIL, "", time() - 300, "/", "", 0);
    header('Location: ' . URL . '/login.php');
}
require('utility/db-connection.php');
require('utility/errors.php');
require("utility/users-list.php");
if(isset($_GET['update'])) {
    UsersList::updateUserInDB();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Page</title>
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/override.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/users.css">
</head>
<body>
    <header>
        <div class="wrapper">
            <h1>
                <a href="#" title="Secure Site">Secure Site</a>
            </h1>
            <div class="control-buttons">
                <span class="user-email"><?php echo isset($_COOKIE[EMAIL]) ? "Welcome! " . $_COOKIE[EMAIL] : ""; ?></span>
                <a href='<?php echo constant('URL').'/users.php?logout=true'?>' title="Logout">Logout</a>
            </div>
        </div>
    </header>
    <div class="wrapper">
        <?php
        UsersList::$loggedInUserIsAdmin = UsersList::checkIfUserIsAnAdmin($_COOKIE[EMAIL]);
        echo UsersList::$loggedInUserIsAdmin ? "<p>Welcome Admin!</p>" : "";
        ?>
        <h2>All Users:</h2>
        <?php
            if(!isset($_GET["email"])) {
        ?>
                <ul class="users-list">
                    <?php
                    UsersList::createUserList();
                    ?>
                </ul>
        <?php   }
            else {
        ?>
                <ul class="users-list">
                    <?php
                    UsersList::deleteUserFromDB();
                    UsersList::createUserList();
                    ?>
                </ul>
        <?php   }
        if(isset($_GET["email"])) {
            if(UsersList::$errorMessage != "") {
                echo "<div class='error-message'><span>" . UsersList::$errorMessage . "</span></div>";
            }
        }
        ?>
        <form method="post" class="submit-div" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>