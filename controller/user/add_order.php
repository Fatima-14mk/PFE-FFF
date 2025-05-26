<?php
session_start();
$conn = new mysqli("localhost", "root", "", "onaaph");

$userID = $_SESSION['userID'];
$toolID = intval($_POST['toolID']);

// Vérifier si déjà demandé
$check = $conn->prepare("SELECT * FROM `order` WHERE userID = ? AND toolID = ?");
$check->bind_param("ii", $userID, $toolID);
$check->execute();
$checkResult = $check->get_result();

if ($checkResult->num_rows > 0) {
    // Déjà demandé
    header("Location: ../../views/user/user tools/usertools.php?error=already_requested");
    exit();
}

// Ajouter la commande
$now = date('Y-m-d');
$insert = $conn->prepare("INSERT INTO `order` (orderDate, status, userID, toolID) VALUES (?, 'pending', ?, ?)");
$insert->bind_param("sii", $now, $userID, $toolID);
$insert->execute();

header("Location: ../../views/user/requests status/requests-status.php?success=added");
exit();
