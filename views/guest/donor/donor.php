<?php
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$sql = "SELECT * FROM tool WHERE quantity = 0 ORDER BY toolID DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="donor.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ONAAPH Access</title>
</head>
<body>
  <header id="home">
    <nav class="fade-in">
      <button class="menu-toggle">☰</button>
      <div class="logo fade-in">
        <img src="../../../public/images/shared/logo.png" alt="Logo ONAAPH" loading="lazy">
      </div>
      <div class="menu fade-in">
        <a href="../../../views/guest/home/index.html">Home</a>
        <a href="#needs">Needs</a>
        <a href="#payment">Donate</a>
        <a href="#why-donate">Why & How</a>
        <a href="#contact">Contact</a>
      </div>
    </nav>
  </header>

  <main>
    <section class="text1">
      <h1 class="animate__animated animate__slideInLeft">
        Every donation is a seed of hope planted in someone's future.
      </h1>
      <h2 class="animate__animated animate__slideInRight">
        <em>Give today!</em>
      </h2>
    </section>

    <!-- SECTION DES BESOINS -->
    <section class="cards-container" id="needs">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="flip-card">
          <div class="flip-card-inner">
            <div class="flip-card-front">
              <img src="../../../uploads/<?= htmlspecialchars($row['image']) ?>" alt="Image of <?= htmlspecialchars($row['name']) ?>">
            </div>
            <div class="flip-card-back">
              <h2><?= htmlspecialchars($row['name']) ?></h2>
              <h6 class="price"><strong>Needs Donation</strong></h6>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </section>

    <!-- SECTION PAIEMENT -->
    <section id="payment" class="payment_section">
      <div class="payment-info">
        <h1><i class="fas fa-credit-card"></i> Our Bank Coordinates</h1>
        <ul>
          <li><i class="fas fa-wallet"></i> Postal Account (CCP): 123456789</li>
          <li><i class="fas fa-university"></i> Bank Account (RIP): 987654321</li>
        </ul>
      </div>
    </section>

    <!-- SECTION POURQUOI DONNER -->
    <section id="why-donate" class="section-container">
      <div class="text-explain">
        <h2>Why and How to Donate?</h2>
        <p>Do you have tools that are no longer in use? You can give them a second life by donating them!</p>
        <p>Millions of people with disabilities face challenges due to lack of essential tools. You can help change that.</p>
        <ul>
          <li>Donate equipment like mobility aids, assistive devices, etc.</li>
          <li>Make a financial donation to support delivery and logistics.</li>
        </ul>
        <p>Every contribution matters. Thank you! <i class="fas fa-heart"></i></p>
      </div>
    </section>
  </main>

  <!-- FOOTER -->
  <footer id="contact">
    <div class="footer-container">
      <div class="footer-section">
        <div class="logo fade-in">
          <img src="../../../public/images/shared/logo.png" alt="logo" />
        </div>
        <strong>ONAAPH – National Office for Assistive Devices</strong>
      </div>

      <div class="footer-section">
        <h3>Our Partners</h3>
        <ul>
          <li><a href="https://www.ottobock.com" target="_blank">Ottobock</a></li>
          <li><a href="http://www.proteor.com" target="_blank">Protéor</a></li>
          <li><a href="https://www.oticon.com" target="_blank">Oticon</a></li>
          <li><a href="https://www.coloplast.com" target="_blank">Coloplast</a></li>
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

  <script src="../../../public/js/guest/donor/donor.js"></script>
</body>
</html>
