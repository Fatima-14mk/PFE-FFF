<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['idAppointment']);

    $conn = new mysqli("localhost", "root", "", "onaaph");
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $sql = "DELETE FROM Appointment WHERE idAppointment = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: ../../views/admin/appointment/appointment.php");
exit();
