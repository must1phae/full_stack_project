<?php
$servername = "localhost";
$username = "root";
$password = "";  
$dbname = "projetweb";  
// les informations de connexion à ta base de données :

 
$conn = new mysqli($servername, $username, $password, $dbname);
// new mysqli(...) crée une nouvelle instance de connexion.

// $conn est maintenant un objet qui représente cette connexion.

// S’il y a une erreur, il sera capable de la détecter ensuite.

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
