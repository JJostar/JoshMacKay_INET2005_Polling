<?php
    session_start();
    if ($_SESSION["Role"] === "Admin") {
        echo "Admins cannot vote.";
    } else {
        include("DBconnect.php");
        $pollID = $_SESSION["PollID"];
        $sqlStmt = "SELECT WinnerID FROM Polls WHERE PollID = '$pollID';";
        $queryResult = mysqli_query($conn, $sqlStmt);
        $row = $queryResult->fetch_row();
        $winnerID = $row[0];
        if (!empty($winnerID)) {
            echo "This poll is closed.";
        } else {
            $username = $_SESSION["LoggedUser"];
            $sqlStmt = "SELECT UserID FROM Users WHERE Username = '$username';";
            $queryResult = mysqli_query($conn, $sqlStmt);
            $row = $queryResult->fetch_row();
            $userID = $row[0];

            $sqlStmt = "SELECT * FROM Votes WHERE UserID = '$userID' AND PollID = '$pollID';";
            $queryResult = mysqli_query($conn, $sqlStmt);
            $matches = mysqli_num_rows($queryResult);
            if ($matches === 1) {
                echo "You have already voted in this poll.";
            } else {
                $candName = $_POST["Cand"];
                $sqlStmt = "SELECT CandID FROM Candidates WHERE CandName = '$candName';";
                $queryResult = mysqli_query($conn, $sqlStmt);
                $row = $queryResult->fetch_row();
                $candID = $row[0];

                $sqlStmt = "INSERT INTO Votes VALUES ('$userID', '$candID', '$pollID');";
                mysqli_query($conn, $sqlStmt);
                echo "You have cast your vote for $candName.";

            }
        }
    }
    $conn->close();
    ?>
<br><a href='index.php'>Back to index</a>