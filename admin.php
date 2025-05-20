<?php
session_start(); // Démarrer la session pour stocker les informations de l'utilisateur
include 'connect.php'; // Inclure votre fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; 
    $password = $_POST['pwd'];

    // Vérifier si "Remember Me" est coché
    $remember_me = isset($_POST['remember_me']) ? true : false;

    // Préparer la requête SQL en utilisant des instructions préparées
    $stmt = mysqli_prepare($conn, "SELECT * FROM administrator WHERE user = ? AND password = ?");//preparer la reaquette sql 
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);//lie la les valeur de username et passwoed avec ? ,?
    mysqli_stmt_execute($stmt);//executer la requette sql
    $result = mysqli_stmt_get_result($stmt);//recupperer les resulta de la requette sql executé et 

    // Vérification
    if (mysqli_num_rows($result) === 1) {
        $_SESSION['loggedin'] = true;//verifier si l'utilisateur est deja connecter via username and password 
        $_SESSION['username'] = $username;

        // Si "Remember Me" est coché, enregistrer l'utilisateur dans un cookie
        if ($remember_me) {
            setcookie('username', $username, time() + (30 * 24 * 60 * 60), "/"); // Durée du cookie 30 jours
            setcookie('password', $password, time() + (30 * 24 * 60 * 60), "/"); // Durée du cookie 30 jours
        } else {
            // Si "Remember Me" n'est pas coché, supprimer les cookies existants
            setcookie('username', '', time() - 3600, "/");
            setcookie('password', '', time() - 3600, "/");
        }

        header("Location: crud/home.php");//si l'admin a entrer l username et le password correcte il l'envoyer vers la page home.php

        exit;
    } else {
        echo "<script>alert('Invalid username or password');</script>";//si le password ou user est incorrecte , afficher l'alerte suivant 
    }

    // Libérer les résultats et fermer la connexion
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!-- Formulaire HTML -->



<!DOCTYPE html>
<!-- Formulaire de connexion -->



<html>

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login</title>
</head>

<body>
 
    <form action="admin.php" method="POST">
        <article>
            <img src="images/teacher.png" alt="">
        </article>
        <article>
           <h2>Sign in as Admin</h2>
        <div>
            <i class="fa fa-user"></i>
            <input id="username" type="text" placeholder="Username" name="username" value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>"><br>
        </div>
        <div>
            <i class="fa fa-lock"></i>
            <input id="pwd" type="password" placeholder="Password" name="pwd" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>"><br>
        </div>

        <div>
            <input type="checkbox" name="remember_me" id="remember_me" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>> 
            <label for="remember_me">Remember Me</label><br>
        </div>

        <input type="submit" value="Sign In"> 
        <a href="index.php" class="cancel">Cancel</a>
        </article>
        
       

    </form>

</body>

</html> 
