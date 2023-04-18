<?php
    session_start();
    include("DBconnect.php");
    $pollMessage = "This poll is still open.";
    $pollWon = false;
    $sqlStmt = "SELECT MAX(PollID) FROM Polls";
    $queryResult = mysqli_query($conn, $sqlStmt)->fetch_row();
    $currentPollID = $queryResult[0];
    $_SESSION["PollID"] = $currentPollID;

    $sqlStmt = "SELECT * FROM Polls WHERE PollID = '$currentPollID'";
    $queryResult = mysqli_query($conn, $sqlStmt)->fetch_row();
    $question = $queryResult[1];
    if (!empty($queryResult[2])) {
        $pollWon = true;
        $winnerID = $queryResult[2];
        $sqlStmt = "SELECT CandName FROM Candidates WHERE CandID = '$winnerID'";
        $queryResult = mysqli_query($conn,$sqlStmt)->fetch_row();
        $winnerName = $queryResult[0];
        $pollMessage = "This poll is closed. The winner is $winnerName.";
    }

    $sqlStmt = "SELECT * FROM Candidates WHERE PollID = '$currentPollID'";
    $queryResult = mysqli_query($conn, $sqlStmt);
    $numOfCandidates = mysqli_num_rows($queryResult);