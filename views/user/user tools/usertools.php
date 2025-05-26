<?php
session_start();
if (!isset($_SESSION['userID'])) {
  header("Location: ../../guest/log_in/index2.php");
  exit();
}

$userID = $_SESSION['userID'];

$conn = new mysqli("localhost", "root", "", "onaaph");

$query = "SELECT disabilityType FROM user WHERE userID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($userType);
$stmt->fetch();
$stmt->close();


$sql = "SELECT * FROM tool WHERE disabilityType = ? ORDER BY toolID DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userType);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
  <link rel="stylesheet" href="usertools.css" />
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
        <a href="usertools.php" class="active">Tools</a>
        <a href="../requests status/requests-status.php">Requests status</a>
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
    <h1>Tools</h1>
    <section class="users-tools">

      <?php while ($tool = $result->fetch_assoc()): ?>
        <div class="content">
          <figure>
            <img src="../../../uploads/<?= htmlspecialchars($tool['image']) ?>" alt="img">
            <figcaption>
              <h3><?= htmlspecialchars($tool['name']) ?></h3>
            <p class="characteristics-btn"
   data-img="../../../uploads/<?= htmlspecialchars($tool['image']) ?>"
   data-title="<?= htmlspecialchars($tool['name']) ?>"
   data-desc="<?= htmlspecialchars($tool['description']) ?>">
   characteristics
</p>

            </figcaption>
            <form action="../../../controller/user/add_order.php" method="POST">
              <input type="hidden" name="toolID" value="<?= $tool['toolID'] ?>">
              <button type="submit">Add to wishList</button>
            </form>
          </figure>
        </div>
      <?php endwhile; ?>
<!-- Modal pour les détails -->
<div id="detail-modal" class="modal">
  <div class="modal-content">
    <span class="close-btn" aria-label="Fermer">&times;</span>
    <div class="modal-container">
      <div class="modal-image-container">
        <img id="modal-image" src="" alt="" />
      </div>
      <div class="modal-details">
        <h3 id="modal-title"></h3>
        <p class="description" id="modal-description"></p>
      </div>
    </div>
  </div>
</div>

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



  <!-- Modal JS optionnel si tu utilises un modal -->
  <script >// Sélection du bouton et du menu
const settingsBtn = document.getElementById('settings-btn');
const dropdownMenu = document.getElementById('dropdown-menu');

// Afficher/Masquer le menu déroulant quand on clique sur "Settings"
settingsBtn.addEventListener('click', function (event) {
  event.preventDefault(); // Empêche le lien de suivre une URL
  event.stopPropagation(); // Empêche la propagation du clic
  dropdownMenu.classList.toggle('show');
});

// Cacher le menu si on clique ailleurs
document.addEventListener('click', function (event) {
  if (!event.target.closest('.menu-container')) {
    dropdownMenu.classList.remove('show');
  }
});


// Fonction pour ouvrir et afficher le modal
function openModal(imageSrc, title, description) {
  const modal = document.getElementById('detail-modal');
  const modalImage = document.getElementById('modal-image');
  const modalTitle = document.getElementById('modal-title');
  const modalDescription = document.getElementById('modal-description');

  if (modal && modalImage && modalTitle && modalDescription) {
    modalImage.src = imageSrc;
    modalTitle.textContent = title;
    modalDescription.textContent = description;

    // Active les styles déjà définis dans ton CSS
    modal.style.display = 'flex';           // rend visible
    modal.style.visibility = 'visible';     // rend visible (en cas de hidden)
    modal.style.opacity = '1';              // rend visible (si transition opacity)
  }
}


function closeModal() {
  const modal = document.getElementById('detail-modal');
  if (modal) {
    modal.style.display = 'none';         // cache la fenêtre
    modal.style.visibility = 'hidden';
    modal.style.opacity = '0';
  }
}


// Initialisation après le chargement du DOM
document.addEventListener('DOMContentLoaded', function () {
  // Fermeture via le bouton ×
  const closeButton = document.querySelector('.close-btn');
  if (closeButton) {
    closeButton.addEventListener('click', closeModal);
  }

  // Fermeture en cliquant à l'extérieur
  const modal = document.getElementById('detail-modal');
  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === this) {
        closeModal();
      }
    });
  }
// Configuration des données pour chaque bouton
// Remplacer les anciens boutons caractéristiques par détection dynamique
document.querySelectorAll('.characteristics-btn').forEach((element) => {
  element.addEventListener('click', () => {
    const image = element.dataset.img;
    const title = element.dataset.title;
    const desc = element.dataset.desc;
    openModal(image, title, desc);
  });
});

  // Attachement des événements à tous les boutons
 
  // Fermeture avec la touche Escape
  document.addEventListener('keydown', function (e) {
    if (
      e.key === 'Escape' &&
      modal &&
      modal.style.visibility === 'visible'
    ) {
      closeModal();
    }
  });
});
</script>
<script src="../../../public/js/user/usertools.js"></script> 
</body>
</html>
