<?php
    $title = $_POST['title'];
    $description = $_POST['description'];

    $json_file = file_get_contents('../Data/posts.json');
    $posts = json_decode($json_file, true);

    // var_dump($_GET['id']);

    // $post = null; / $post

    foreach($posts as $i => $indiv_post) {
        if($indiv_post['id'] == $_GET['id']) {
            $posts[$i]['title'] = $title;
            $posts[$i]['description'] = $description;
        }
    }

    file_put_contents('../Data/posts.json', json_encode($posts, JSON_PRETTY_PRINT));
    header('Location:' . $_SERVER['HTTP_REFERER']);
    // var_dump($post);

    // $post['title'] = $title;
    // $post['description'] = $description;

?>