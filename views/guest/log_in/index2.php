<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css"> 
    <title>ONAAPH Access</title>
  </head>

  <body>
    <!-- Home -->
    <header id="home">
      <nav class="fade-in">
        <button class="menu-toggle">☰</button>
        <div class="logo fade-in">
          <img src="../../../public/images/shared/logo.png" alt="logo" />
        </div>
        <div class="menu fade-in">
          <a href="../home/index.html#home" class="fade-in">Home</a>
          <a href="../home/index.html#about" class="fade-in">About us</a>
          <a href="../home/index.html#contact" class="fade-in">Contact</a>
        </div>
        <div class="register fade-in">
          <a href="../donor/donor.php" class="fade-in">Donor</a>
          <a href="#" class="fade-in">Log in</a>
        </div>
      </nav>
      
    </header>

    <main class="form-container">
      <h2>Log In</h2>
      <form action="../../../controller/shared/login.php" method="POST">
      <?php
        if (isset($_GET['error'])) {
           echo '<div style="color: red; margin-bottom: 15px; ">' . htmlspecialchars($_GET['error']) . '</div>';
             }
             ?>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </div>
        <div class="form-group full-width">
          <a href="../home/index.html#contact" class="forgot-password"
            >Forgot password?</a>
        </div>
        <button type="submit">Log In</button>
        <p class="signup-text">
          Don't have an account? <a href="../booknow/index1.php">Book now</a>
        </p>
      </form>
    </main>
    <script src="../../../public/js/guest/home/script.js"></script>
  </body>
</html>
