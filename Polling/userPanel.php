<?php
    include("getPollInfo.php");

    echo "<h1>$question</h1><p>$pollMessage</p><p>Candidates:</p>
    <form action='vote.php' method='POST'>";
    for ($x = 1; $x <= $numOfCandidates; $x++) {
        $row = $queryResult->fetch_row();
        echo "<input type='radio' id='Cand' name='Cand' value='$row[1]'>
        <label for='Cand'>$row[1]</label><br>";
    }
    $conn->close();
    echo "<input type='submit' value='Vote'></form>";
?>
<a href='index.php'>Back to index</a>