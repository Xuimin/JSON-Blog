<?php

    $date = $_GET['date'];
    // var_dump($date);

    $json_file = file_get_contents('../Data/comments.json');
    $comments = (json_decode($json_file, true));

    $comments = array_filter($comments, function($comment) {
        return $comment['date'] != $_GET['date'];
    });

    file_put_contents('../Data/comments.json', json_encode($comments,JSON_PRETTY_PRINT));
    header('Location:' . $_SERVER['HTTP_REFERER']);
?>