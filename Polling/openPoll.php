<?php
    include("DBconnect.php");
    $currentPollID = $_POST["currentPollID"];
    $sqlStmt = "UPDATE Polls SET WinnerID = NULL WHERE PollID = '$currentPollID'";
    mysqli_query($conn, $sqlStmt);
    echo "Poll reopened.<br>";
    ?>
<a href='index.php'>Back to index</a>
