<?php

    session_start();
    $json_file = file_get_contents('../Data/posts.json');
    $posts = (json_decode($json_file));

    foreach($posts as $post) {
        if($post->id == $_GET['id']) {
            foreach($post->likes as $i => $like) {
                if($like === $_SESSION['user_data']['username']) {
                    var_dump($post->likes[$i]);
                    unset($post->likes[$i]);
                }
            }
        }
    }

    // METHOD 2(Array)
    // foreach($posts as $i => $post) {
    //     if($post['id'] == $_GET['id']) {
    //         foreach($post['likes'] as $j => $like) {
    //             if($like === $_SESSION['user_data']['username']) {
    //                 array_splice($posts[$i]['likes'], $j, 1);
    //                 break;
    //             }
    //         }
    //         break;
    //     }
    // }

    file_put_contents('../Data/posts.json', json_encode($posts,JSON_PRETTY_PRINT));
    header('Location:' . $_SERVER['HTTP_REFERER']);
?>