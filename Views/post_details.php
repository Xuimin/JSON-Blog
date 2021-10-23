<?php
    $title = 'Post Details';
    function get_content() {
        $id = $_GET['id'];
        // var_dump($id);
        // die();

        $json_file_post = file_get_contents('../Data/posts.json');
        $posts = json_decode($json_file_post, true);
        // echo '<pre>';
        // var_dump($posts);
        // echo '</pre>';

        // $post = array_filter($posts, function($post) {
        //     return $post['id'] == $_GET['id'];
        // });
        // var_dump($post);

        // $post;
        // foreach($posts as $indiv_post) {
        //     if($indiv_post == $_GET['id']) {
        //         $post = $indiv_post;
        //     }
        // }
        $json_file_comment = file_get_contents('../Data/comments.json');
        $comments = json_decode($json_file_comment,true);

        foreach($posts as $i => $post):
            if($post['id'] == $id):
            
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto my-3">
            <div class="card">
                <div class="card-header">
                    <?php 
                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        echo date("Y-m-d H:i:s", $post["date"]);
                    ?>
                </div>

                <div class="card-body">
                    <?php 
                        echo '<h2>' . $post['title'] . '</h2>';
                        echo '<p>' . $post['description'] . '</p>';
                    ?>
                    <small style="font-style: italic">
                        Author: 
                        <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['username'] == $post['author']) {
                            echo "Me (" . ($post['author']) . ")";
                        } else echo $post['author'];
                        ?>
                    </small> 


                    <form action="../Controllers/process_add_comment.php?id=<?php echo $post['id'] ?>" class="mt-4" method="POST">
                        <!-- COMMENT -->
                        <?php if(isset($_SESSION['user_data'])){ ?>
                            <div class="form-group">
                                <input type="text" 
                                placeholder="Please leave a comment..."
                                name="message" 
                                class="form-control" required>
                            </div>
                        <?php }; ?>
                    </form>

                    <!-- SHOW COMMENT -->
                    <div class="card mt-3 p-2">
                        <h5>
                            <u style="font-size: 16px"><b>
                                Comments
                            </b></u> 
                        </h5>
                            <?php                                
                            $json_file1 = file_get_contents('../Data/comments.json');
                                $comments = array_reverse(json_decode($json_file1, true));
                                foreach($comments as $comment) {
                                    if($post['id'] == $comment['id']) {
                            ?>
                            <div class="card-text d-flex justify-content-between align-items-center">
                                <div>
                                <?php
                                    date_default_timezone_set('Asia/Kuala_Lumpur');
                                    echo '<small> Posted at: ' . date("Y-m-d H:i:s",$comment['date']) . '</small>'; 

                                    if($comment['edited'] == true) {
                                        echo '<small style= "font-size: 10px; color: dodgerblue"><i> [Edited] </i></small>';
                                    }
    
                                    if(isset($_SESSION['user_data']) && $_SESSION['user_data']['username'] == $comment['author']) {
                                        echo "<p class= 'mb-0'>Me (" . ($comment['author']) . ")";
                                            } else {
                                        echo '<p class= "mb-0">' . $comment['author'];
                                            }
                                            
                                        echo ' : ' . $comment['content'] . '</p>';

                                    if(isset($_SESSION['user_data']) && $_SESSION['user_data']['username'] == $comment['author']): 
                                ?>
                                </div>
                            
                                <div>
                                    <!-- POST EDIT -->
                                    <button 
                                    style="font-size: 10px"
                                    class="btn btn-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#commentModal-<?php echo $comment['date']; ?>">
                                        Edit
                                    </button>

                                    <!-- POST EDIT ALERT -->
                                    <div class="modal fade" 
                                    id="commentModal-<?php echo $comment['date']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        Edit Post
                                                    </h5>
                                                </div>

                                                <div class="modal-body">
                                                    <form method="POST" action="../Controllers/process_edit_comment.php?date=<?php echo $comment['date']; ?>">
                                                        <div class="form-group">
                                                            <label for="">
                                                                Comment
                                                            </label>
                                                            <input type="text" 
                                                            name="content" 
                                                            class="form-control" 
                                                            value="<?php echo $comment['content']; ?>">
                                                        </div>

                                                        <button class="btn btn-success mt-3">
                                                            Confirm
                                                        </button>

                                                    </form>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- COMMENT DELETE -->
                                    <button 
                                    style="font-size: 10px"
                                    class="btn btn-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#commentModal1-<?php echo $comment['date']; ?>">
                                        Delete
                                    </button>

                                    <!-- COMMENT DELETE ALERT -->
                                    <div class="modal fade" 
                                    id="commentModal1-<?php echo $comment['date']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <?php echo $comment['content']; ?>
                                                    </h5>
                                                </div>

                                                <div class="modal-body">
                                                    <p>
                                                        Are you sure you want to delete this comment?
                                                    </p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" 
                                                    data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <a href="../Controllers/process_delete_comment.php?date=<?php echo $comment['date']; ?>" 
                                                    class="btn btn-success">
                                                        Confirm
                                                    </a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <hr>
                            <?php
                                    }
                                }
                            ?>
                    </div>
                </div>
            </div>
            <a href="/Blog" type="button" class="btn btn-primary"> << Back </a>
        </div>
    </div>
        
</div>

<?php
    endif;
    endforeach;
    }
    require_once './layout.php'
?>