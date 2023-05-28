<?php
    //set the servername
    define("SERVER_NAME", "localhost");
    //set the server username
    define("SERVER_UNAME", "sgroydmz_ccgen90");
    // set the server password (you must put password here if your using live server)
    define("SERVER_UPASS", "WtBPeQ7gbpU3PCAVC2");
    // set the database name
    define("SERVER_DB", "sgroydmz_ccgen");

    // Include functions file
    require_once 'functions.php';

    // Set a variable $db and store db connection
    $db = connectDB();
?>