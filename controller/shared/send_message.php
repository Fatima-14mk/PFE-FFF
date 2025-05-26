<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "onaaph";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

$fullName = trim($_POST['full_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($fullName) || empty($phone) || empty($email) || empty($message)) {
    header("Location: ../../views/guest/contact/index.php?error=Veuillez remplir tous les champs");
    exit();
}

// Vérifier si le visiteur existe déjà
$sql = "SELECT id FROM Visitor WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $visitor = $result->fetch_assoc();
    $visitor_id = $visitor['id'];
} else {
    // Insérer un nouveau visiteur
    $sqlInsert = "INSERT INTO Visitor (fullName, phoneNumber, email) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("sss", $fullName, $phone, $email);
    $stmtInsert->execute();
    $visitor_id = $stmtInsert->insert_id;
}

// Insérer le message
$sqlMsg = "INSERT INTO Message (content, person_id) VALUES (?, ?)";
$stmtMsg = $conn->prepare($sqlMsg);
$stmtMsg->bind_param("si", $message, $visitor_id);
$stmtMsg->execute();


echo '<script>window.location.href = "../../views/guest/home/index.html#contact";</script>';
exit();


?>
