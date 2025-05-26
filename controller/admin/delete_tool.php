<?php
$pdo = new mysqli("localhost", "root", "", "onaaph");

if ($pdo->connect_error) {
    die("Connection failed: " . $pdo->connect_error);
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: ../../views/admin/tools/tools.php?error=invalid_id");
    exit();
}

// Étape 1 : supprimer d'abord les commandes liées
$deleteOrders = $pdo->prepare("DELETE FROM `order` WHERE toolID = ?");
$deleteOrders->bind_param("i", $id);
$deleteOrders->execute();

// Étape 2 : supprimer le tool lui-même
$deleteTool = $pdo->prepare("DELETE FROM tool WHERE toolID = ?");
$deleteTool->bind_param("i", $id);
$deleteTool->execute();

// Redirection après succès
header("Location: ../../views/admin/tools/tools.php?success=deleted");
exit();
?>
