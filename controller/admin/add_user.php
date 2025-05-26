<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "", "onaaph");
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    $fullName = $_POST['fullName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $type = $_POST['disabilityType'];
    $percentage = $_POST['percentage'];
    $password = "user123";
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $dateReg = date('Y-m-d');

    // Visitor
    $stmt1 = $conn->prepare("INSERT INTO Visitor (fullName, phoneNumber, email) VALUES (?, ?, ?)");
    $stmt1->bind_param("sss", $fullName, $phone, $email);
    $stmt1->execute();
    $visitorID = $stmt1->insert_id;
    $stmt1->close();

    // User
    $stmt2 = $conn->prepare("INSERT INTO User (userID, password, registrationDate, disabilityPercentage, disabilityType) VALUES ( ?, ?, ?, ?, ?)");
    $stmt2->bind_param("issis", $visitorID, $hashedPassword, $dateReg, $percentage, $type);
    $stmt2->execute();
    $stmt2->close();

    header("Location: ../../views/admin/users/users.php?success=1");
    exit();
}
?>
