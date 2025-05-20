<?php
include '../connect.php';

// Suppression d'une note individuelle
if (isset($_GET['id_n'])) {
    $id_n = intval($_GET['id_n']);
    $id_M = intval($_GET['id_M'] ?? 0);

    $stmt = $conn->prepare("DELETE FROM note WHERE id_n = ?");
    $stmt->bind_param("i", $id_n);
    $stmt->execute();
    $stmt->close();

    header("Location: anote.php?id_M=$id_M");
    exit();
}
// Suppression d'un module
if (isset($_GET['delete_module'])) {
    $id_M = intval($_GET['delete_module']);

    // Supprimer d'abord les notes associées à ce module (clé étrangère)
    $conn->query("DELETE FROM note WHERE id = $id_M");

    // Ensuite supprimer le module
    $conn->query("DELETE FROM module WHERE id_M = $id_M");

    header("Location: home.php");
    exit();
}

// Suppression de toutes les notes d'un module


// Redirection par défaut
header("Location: home.php");
exit();
