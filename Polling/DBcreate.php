<?php
//This file will create the database on your local machine and fill it with test data if it does not already exist.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pollingdb";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection to database failed. ". $conn->connect_error);
} else {
    if (empty(mysqli_fetch_array(mysqli_query($conn,"SHOW DATABASES LIKE '$dbname'")))) {
        //Checks to see if the database exists. Solution found here: https://stackoverflow.com/questions/6023363/checking-if-a-database-exists
        $sqlStmt = "CREATE DATABASE IF NOT EXISTS $dbname;";
        if ($conn->query($sqlStmt)) {
            $conn->close();
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sqlStmt = "CREATE TABLE IF NOT EXISTS Users (
            UserID int NOT NULL AUTO_INCREMENT,
            Username varchar(20) UNIQUE NOT NULL,
            Password varchar(20) UNIQUE NOT NULL,
            UserRole varchar(7) NOT NULL,
            PRIMARY KEY (UserID)
        );
        CREATE TABLE IF NOT EXISTS Polls (
                PollID int NOT NULL AUTO_INCREMENT,
                Question varchar(255) NOT NULL,
                WinnerID int,
                PRIMARY KEY (PollID)
        );
        CREATE TABLE IF NOT EXISTS Candidates (
            CandID int NOT NULL AUTO_INCREMENT,
            CandName varchar(255) NOT NULL,
            PollID int,
            PRIMARY KEY (CandID),
            FOREIGN KEY (PollID) REFERENCES Polls(PollID)
        );
        ALTER TABLE Polls
            ADD FOREIGN KEY (WinnerID) REFERENCES Candidates(CandID);
        CREATE TABLE IF NOT EXISTS Votes (
            UserID int NOT NULL,
            CandID int NOT NULL,
            PollID int NOT NULL,
            FOREIGN KEY (UserID) REFERENCES Users(UserID),
            FOREIGN KEY (CandID) REFERENCES Candidates(CandID)
        );
        
        INSERT INTO Users (Username, Password, UserRole)
            VALUES ('admin', 'adminpw', 'Admin'), ('user1', '123', 'User'), ('user2', '234', 'User'), ('user3', '345', 'User'), ('user4', '456', 'User');
        INSERT INTO Polls (Question) VALUES ('Who should be mayor of Flavortown?');
        INSERT INTO Candidates (CandName, PollID) VALUES ('Guy Fieri', 1), ('Gordon Ramsay', 1), ('Jamie Oliver', 1);";
            if (!$conn->multi_query($sqlStmt)) {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
$conn->close();