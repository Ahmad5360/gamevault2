<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_1";

// Create connection
$conn = new mysqli($servername,$username,$password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
// $conn->close();


//start session
// session_start();

// //connect to the database
// $conn = mysqli_connect("hostname", "username", "password", "database_name");

// //check for connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }


// Sign Up
if (isset($_POST['sign-up'])) {
    //get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    //form validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) 
    {
        $error = "All fields are required";
    } 
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email is not valid";
    } else if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        //check if email already exists
        $email_check = mysqli_query($conn, "SELECT * FROM users_data WHERE email='$email'");
        if (mysqli_num_rows($email_check) > 0) {
            $error = "Email already exists";
        } 
        else {
            //hashing password
            // $password = password_hash($password, PASSWORD_DEFAULT);

            //insert data into database
            $insert = mysqli_query($conn, "INSERT INTO users_data (name, email, password) VALUES ('$name', '$email', '$password')");
            if ($insert) {
                $success = "Account created successfully. You can now login";
                
            } else {
                $error = "Error creating account. Try again later";
                
            }
        }
    }
}

//login form data
if (isset($_POST['sign-in'])) {
    //get form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


    // form validation
    if (empty($email) || empty($password)) {
        $error = "All fields are required";
    } 
    else {
        //check if email exists
        $email_check = mysqli_query($conn, "SELECT * FROM users_data WHERE email='$email'");
        if (mysqli_num_rows($email_check) == 1) {
            $user = mysqli_fetch_assoc($email_check);
            //verify password
            if ($password == $user['Password']) {
                //store user data in session
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                //redirect to dashboard
                header("Location: ./index2.html");
                
                exit; 
                }
                
            else 
            {
                $error = "Password is incorrect";
            }
            } 
        else {
                $error = "Email does not exist";
                }
        }
        }

        //display error or success messages
if (isset($error)) {
    echo "<p>$error</p>";
    } else if (isset($success)) {
    echo "<p>$success</p>";
    }

        //close database connection
                mysqli_close($conn);

?>