<?php
    
    $title = "Login";
    function get_content() {
        if(isset($_SESSION['user_data'])) {
            header('Location: /Blog');
        } 
        // if this is found it will go to the homepage no matter what
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <form action="../Controllers/process_login.php" method="POST" class="py-5">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <button class="btn btn-dark mt-3">Login</button>
            </form>
        </div>
    </div>
</div>

<?php
    }
    require_once 'layout.php';
?>