<?php
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}
$sql = "SELECT Visitor.fullName, Visitor.phoneNumber, Visitor.email, Message.content, Message.idMsg 
        FROM Message
        JOIN Visitor ON Visitor.id = Message.person_id
        ORDER BY Message.idMsg DESC";
$result = $conn->query($sql);
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
        <h1>Messages List</h1>
        <div class="table-container">
            <table>
                <thead>
                 <tr>
    <th>Full Name</th>
    <th>Phone Number</th>
    <th>Email</th>
    <th>Message</th>
    <th>Details</th>
</tr>

                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                       <tr>
                               <td><?= htmlspecialchars($row['fullName']) ?></td>
                               <td><?= htmlspecialchars($row['phoneNumber']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td class="message-preview"><?= substr(htmlspecialchars($row['content']), 0, 30) ?>...</td>
                                <td><a href="detail_msg.php?id=<?= $row['idMsg'] ?>" class="details-btn">See Details</a></td>
</tr>

                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
