<?php
    session_start();
    if (!isset($_SESSION["LoggedUser"])) {
        if(isset($_POST["Username"])) {
            include("DBconnect.php");
            $username = $_POST["Username"];
            $password = $_POST["Password"];
            $sqlStmt = "SELECT * FROM Users WHERE Username = '$username' AND Password = '$password'";
            $queryResult = mysqli_query($conn, $sqlStmt);
            $matches = mysqli_num_rows($queryResult);

            if ($matches == 1) {
                $sqlStmt = "SELECT * FROM Users WHERE Username = '$username'";
                $queryResult = mysqli_query($conn, $sqlStmt);
                $row = $queryResult->fetch_row();
                $_SESSION['LoggedUser'] = $row[1];
                $_SESSION['Role'] = $row[3];

                echo "Logged in as $row[1].<br>";
                echo "<a href='index.php'>Back to index</a>";
            } else {
                $_SESSION["Error"] = "Invalid username and/or password.";
                header("location: login.php");
            }
            $conn->close();
        }
    }
?>