<?php
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

$idMsg = intval($_GET['id']);

$sql = "SELECT Visitor.fullName, Visitor.phoneNumber, Visitor.email, Message.content
        FROM Message
        JOIN Visitor ON Visitor.id = Message.person_id
        WHERE Message.idMsg = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idMsg);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Message introuvable.";
    exit();
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="msg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>ONAAPH Access</title>
</head>
<body>
    <header id="home"> 
        <nav class="fade-in">
            <div class="logo fade-in">
                <img src="../../../public/images/shared/logo.png" alt="Logo" loading="lazy">
            </div>
            <div class="menu fade-in">
               <a href="../requests/requests.php">Requests</a>
                <a href="../tools/tools.php">Tools</a>
                <a href="../users/users.php">Users</a>
                <a href="msg_list.php" class="active">Messages</a>
                <a href="../appointment/appointment.php">Appointment</a>         
            </div>
            <div class="logOut">
                <a href="../../../controller/shared/logouat.php" id="logout-btn">LogOut</a>
            </div>
           
        </nav>
    </header>
   
    <main>
        <div class="message-details-container">
            <div class="message-header">
                <a href="msg_list.php" class="return-btn"><i class="fas fa-arrow-left"></i> Retour</a>
            </div>
            
            <div class="message-content">
                <div class="sender-info">
                    <p><strong><i class="fas fa-user"></i> Full Name:</strong> <?= htmlspecialchars($row['fullName']) ?></p>
                    <p><strong><i class="fas fa-phone"></i> Phone Number:</strong> <?= htmlspecialchars($row['phoneNumber']) ?></p>
                    <p><strong><i class="fas fa-envelope"></i> Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                </div>
                
                <div class="message-text-container">
                    <h3><i class="fas fa-envelope-open-text"></i> Message</h3>
                    <div class="message-text">
                        <?= nl2br(htmlspecialchars($row['content'])) ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
