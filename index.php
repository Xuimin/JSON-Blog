<?php
    $title = "Homepage";
    function get_content() {
?>

<div class="container">
    <!-- FORM POST -->
    <?php if(isset($_SESSION['user_data'])): ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <form 
            action="../Controllers/process_add_post.php" 
            method="POST" 
            class="py-5">

            <div class="form-group">
                <label for="">Title</label>
                <input type="text" 
                name="title" 
                class="form-control" 
                required/>
            </div>

            <div class="form-group">
                <label for="">Description</label>
                <input type="text" 
                name="description" 
                class="form-control"
                required/>
            </div>

            <button class="btn btn-success mt-3">
                Add post
            </button>

            </form>
            <!-- <pre>
                <?php var_dump($_SERVER) ?>
            </pre> -->
        </div>
    </div>
    <?php endif; ?>

    <!-- SHOW POST -->
    <div class="row">
        <h2 class="text-center">POSTS</h2>
        <?php 
            $json_file_post = file_get_contents('./Data/posts.json');
            $posts = array_reverse(json_decode($json_file_post, true));
            // $post->title; Object
            // if there is true $post['title']; Associative array
            foreach($posts as $i => $post):
        ?>

        <div class="col-md-8 mx-auto my-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                    <!-- TIME -->
                    <?php 
                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        echo date("Y-m-d H:i:s", $post['date']); 
                    ?>
                    </div>
                
                    <!-- LIKES -->
                    <div>
                        <span class="badge bg-dark">
                            <?php echo count($post['likes']); ?> Likes
                        </span> 

                        <?php if(isset($_SESSION['user_data'])): ?>
                            <?php $liked = false; 
                                foreach($post['likes'] as $liker) {
                                    if($liker == $_SESSION['user_data']['username']) {
                                        $liked = true;
                                        break;
                                    }
                                }
                            ?>
                            <?php if($liked == true): ?>
                                <a href="./Controllers/process_unlike_post.php?id=<?php echo $post['id'] ?>" 
                                class="btn btn-primary">Unlike</a>
                            <?php else: ?>
                                <a href="./Controllers/process_like_post.php?id=<?php echo $post['id'] ?>"
                                class="btn btn-primary">Like</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body">
                    <!-- TITLE, DESC, AUTHOR -->
                    <a href="./Views/post_details.php?id=<?php echo $post['id']; ?>">
                        <h4 class="card-title"><?php echo $post['title']; ?></h4>
                    </a>

                    <p class="card-text"><?php echo $post['description']; ?></p>

                    <small style="font-style: italic">
                        Author: 
                        <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['username'] == $post['author']) {
                            echo "Me (" . ($post['author']) . ")";
                        } else {
                            echo $post['author'];
                        }?>
                    </small>  

                    <form action="./Controllers/process_add_comment.php?id=<?php echo $post['id'] ?>" class="mt-4" method="POST">
                        <!-- COMMENT -->
                        <?php if(isset($_SESSION['user_data'])){ ?>
                            <div class="form-group">
                                <input type="text" 
                                placeholder="Please leave a comment..."
                                name="message" 
                                class="form-control" 
                                required>
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
                            $json_file_comment= file_get_contents('./Data/comments.json');
                            $comments = array_reverse(json_decode($json_file_comment, true));
                            foreach($comments as $comment) {
                                if($post['id'] == $comment['id']) {
                            ?>
                            <div class="card-text d-flex justify-content-between align-items-center">
                                <div>
                                <?php
                                    date_default_timezone_set('Asia/Kuala_Lumpur');
                                    echo '<small> Posted at: ' . date("Y-m-d H:i:s", $comment['date']) . '</small>'; 

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
                                    <!-- COMMENT EDIT -->
                                    <button 
                                    style="font-size: 10px"
                                    class="btn btn-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#commentModal-<?php echo $comment['date']; ?>">
                                        Edit
                                    </button>

                                    <!-- COMMENT EDIT ALERT -->
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
                                                    <form method="POST" action="./Controllers/process_edit_comment.php?date=<?php echo $comment['date']; ?>">
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
                                                    <a href="./Controllers/process_delete_comment.php?date=<?php echo $comment['date']; ?>" 
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

                <!-- POST BUTTONS -->
                <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['username'] == $post['author']): ?>
                    <div class="card-footer">
                        <!-- POST EDIT -->
                        <button class="btn btn-warning" 
                        data-bs-toggle="modal" 
                        data-bs-target="#postModal-<?php echo $post['id']; ?>">
                            Edit
                        </button>
                        <!-- POST EDIT ALERT -->
                        <div class="modal fade" 
                        id="postModal-<?php echo $post['id']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Edit Post
                                        </h5>
                                    </div>

                                    <div class="modal-body">
                                        <form method="POST" action="./Controllers/process_update_post.php?id=<?php echo $post['id']; ?>">
                                            <div class="form-group">
                                                <label for="">
                                                    Title
                                                </label>
                                                <input type="text" 
                                                name="title" 
                                                class="form-control" 
                                                value="<?php echo $post['title']; ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="">
                                                    Description
                                                </label>
                                                <input type="text" 
                                                name="description" 
                                                class="form-control" 
                                                value="<?php echo $post['description']; ?>">
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

                        <!-- POST DELETE -->
                        <button class="btn btn-danger" 
                        data-bs-toggle="modal" 
                        data-bs-target="#postModal1-<?php echo $post['id']; ?>">
                            Delete
                        </button>
                        <!-- POST DELETE ALERT -->
                        <div class="modal fade" 
                        id="postModal1-<?php echo $post['id']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <?php echo $post['title']; ?>
                                        </h5>
                                    </div>

                                    <div class="modal-body">
                                        <p>
                                            Are you sure you want to delete this post?
                                        </p>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" 
                                        data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <a href="./Controllers/process_delete_post.php?id=<?php echo $post['id']; ?>" 
                                        class="btn btn-success">
                                            Confirm
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
    }
    require 'Views/layout.php';
?>