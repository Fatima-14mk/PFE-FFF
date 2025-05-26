<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['userID'])) {
    header("Location: ../../guest/log_in/index2.php");
    exit();
}

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupération du fullName depuis Visitor
$userID = $_SESSION['userID'];
$sql = "SELECT fullName FROM Visitor WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$fullName = $user['fullName'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user1page.css">
    <title>ONAAPH Access</title>
</head>
<body>
    <!-- HEADER NAVBAR -->
    <header id="home"> 
        <nav class="fade-in">
           <button class="menu-toggle">☰</button>
            <div class="logo fade-in">
                <img src="../../../public/images/shared/logo.png" alt="Logo" loading="lazy">
            </div>

            <div class="menu fade-in">
                <a href="../requests status/requests-status.php">Requests status</a>              
                <div class="menu-container">  
                    <a href="#" id="settings-btn">Settings</a>
                    <div id="dropdown-menu" class="dropdown">
                        <a href="../myprofile/myprofile.php">👤 My profile</a>
                        <a href="../../../controller/shared/logouat.php">⬅ Log out</a>
                    </div>
                </div>        
            </div>

            
        </nav>
    </header>


<main>
    
     <h2 style=" font-size: 2.5rem;
    color: var(--primary-color);
    margin-buttom: 10px;
    opacity: 1;
    text-align:center;
    animation: fadeSlide 0.8s ease-out forwards;">Welcome <?php echo htmlspecialchars($fullName); ?> 👋</h2>
    <a href="../user tools/usertools.php" class="btn-enter">Get needs</a>
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



    <script src="../../../public/js/user/user1page.js"></script>
</body>
</html>
