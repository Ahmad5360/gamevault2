<?php
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
  
    // Connect to the database
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
// echo "Connected"
  
    $sql = "INSERT INTO contact (name, email, subject, message)
    VALUES ('$name', '$email', '$subject', '$message')";
  
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  
    $conn->close();
  }
?>