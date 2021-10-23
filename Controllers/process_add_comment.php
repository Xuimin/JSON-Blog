<?php

    session_start();
    $message = $_POST['message'];
    $id = $_GET['id'];
    var_dump($id);
    echo '<pre>';
    var_dump($message);
    echo '</pre>';

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');

    $user_comment = [
        'id' => $id,
        'author' => $_SESSION['user_data']['username'],
        'content' => $message,
        'date' => strtotime($current_date . $current_time),
        'edited' => false
    ];

    $json_file = file_get_contents('../Data/comments.json');
    $comments = json_decode($json_file, true); 
    $comments[] = $user_comment;

    // foreach($comments as $comment) {
    //     if($id == $comment['id']) {
    //         $message = $comment['content'];
    //         echo $comment['content'];
            
    //         // echo '<pre>';
    //         // var_dump($i); //int 0 1 2 3 ...
    //         // var_dump($id); //string
    //         // var_dump($comment['id']); 
    //         // var_dump($comments);
    //         // echo '</pre>';
    //     }
    // }

    file_put_contents('../Data/comments.json', json_encode($comments, JSON_PRETTY_PRINT));
    header('Location:' . $_SERVER['HTTP_REFERER']);
?>
