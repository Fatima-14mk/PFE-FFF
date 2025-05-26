<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../../views/guest/log_in/index2.php");
    exit();
}

$userID = $_SESSION['userID'];
$current = $_POST['current_password'] ?? '';
$new = $_POST['new_password'] ?? '';
$repeat = $_POST['repeat_password'] ?? '';

if ($new !== $repeat) {
    header("Location: ../../views/user/myprofile/myprofile.php?error=password_mismatch");
    exit();
}

$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer le mot de passe haché
$sql = "SELECT password FROM User WHERE userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: ../../views/user/myprofile/myprofile.php?error=notfound");
    exit();
}

$row = $result->fetch_assoc();
$hashedPassword = $row['password'];

// Vérifier le mot de passe actuel
if (!password_verify($current, $hashedPassword)) {
    header("Location: ../../views/user/myprofile/myprofile.php?error=wrongpassword");
    exit();
}

// Mettre à jour avec le nouveau mot de passe haché
$newHashed = password_hash($new, PASSWORD_DEFAULT);
$update = $conn->prepare("UPDATE User SET password = ? WHERE userID = ?");
$update->bind_param("si", $newHashed, $userID);
$update->execute();

header("Location: ../../views/user/myprofile/myprofile.php?success=password_updated");
exit();
?>
