<?php
// Start the session
session_start();

// Connect to the database
$conn = mysqli_connect("localhost", "olegfedyshyn_webdevdb_user", "t5{!l#tsunYM", "olegfedyshyn_webdevdb", "3306");

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the user input
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Check if the username is already taken
  $check_query = "SELECT * FROM user WHERE username = '$username'";
  $check_result = mysqli_query($conn, $check_query);
  if (mysqli_num_rows($check_result) > 0) {
    // Username already exists
    $message = "Username already taken. Please choose a different username.";
  } else {
    // Username is unique, proceed with insertion
    $sql = "INSERT INTO user(username, email, password) VALUES('$username','$email','$password')";
    $insert_result = mysqli_query($conn, $sql);
    
    if ($insert_result) {
      // New user inserted successfully
      $_SESSION['username'] = $username;
    } else {
      // Insertion failed
      $message = "Error occurred during registration.";
    }
  }

  // Include message in HTML response
  if (isset($message)) {
    echo "<div class='alert alert-danger' role='alert'>$message</div>";
  } else if (isset($insert_result) && $insert_result) {
    echo "<div class='alert alert-success' role='alert'>User registered successfully.</div>";
  } else {
    echo "<div class='alert alert-danger' role='alert'>Error occurred during registration.</div>";
  }
  echo "</body></html>";
}

mysqli_close($conn);
?>
