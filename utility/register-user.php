<?php

class RegisterUser 
{
    public $name;
    public $email;
    public $mobileNum;
    public $gender;
    public $password;
    public $confirmPass;
    public $file;
    public $city;

    public function validateFields() 
    {
        // Name Validation
        $this->name = $_POST["name"];
        Validation::nameValidation($this->name);

        // Email Validation
        $this->email = $_POST["email"];
        Validation::emailValidation($this->email);
        if(Validation::$emailError == "") {
            Validation::checkIfEmailAlreadyUsedInDB($this->email);
        }

        // Mobile Number Validation
        $this->mobileNum = $_POST["phone-num"];
        Validation::mobileNumValidation($this->mobileNum);

        // Get Gender
        if(isset($_POST["gender"])) {
            $this->gender = $_POST["gender"];
        } else {
            $this->gender = "";
        }
        Validation::genderValidation($this->gender);

        // Password Validation
        $this->password = $_POST["password"];
        Validation::passwordValidation($this->password);

        // Confirm Password Validation
        $this->confirmPass = $_POST["confirm-password"];
        Validation::confirmPasswordValidation($this->password, $this->confirmPass);

        // Image submitted Validation
        $this->file = $_FILES["file"];
        Validation::fileValidation($this->file);

        // Get City
        if(isset($_POST["city"])) {
            $this->city = $_POST["city"];
        } else {
            $this->city = "";
        }

        // Reset Form on Successful Submit
        if (Validation::checkIfAllFieldsAreValid()) {
            $_POST = [];
        }
    }

    public function onSubmit()
    {
        if (Validation::checkIfAllFieldsAreValid()) {
            $this->password = hash('sha512', $this->password);
            $filename = $this->file["name"];
            DatabaseConnection::startConnection();
            
            if(isset($_COOKIE["update"])) {
                $updateEmail = $_COOKIE["update"];
                // $sql = "UPDATE users SET name='$this->name', mobile='$this->mobileNum', gender='$this->gender', password='$this->password', file='$filename' where email = '$updateEmail'";

                $stmt = DatabaseConnection::$conn->prepare("UPDATE users SET name=?, mobile=?, gender=?, password=?, file=?, city=? where email=?");
                $stmt->bind_param("sisssss", $this->name, $this->mobileNum, $this->gender, $this->password, $filename, $this->city, $updateEmail);
            } else {
                // $sql = "INSERT INTO users VALUES ('$this->name', '$this->email', '$this->mobileNum', '$this->gender', '$this->password', '$filename')";

                $stmt = DatabaseConnection::$conn->prepare("INSERT INTO users (name, email, mobile, gender, password, file, city, admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
                $admin = "No";
                $stmt->bind_param("ssisssss", $this->name, $this->email, $this->mobileNum, $this->gender, $this->password, $filename, $this->city, $admin);
            }

            $submittedData = ["name" => $this->name, "mobile" => $this->mobileNum, "gender" => $this->gender, "file" => $filename, "city" => $this->city];
            print_r($submittedData);
            setcookie(SUBMIT, json_encode($submittedData), time() + 30 * 24 * 60 * 60, "/", "", 0);

            // set parameters and execute
            $stmt->execute();
            $stmt->close();
            DatabaseConnection::closeDBConnection();
            header('Location: ' . URL . '/submit.php');
        }
    }
}