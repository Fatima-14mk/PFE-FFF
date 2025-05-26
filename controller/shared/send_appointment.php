<?php
$fullName = trim($_POST['full_name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$date = $_POST['date'];
$note = trim($_POST['note']);

$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

// Vérifier si le visiteur existe
$sql = "SELECT id FROM Visitor WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $visitor = $result->fetch_assoc();
    $visitor_id = $visitor['id'];
} else {
    $sqlInsert = "INSERT INTO Visitor (fullName, phoneNumber, email) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("sss", $fullName, $phone, $email);
    $stmtInsert->execute();
    $visitor_id = $stmtInsert->insert_id;
}
// Vérifier si un rendez-vous identique existe déjà
$sqlCheck = "SELECT idAppointment FROM Appointment 
             WHERE date = ? AND person_id = ? AND note = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("sis", $date, $visitor_id, $note);
$stmtCheck->execute();
$resCheck = $stmtCheck->get_result();

if ($resCheck->num_rows > 0) {
    // Le même rendez-vous existe déjà → stop
    echo '<script>alert("Ce rendez-vous a déjà été enregistré."); window.location.href = document.referrer;</script>';
    exit();
}


// Vérifier le nombre de rendez-vous pour cette date
$sqlCount = "SELECT COUNT(*) AS total FROM Appointment WHERE date = ?";
$stmtCount = $conn->prepare($sqlCount);
$stmtCount->bind_param("s", $date);
$stmtCount->execute();
$countResult = $stmtCount->get_result();
$count = $countResult->fetch_assoc()['total'];

// Si 10 rendez-vous ou plus : afficher erreur
if ($count >= 10) {
    header("Location: ../../views/guest/booknow/index1.html?error=date");
exit();

}

//  Insertion avec time sécurisé
$currentTime = date("H:i:s");
$sqlApp = "INSERT INTO Appointment (date, time, note, person_id) VALUES (?, ?, ?, ?)";
$stmtApp = $conn->prepare($sqlApp);
$stmtApp->bind_param("sssi", $date, $currentTime, $note, $visitor_id);
$stmtApp->execute();

//  Redirection discrète vers la même page
header("Location: ../../views/guest/booknow/index1.php?success=1");
exit();
?>
