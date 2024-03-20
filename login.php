<?php
include('config.php');

if (isset($_GET["code"])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);

        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();

        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

if (!isset($_SESSION['access_token'])) {
    $login_button = '<a href="' . $google_client->createAuthUrl() . '"><img src="images/sign-in-with-google.png" /></a>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zd6R/wThMZ3+FKD0Z0Jt8Pck5f3PIsFHYzvmLsJ+8HvjtALZ8t0rwE66piBcgzR8" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php
        // Display user information and logout button if logged in
        if (isset($_SESSION['username'])) {
            echo '<div class="card mb-3">';
            echo '<div class="card-header bg-success text-white">Welcome ' . $_SESSION['username'] . '</div>';
            echo '<div class="card-body">';
            echo '<a href="logout-handler.php" class="btn btn-primary">Logout</a>';
            echo '</div>';
            echo '</div>';
        } else {
            // Display login and signup forms
        ?>
            <h2>Login</h2>
            <!-- Login Form -->
            <form id="login_form" method="post" action="login-handler.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" name="username" id="username_login" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" id="password_login" class="form-control" required>
                </div>
                <div id="login_error" class="text-danger"></div> <!-- Error message placeholder -->
                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <hr>

            <h2>Sign Up</h2>
            <!-- Sign Up Form -->
            <form id="signup_form" method="post" action="signup-handler.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" name="username" id="username_signup" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" id="password_signup" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email_signup" class="form-control">
                </div>
                <div id="signup_error" class="text-danger"></div> <!-- Error message placeholder -->
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
        <?php
        }

        // Display Google login button if not already logged in with Google
        if ($login_button == '') {
            // Display user information if logged in with Google
            echo '<div class="card mb-3">';
            echo '<div class="card-header bg-success text-white">Welcome User</div>';
            echo '<div class="card-body">';
            echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle mx-auto d-block mb-2" alt="' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '">';
            echo '<h3><b>Name:</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
            echo '<h3><b>Email:</b> ' . $_SESSION['user_email_address'] . '</h3>';
            echo '<a href="logout-handler.php" class="btn btn-primary">Logout</a>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div align="center">' . $login_button . '</div>';
        }
        ?>
    </div>

    <!-- JavaScript for handling form submission -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // AJAX request for sign up form
            document.querySelector('#signup_form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting normally

                // Get form data
                var formData = new FormData(this);

                // Send AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'signup-handler.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // Update DOM with response content
                        var response = xhr.responseText;
                        document.getElementById('signup_form').insertAdjacentHTML('afterend', response);
                    } else {
                        console.error('Request failed: ' + xhr.statusText);
                    }
                };
                xhr.onerror = function() {
                    console.error('Request failed');
                };
                xhr.send(formData);
            });

            // AJAX request for login form
            document.querySelector('#login_form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting normally

                // Get form data
                var formData = new FormData(this);

                // Send AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'login-handler.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // Update DOM with response content
                        var response = xhr.responseText;
                        document.getElementById('login_form').insertAdjacentHTML('afterend', response);
                    } else {
                        console.error('Request failed: ' + xhr.statusText);
                    }
                };
                xhr.onerror = function() {
                    console.error('Request failed');
                };
                xhr.send(formData);
            });
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('login_form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting normally

                // Get form data
                var formData = new FormData(this);
                formData.append('action', 'login'); // Add action parameter

                // Send AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'login.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // Parse response JSON
                        var response = JSON.parse(xhr.responseText);

                        // If login is successful, display success message and hide the form
                        if (response.success) {
                            document.getElementById('login_success_message').innerHTML = '<div class="alert alert-success" role="alert">Login successful. Redirecting...</div>';

                            // Redirect to profile page after a short delay
                            setTimeout(function() {
                                window.location.href = 'profile.php';
                            }, 2000);
                        } else {
                            // If login failed, display error message
                            document.getElementById('login_error').innerHTML = '<div class="alert alert-danger" role="alert">' + response.message + '</div>';
                        }
                    } else {
                        console.error('Request failed: ' + xhr.statusText);
                    }
                };
                xhr.onerror = function() {
                    console.error('Request failed');
                };
                xhr.send(formData);
            });
        });
    </script>
</body>
</html>

