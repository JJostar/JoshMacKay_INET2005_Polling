<?php
    include("getPollInfo.php");

    $voteArray = array($numOfCandidates - 1);
    $nameArray = array($numOfCandidates - 1);
    echo "<h1>$question</h1><p>$pollMessage</p>
        <table><tr><th>Candidate Name</th><th>Votes</th></tr>";
    for ($x = 1; $x <= $numOfCandidates; $x++) {
        $row = $queryResult->fetch_row();
        $candID = $row[0];
        $candName = $row[1];
        $sqlStmt = "SELECT * FROM Votes WHERE PollID = '$currentPollID' AND CandID = '$candID'";
        $votesResult = mysqli_query($conn, $sqlStmt);
        $votes = mysqli_num_rows($votesResult);
        echo "<tr><td>$candName</td><td>$votes</td></tr>";
        $voteArray[$candID] = $votes;
        $nameArray[$candID] = $candName;
        $highestID = $candID;
        $secondID = $candID;
        $lowestID = $candID; //These need to be initalized to an ID that exists in this group of candidates.
    }
    $conn->close();
    echo "</table>";

    $highestVotes = 0;
    $secondVotes = 0;
    $lowestVotes = PHP_INT_MAX;
    foreach ($voteArray as $c => $v) { // This ended up being more complicated than I thought. Maybe it would have been better to do this
        // as a SQL statement but oh well, it's done now.
        if ($c != 0) { // Foreach starts at 0 when there's no ID 0 for some reason. Why???
            if ($v > $highestVotes) {
                $secondVotes = $highestVotes;
                $highestVotes = $v;
                $secondID = $highestID;
                $highestID = $c;
            } else if ($v > $secondVotes) {
                $secondVotes = $v;
                $secondID = $c;
            } else if ($v <= $lowestVotes) {
                $lowestVotes = $v;
                $lowestID = $c;
            }
        }
    }

    echo "<p>In the lead are $nameArray[$highestID] with $voteArray[$highestID] vote(s) and $nameArray[$secondID] with $voteArray[$secondID].</p>
        <p>Bringing up the rear is $nameArray[$lowestID] with only $voteArray[$lowestID] vote(s).</p>";

    if ($pollWon) {
        echo '<form action="openPoll.php" method="POST">
            <input type="submit" value="Reopen poll">
            <input type="hidden" name="currentPollID"  value="' . $currentPollID . '">
        </form>';
    } else {
        echo '<form action="closePoll.php" method="POST">
            <input type="submit" value="Close poll">
            <input type="hidden" name="winnerID" value="' . $highestID . '">
            <input type="hidden" name="winnerName" value="' . $nameArray[$highestID] . '">
            <input type="hidden" name="currentPollID"  value="' . $currentPollID . '">
        </form>'; // Not entirely sure why I need to concatenate these in here, but it works, and just using the variable names doesn't.
    }
?>
<a href='index.php'>Back to index</a>