<?php
    // session_start(); this is on the layout
    // make variable able to use in all the other pages

    // var_dump($_POST);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $errors = 0;
    $existing = false;

    $json_file = file_get_contents('../Data/users.json');
    $users = json_decode($json_file, true);
    // passing true in json decode this will make your json file to be converted into associative array.

    // var_dump($users);
    // die();

    // Create a user using associative array
    $user = [
        "username" => $username,
        "password" => password_hash($password, PASSWORD_DEFAULT)
    ];

    // for debugging purposes
    // var_dump($user);
    // die(); // this is similar to the return keyword

    if(strlen($username) < 8) {
        echo "<h4>Username should be at least 8 characters</h4>";
        $errors++;
    }
    if(strlen($password) < 8 || strlen($password2) < 8) {
        echo "<h4>Password should be at least 8 characters</h4>";
        $errors++;
    }
    if($password != $password2) {
        echo "<h4>Password and Confirm Password should match</h4>";
        $errors++;
    }
    foreach($users as $indiv_user) {
        if($indiv_user['username'] == $username) {
            $existing = true;
        };
    }
    if($existing) {
        echo "<h4>Username already exists</h4>";
        $errors++;
    }
    if($errors > 0) {
        echo "<a href='/Blog/Views/register.php'>Go Back</a>";
    }
    if($errors === 0 && !$existing) {
         $users[] = $user;
        file_put_contents('../Data/users.json', json_encode($users, JSON_PRETTY_PRINT));
        // $_SESSION['user_data'] = $user;
        // 'user_data' => ['username' => '', 'password' => ''];
        header('Location: /Blog/Views/login.php');    
        }
?>
