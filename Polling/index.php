<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    include_once "DBcreate.php";
?>
<head>
    <meta charset="UTF-8">
    <title>Polling Station</title>
    <h1>Welcome to the Polling Station</h1>
</head>
<body>
<?php
    include("DBconnect.php");
    $sqlStmt = "SELECT MAX(PollID) FROM Polls";
    $queryResult = mysqli_query($conn, $sqlStmt);
    $row = $queryResult->fetch_row();
    $currentPollID = $row[0];
    $_SESSION["PollID"] = $currentPollID;

    $sqlStmt = "SELECT Question FROM Polls
                WHERE PollID = '$currentPollID'";
    $queryResult = mysqli_query($conn, $sqlStmt);
    $row = $queryResult->fetch_row();
    $question = $row[0];
?>
<p>The current poll is: <?php echo $question;?><br>
Please log in to vote.</p>
<?php
    if(isset($_SESSION["LoggedUser"])) {
        $name = $_SESSION["LoggedUser"];
        $role = $_SESSION["Role"];
        echo "Logged in as $name. Role is $role.<br>";
        echo '<form action="logout.php">
            <input type="submit" value="Log out">
        </form>';
        if($role === "User") {
            echo '<form action="userPanel.php">
        <input type="submit" value="User Panel">
        </form>';
        } else if ($role === "Admin") {
            echo '<form action="adminPanel.php">
        <input type="submit" value="Admin Panel">
        </form>';
        }
    } else {
        echo '<form action="login.php">
            <input type="submit" value="Log in">
        </form>';
    }
?>
</body>
</html>