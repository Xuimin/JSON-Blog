<?php

    $content = $_POST['content'];
    $date = $_GET['date'];

    $json_file = file_get_contents('../Data/comments.json');
    $comments = json_decode($json_file, true);

    // echo '<pre>';
    // var_dump($content);
    // echo '</pre>';
    // var_dump($id);
    // die();

    foreach($comments as $i => $comment) {
        if($comment['date'] == $_GET['date']) {
            $comments[$i]['content'] = $content;
            $comments[$i]['edited'] = true;
        }
    }

    file_put_contents('../Data/comments.json', json_encode($comments, JSON_PRETTY_PRINT));
    header('Location:' . $_SERVER['HTTP_REFERER']);
?>