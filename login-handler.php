<?php
// Start the session
session_start();

// Connect to the database
$conn = mysqli_connect("localhost", "olegfedyshyn_webdevdb_user", "t5{!l#tsunYM", "olegfedyshyn_webdevdb", "3306");

//if($conn == true){
//    echo "true";
//}
//else{
//    echo "false";
//}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the user input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

  //echo $username;
  //echo $password;
  
    // Query the database for the user credentials
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $row= mysqli_num_rows($result);
    
//echo $row;
    // Check if the query returned a result
    if (mysqli_num_rows($result) == 1) {
        // Login successful
        $_SESSION['username'] = $username;
    } else {
        // Login failed
        $message = "Incorrect username or password.";
    }
}
 echo "<!DOCTYPE html>";
  echo "<html><head><title>Registration</title></head>";
  echo "<body>";
  if (isset($message)) {
    echo "<div class='alert alert-danger' role='alert'>$message</div>";
  } else if (mysqli_num_rows($result) == 1) {
    echo "<div class='alert alert-success' role='alert'>User logged in successfully.</div>";
  } else {
    echo "<div class='alert alert-danger' role='alert'>Error occurred during login.</div>";
  }
  echo "</body></html>";
mysqli_close($conn);
?>