<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ONAAPH Access</title>
</head>
<body>
    <header id="home">
        <nav >
          <button class="menu-toggle">☰</button>
          <div class="logo ">
            <img src="../../../public/images/shared/logo.png" alt="logo" />
          </div>
  
          <div class="menu">
            <a href="../home/index.html#home">Home</a>
            <a href="../home/index.html#about">About us</a>
            <a href="../home/index.html#contact">Contact</a>
          </div>
          <div class="register">
            <a href="../donor/donor.php">Donor</a>
            <a href="../log_in/index2.php">Log in </a>
          </div>
        </nav>
    </header>
    <main class="form-container">
        <h2>Book Your Reservation</h2>
        <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
  <p style="color: green; font-weight: bold; margin-bottom:5px;">✅ Your appointment has been successfully booked.</p>
<?php endif; ?>
        <form method="POST" action="../../../controller/shared/send_appointment.php">

            <div class="form-row">
               <div class="form-group">
    <label for="full_name">Full Name</label>
    <input type="text" id="full_name" name="full_name" 
           pattern="[A-Za-zÀ-ÿ\s]+" title="Letters and spaces only" required>
           
    <p class="error-message" id="name-error"></p>
</div>

<div class="form-group">
    <label for="phone">Phone Number</label>
    <input type="tel" id="phone" name="phone" 
           pattern="[0-9]{10}" title="10 digits required" required>
    <p class="error-message" id="phone-error"></p>
</div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="date">Date</label>
                <input type="date" id="date" name="date" required>
<p id="date-error" style="color: red; display: none;">Date remplie — veuillez choisir une autre date</p>


                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            <div class="form-group full-width">
                <label for="note">Additional Notes</label>
                <textarea id="note" name="note"></textarea>
            </div>
            <button type="submit">Book Now</button>
        </form>
    </main>
    <script>
document.querySelector("form").addEventListener("submit", function(e) {
    e.submitter.disabled = true;
});
</script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const hasDateError = params.get("error") === "date";

    const dateInput = document.getElementById("date");
    const errorMsg = document.getElementById("date-error");

    if (hasDateError) {
      dateInput.classList.add("error-input");
      errorMsg.style.display = "block";
    }

    // Dès que l'utilisateur change la date, on enlève le rouge
    dateInput.addEventListener("change", () => {
      dateInput.classList.remove("error-input");
      errorMsg.style.display = "none";
      // En option : enlever ?error=date de l'URL
      const url = new URL(window.location.href);
      url.searchParams.delete('error');
      window.history.replaceState({}, '', url);
    });
  });
</script>
<script>
  // Supprimer ?success=1 de l'URL une fois le message affiché
  const url = new URL(window.location.href);
  if (url.searchParams.get("success") === "1") {
    // Supprimer le paramètre de l'URL sans recharger
    url.searchParams.delete("success");
    window.history.replaceState({}, document.title, url);
  }
</script>
<script src="../../../public/js/guest/book/book.js"></script>


</body>
</html>
