<?php
    $username = $_POST['username'];
    $password = $_POST['password'];

    $json_file = file_get_contents('../Data/users.json');
    $users = json_decode($json_file, true);

    foreach($users as $user) {
        if($user['username'] == $username && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_data'] = $user;
            header('Location: /Blog');
        }
    }
    echo '<h4>Wrong Credentials</h4>';
    echo "<a href = '/Blog/Views/login.php'>Go back to login</a>";

?>