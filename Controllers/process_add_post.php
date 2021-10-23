<?php
    session_start();

    $title = $_POST['title'];
    $description = $_POST['description'];

    // var_dump($_SESSION['user_data']['username']);
    // die();

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');

    $new_post = [
        'id' => uniqid(),
        'title' => $title,
        'description' => $description,
        'author' => $_SESSION['user_data']['username'],
        'date' => strtotime($current_date . $current_time),
        'likes' => []
    ];

    // $new_post = new stdClass();
    // $new_post->title = $title;
    // $new_post->description = $description;
    // $new_post->author = $_SESSION['user_data']['username'];

    $json_file = file_get_contents('../Data/posts.json');
    $posts = json_decode($json_file, true);
    $posts[] = $new_post;
    file_put_contents('../Data/posts.json', json_encode($posts, JSON_PRETTY_PRINT));
    header("Location: " . $_SERVER['HTTP_REFERER']);

?>