<?php

class UsersList 
{
    public static $numOfUsers;
    public static $loggedInUserIsAdmin;
    public static $errorMessage = "";

    public static function createUserList() 
    {
        self::$loggedInUserIsAdmin = self::checkIfUserIsAnAdmin($_COOKIE[EMAIL]);

        DatabaseConnection::startConnection();
        $select = mysqli_query(DatabaseConnection::$conn, "SELECT name, email, mobile, gender, city, admin FROM users;");

        self::$numOfUsers = mysqli_num_rows($select);

        echo "<li>";
        echo "<span class='name'>Name</span>";
        echo "<span class='email'>Email Id</span>";
        echo "<span class='mobile'>Mobile No.</span>";
        echo "<span class='gender'>Gender</span>";
        echo "<span class='city'>City</span>";

        if(self::$loggedInUserIsAdmin) {
            echo "<span class='update'>Update User</span>";
            echo "<span class='delete'>Delete User</span>";
        }
        echo "</li>";

        while($row = mysqli_fetch_assoc($select)) {
            echo "<li>";
            echo "<span class='name'>" . $row["name"] . "</span>";
            echo "<span class='email'>" . $row["email"] . "</span>";
            echo "<span class='mobile'>" . $row["mobile"] . "</span>";
            echo "<span class='gender'>" . $row["gender"] . "</span>";
            echo "<span class='city'>" . $row["city"] . "</span>";
            if(self::$loggedInUserIsAdmin) {
                echo "<span class='update'><a href='" . constant('URL') . "/users.php?update=" . $row['email'] . "' title='Update'>Update</a></span>";
                echo "<span class='delete'><a href='" . constant('URL') . "/users.php?email=" . $row['email'] . "' title='Delete'>Delete</a></span>";
            }
            echo "</li>";
        }
        DatabaseConnection::closeDBConnection();
    }

    public static function deleteUserFromDB() 
    {
        $email = $_GET["email"];
        DatabaseConnection::startConnection();
        // $delete = mysqli_query(DatabaseConnection::$conn, "delete from users where email = '$email'");

        if(!self::checkIfUserIsAnAdmin($email)) {
            $stmt = DatabaseConnection::$conn->prepare("delete from users where email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();
            DatabaseConnection::closeDBConnection();
        }
        else {
            $errorMessage = ErrorMessages::$deleteUserError;
            if($email == $_COOKIE[EMAIL]) {
                $errorMessage = ErrorMessages::$adminDeletesSelfError;
            }
        }
    }

    public static function updateUserInDB() 
    {
        $email = $_GET["update"];

        setcookie(UPDATE, $email, time() + 24 * 60 * 60, "/", "", 0);
        header('Location: ' . URL);
    }

    public static function checkIfUserIsAnAdmin($email) {
        DatabaseConnection::startConnection();

        $stmt = DatabaseConnection::$conn->prepare("SELECT admin FROM users where email=?;");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;

        $stmt->close();
        DatabaseConnection::closeDBConnection();

        if($rows >= 1) {
            return true;
        }
        return false;
    }
}