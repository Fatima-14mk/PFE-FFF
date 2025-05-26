<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../../guest/log_in/index2.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "onaaph");
$userID = $_SESSION['userID'];

$sql = "SELECT o.orderDate, o.status, o.note, t.name AS toolName, t.toolID, t.image 
        FROM `order` o
        JOIN tool t ON o.toolID = t.toolID
        WHERE o.userID = ?
        ORDER BY o.orderID DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta charset="UTF-8" />
  <link rel="stylesheet" href="requests-status.css">
  <title>ONAAPH Access</title>
</head>
<body>
  <!-- NAVBAR -->
  <header id="home"> 
    <nav class="fade-in">
            <button class="menu-toggle">☰</button>
      <div class="logo fade-in">
        <img src="../../../public/images/shared/logo.png" alt="Logo" />
      </div>
      <div class="menu fade-in">
        <a href="../user tools/usertools.php">Tools</a>
        <a href="requests-status.php" class="active">Requests status</a>
        <div class="menu-container">
          <a href="#" id="settings-btn">Settings</a>
          <div id="dropdown-menu" class="dropdown">
            <a href="../myprofile/myprofile.php">👤My profile</a>
            <a href="../../../controller/shared/logouat.php">⬅ Log out</a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <main class="container">
    <h1>My Requests</h1>

    <section class="cards-container">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card">
          <img src="../../../uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= $row['toolName'] ?>" width="100" />

          <div class="info">
            <strong><?= htmlspecialchars($row['toolName']) ?></strong>
            <div class="date">Requested on <?= htmlspecialchars($row['orderDate']) ?></div>
          </div>

          <?php
            $status = strtolower($row['status']);
            $statusText = "";
            $icon = "";

            if ($status === 'pending') {
              $statusText = "Under Review";
              $icon = "⏳";
            } elseif ($status === 'accepted') {
              $statusText = "Approved";
              $icon = "✅";
            } elseif ($status === 'refused') {
              $statusText = "Not Eligible";
              $icon = "❌";
            }
          ?>

          <div class="status <?= $status ?>">
            <div class="status-content">
              <div class="status-badge"><div class="icon"><?= $icon ?></div> <?= $statusText ?></div>
              <?php if ($status === 'accepted' && !empty($row['note'])): ?>
                <div class="note">📅 Pick-up: <?= htmlspecialchars($row['note']) ?></div>
              <?php elseif ($status === 'refused' && !empty($row['note'])): ?>
                <div class="note">📝 Note: <?= htmlspecialchars($row['note']) ?></div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </section>
  </main>

 <!-- Footer -->
     <footer id="footer">
      <div class="footer-container">
        
        <div class="footer-section">
          <div class="logo fade-in">
            <img src="../../../public/images/shared/logo.png" alt="logo" />
          </div>
          <strong>Office National D'appareillage <br> et Accessoires pour Personnes Handecapees</strong>
        </div>
        
        <div class="footer-section">
          <h3>Our Partners</h3>
          <ul>
            <li><a href="https://www.ottobock.com">Ottobock</a></li>
            <li><a href="http://www.proteor.com">Protéor</a></li>
            <li><a href="https://www.oticon.com">Oticon</a></li>
            <li><a href="https://www.coloplast.com">Coloplast</a></li>
          </ul>
        </div>
     
        <div class="footer-section">
          <h3>Contact</h3>
          <p>📍 Address: Algiers, Bouira</p>
          <p>📞 Phone: +213 123 456 789</p>
          <p>📧 Email: <a href="mailto:contact@onaaph.dz">contact@onaaph.dz</a></p>

        </div>

       
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 ONAAPH. All rights reserved.</p>
      </div>
    </footer>


  <script src="../../../public/js/user/requests-status.js"></script>
</body>
</html>
