<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Business Card - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> 
</head>
<body class="d-flex flex-column min-vh-100"> <!-- Apply flexbox to make the footer sticky -->

<?php
// Header
echo '
<header class="bg-green text-light py-4">
    <div class="container">
        <h1 class="mb-0">Welcome to My Website</h1>
    </div>
</header>';

// Navigation bar (always remains the same)
echo '
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="?page=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=login">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>';

// Main content (dynamically changes based on page parameter)
echo '
<main class="container flex-grow-1 py-4">';
    // Define which page to load
    $page = isset($_GET['page']) ? $_GET['page'] : '';

    // Load the content based on the selected page
    if ($page == 'about') {
        include 'about.php';
    } elseif ($page == 'login') {
        include 'login.php';
    } else {
        // If no page parameter or page not found, load the default home content
        include 'home.php';
    }

echo '
</main>';

// Footer
echo '
<footer class="bg-dark text-light py-4 mt-auto"> <!-- Apply margin-top:auto to push the footer to the bottom -->
    <div class="container text-center">
        <p>&copy; 2024 My Website</p>
    </div>
</footer>';

?>

</body>
</html>
