<?php
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) die("Erreur de connexion : " . $conn->connect_error);

$toolID = intval($_POST['toolID']);
$quantity = intval($_POST['quantity']);

$stmt = $conn->prepare("UPDATE tool SET quantity = ? WHERE toolID = ?");
$stmt->bind_param("ii", $quantity, $toolID);
$stmt->execute();

header("Location: ../../views/admin/tools/tools.php?updated=1");
exit();
?>
