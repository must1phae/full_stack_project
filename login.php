<?php
include 'connect.php'; // Include your DB connection file
session_start(); // Start the session to store user information

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['pwd']);

    // Prepare the SQL query using prepared statements
    $stmt = mysqli_prepare($conn, "SELECT * FROM etudiant WHERE username = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if a matching record exists
    if (mysqli_num_rows($result) === 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        echo "<script>alert('Connection successful');</script>";
        header("Location: dashboard/home.php");
        exit;
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }

    // Free result and close the statement
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!-- HTML Form -->
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>sign in</title>
</head>

<body>
 
    <form action="login.php" method="POST">
        <article>
            <img src="images/students.png" alt="">
        </article>
        <article>
               <h2>login as a student</h2>
        <div>

            <i class="fa fa-user"></i>
            <input id="username" type="text" placeholder="Username" name="username"><br>
        </div>
        <div>
            <i class="fa fa-lock"></i>
            <input id="pwd" type="password" placeholder="password" name="pwd"><br>
        </div>


        <input type="submit" value="sign in">
        <a href="index.php" class="cancel">Cancel</a>
        

        </article>
     
 
    </form>

</body>

</html>