<?php
    include("DBconnect.php");
    $winnerID = $_POST["winnerID"];
    $winnerName = $_POST["winnerName"];
    $currentPollID = $_POST["currentPollID"];

    $sqlStmt = "UPDATE Polls SET WinnerID = '$winnerID' WHERE PollID = '$currentPollID'";
    mysqli_query($conn, $sqlStmt);
    echo "Poll closed. $winnerName is declared the winner.<br>";
    $conn->close();
?>
<a href='index.php'>Back to index</a>