<?php
    // to access session variables and to use session methods you always need to start the session
    session_start();

    // will delete all session variables
    session_unset();

    // destroy all data registered to a session
    session_destroy();

    header('Location: /Blog');


?>