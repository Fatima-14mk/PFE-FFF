<?php
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$sql = "SELECT a.idAppointment, a.date, a.note, v.fullName, v.phoneNumber, v.email
        FROM Appointment a
        JOIN Visitor v ON a.person_id = v.id
        ORDER BY a.date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="appointment.css">
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
        <a href="../messages/msg_list.php">Messages</a>
        <a href="appointment.php" class="active">Appointment</a>         
    </div>
    <div class="logOut">
        <a href="../../../controller/shared/logouat.php" id="logout-btn">LogOut</a>
    </div>
  </nav>
</header>

<main>
  <h1>Appointments</h1>
  <div class="container">
    <?php while($row = $result->fetch_assoc()): ?>
    <div class="card">
      <form class="user-form" method="POST" action="../../../controller/admin/delete_appointment.php">
        <input type="hidden" name="idAppointment" value="<?= $row['idAppointment'] ?>">
        
        <div class="form-row">
          <label>Full Name:</label>
          <input type="text" value="<?= htmlspecialchars($row['fullName']) ?>" readonly>
          <label>Phone Number:</label>
          <input type="text" value="<?= htmlspecialchars($row['phoneNumber']) ?>" readonly>
        </div>

        <div class="form-row">
          <label>Email:</label>
          <input type="text" value="<?= htmlspecialchars($row['email']) ?>" readonly>
          <label>Date:</label>
          <input type="text" value="<?= htmlspecialchars($row['date']) ?>" readonly>
        </div>

        <label>Note:</label>
        <textarea readonly><?= htmlspecialchars($row['note']) ?></textarea>

        <button type="submit" class="delete-btn">Delete</button>
      </form>
    </div>
    <?php endwhile; ?>
  </div>
</main>

</body>
</html>
