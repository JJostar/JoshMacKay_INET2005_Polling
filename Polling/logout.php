<?php
    session_start();
    session_destroy();
    echo "Logged out.<br><a href='index.php'>Back to index</a>";
