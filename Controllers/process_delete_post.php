<?php

    $json_file = file_get_contents('../Data/posts.json');
    $posts = (json_decode($json_file, true));

    $posts = array_filter($posts, function($post) {
        return $post['id'] != $_GET['id'];
    });

    file_put_contents('../Data/posts.json', json_encode($posts,JSON_PRETTY_PRINT));
    header('Location:' . $_SERVER['HTTP_REFERER']);

 
?>