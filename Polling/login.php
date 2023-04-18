<?php
    session_start();
    if (!empty($_SESSION["Error"])) {
        echo $_SESSION["Error"] . "<br>";
        $_SESSION["Error"] = "";
    }
?>
<html>
<form action="checkUser.php" method="POST">
    Username: <input type="text" name="Username"><br>
    Password: <input type="text" name="Password"><br>
    <input type="submit" value="Log in">
</form>
</html>
