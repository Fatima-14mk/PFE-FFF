<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../../views/guest/log_in/index2.php");
    exit();
}

$userID = $_SESSION['userID'];

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phoneNumber']) ? trim($_POST['phoneNumber']) : '';

// Connexion à la base
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Mettre à jour le visiteur
$sql = "UPDATE Visitor SET email = ?, phoneNumber = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $email, $phone, $userID);
$stmt->execute();

$stmt->close();
$conn->close();


header("Location: ../../views/user/myprofile/myprofile.php?success=1");
exit();
?>
