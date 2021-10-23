<!doctype html>
<html lang="en">
    <head>
    <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

        <title>BLOG | <?php echo $title ?></title>
    </head>

    <body>
        <!-- 
            require and include does the same things 
            include- even if there is error, it will continue reading the next codes
            require- if there is error, it will not continue reading the script tag
        -->
        
        <?php session_start() ?>
        <?php require_once 'Template/nav.php'; ?>
        <h4>
            <?php if(isset($_SESSION['user_data'])) {
                echo $_SESSION['user_data']['username'] . "'s Blog"; 
                } else {
                    echo 'Please login/create an account.';
                }
            ?>
        </h4>
        
        <?php echo "<h1 class='text-center'>$title</h1>"; ?>
        <main>
            <?php get_content(); ?>
        </main>

        <?php require 'Template/footer.php'; ?>
        <!-- <?php require 'Template/footer.php'; ?> shows again-->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    
    </body>
</html>