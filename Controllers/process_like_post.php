<?php

    session_start();

    $json_file = file_get_contents('../Data/posts.json');
    $posts = json_decode($json_file);

    foreach($posts as $post) {
        if($post->id == $_GET['id']) {
            $post->likes[] = $_SESSION['user_data']['username'];
            array_values($post->likes);
        }
    }

    // METHOD 2(Array)
    // foreach($posts as $i => $post) {
    //     if($post['id'] == $_GET['id']) {
    //         $posts[$i]['likes'][] = $_SESSION['user_data']['username'];
    //     }
    // }


    file_put_contents('../Data/posts.json', json_encode($posts, JSON_PRETTY_PRINT));
    header('Location:' . $_SERVER['HTTP_REFERER']);
?>