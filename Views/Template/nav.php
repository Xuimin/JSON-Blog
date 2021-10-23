<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a href="#" class="navbar-brand">BLOG</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <div class="navbar-nav">
                <a class="nav-link" href="/Blog">Home</a>

                <?php if(!isset($_SESSION['user_data'])): ?>

                <a class="nav-link" href="../Views/register.php">Register</a>
                <a class="nav-link" href="../Views/login.php">Login</a>

                <?php else: ?>

                <a class="nav-link" href="../Controllers/process_logout.php">Logout</a>

                <?php endif ?>
            </div>
        </div>
    </div>
</nav>


<!-- <?php session_start(); ?>
<?php 
    $_SESSION['color'] = 'green';
    $_SESSION['name'] = 'John Doe'; 
    $_SESSION['message'] = 'hello world'; 
    echo '<pre>';
    var_dump($_SESSION);
    echo '<pre>'

?> -->

<!-- <?php
    $age = 25;
    echo isset($age); //shows 1
    echo isset($username); //show nothing
?> -->