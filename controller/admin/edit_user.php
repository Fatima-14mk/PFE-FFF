<?php
$conn = new mysqli("localhost", "root", "", "onaaph");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// 1. Récupération des données du formulaire
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$fullName = trim($_POST['fullName']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$type = $_POST['disabilityType'];
$percentage = intval($_POST['percentage']);

// 2. Validation de base
if ($id <= 0 || empty($fullName) || empty($phone) || empty($email) || empty($type)) {
    header("Location: ../../views/admin/users/users.php?error=invalid_input");
    exit();
}

// 3. UPDATE Visitor
$stmt1 = $conn->prepare("UPDATE Visitor SET fullName = ?, phoneNumber = ?, email = ? WHERE id = ?");
$stmt1->bind_param("sssi", $fullName, $phone, $email, $id);
$stmt1->execute();
$stmt1->close();

// 4. UPDATE User
$stmt2 = $conn->prepare("UPDATE User SET disabilityType = ?, disabilityPercentage = ? WHERE userID = ?");
$stmt2->bind_param("sii", $type, $percentage, $id);
$stmt2->execute();
$stmt2->close();

// 5. Redirection
header("Location: ../../views/admin/users/users.php?success=updated");
exit();
?>
