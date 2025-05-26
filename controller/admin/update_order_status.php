<?php
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$orderID = intval($_POST['orderID'] ?? 0);
$action = $_POST['action'] ?? '';

if ($orderID <= 0 || !in_array($action, ['accept', 'refuse'])) {
    die("Requête invalide.");
}

if ($action === 'accept') {
    $note = trim($_POST['pickupDate'] ?? '');
    if (empty($note)) {
        die("Date de récupération obligatoire.");
    }
    $status = 'accepted';

} elseif ($action === 'refuse') {
    $note = trim($_POST['refuseNote'] ?? '');
    if (empty($note)) {
        die("Motif de refus obligatoire.");
    }
    $status = 'refused';
}

// Enregistrement en base
$stmt = $conn->prepare("UPDATE `order` SET status = ?, note = ? WHERE orderID = ?");
$stmt->bind_param("ssi", $status, $note, $orderID);
$stmt->execute();

header("Location: ../../views/admin/requests/requests.php");
exit;
?>
