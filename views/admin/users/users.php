<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="users.css">
    <title>ONAAPH Access</title>
</head>
<body> 
    <!-- HEADER NAVBAR -->
    <header id="home"> 
      <nav class="fade-in">
          <div class="logo fade-in">
              <img src="../../../public/images/shared/logo.png" alt="Logo" loading="lazy">
          </div>
          <div class="menu fade-in">
              <a href="../requests/requests.php">Requests</a>
              <a href="../tools/tools.php">Tools</a>
              <a href="users.php" class="active">Users</a>
              <a href="../messages/msg_list.php">Messages</a>
              <a href="../appointment/appointment.php">Appointment</a>         
          </div>
          <div class="logOut">
              <a href="../../../controller/shared/logouat.php" id="logout-btn">LogOut</a>
          </div>
          <div class="mobile-menu-btn">
              <i class="fas fa-bars"></i>
          </div>
      </nav>
    </header>

    <main>
        <h1> Users </h1>
        <section class="dashboard">
            <div class="top-bar">
                <div class="filter-section">
                    <label for="filter">Filter by disability type:</label>
                    <select id="filter">
                        <option value="all">All</option>
                        <option value="motor">Motor</option>
                        <option value="visual">Visual</option>
                        <option value="hearing">Hearing</option>
                    </select>
                </div>
                <div class="actions-top">
                    <button class="add-user-btn" type="button"> +Add user</button>              
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Disability Type</th>
                        <th>Disability Percentage</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
<?php
$conn = new mysqli("localhost", "root", "", "onaaph");
$sql = "SELECT v.id, v.fullName, v.phoneNumber, v.email, u.disabilityType, u.disabilityPercentage, u.registrationDate
        FROM Visitor v
        JOIN User u ON v.id = u.userID
        ORDER BY v.id DESC";
$result = $conn->query($sql);
?>
<tbody>
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['fullName']) ?></td>
        <td><?= htmlspecialchars($row['phoneNumber']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['disabilityType']) ?></td>
        <td><?= htmlspecialchars($row['disabilityPercentage']) ?>%</td>
        <td><?= htmlspecialchars($row['registrationDate']) ?></td>
        <td>
            <button type="button" class="btn-edit">✍🏻</button>
            <a href="../../../controller/admin/delete_user.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">🗑️</a>
        </td>
    </tr>
<?php endwhile; ?>
</tbody>
            </table>
        </section>
    </main>

    <!-- MODAL FORM -->
    <div id="user-form-modal" style="display: none;" class="modal">
        <div class="form-container">
          <h2 id="form-title">Add User</h2>
          <form id="user-form" method="POST" action="../../../controller/admin/add_user.php">
            <input type="hidden" name="id" id="userId" value="0">

            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" required>
      
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>
      
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
      
            <label for="disabilityType">Disability Type:</label>
            <select id="disabilityType" name="disabilityType" required>
              <option value="motor">Motor</option>
              <option value="visual">Visual</option>
              <option value="hearing">Hearing</option>
            </select>
      
            <label for="percentage">Disability Percentage:</label>
            <input type="number" id="percentage" name="percentage"  min="10"  max="100" step="10" value="10" required>
      
            <div class="form-actions">
              <button type="submit" id="submit">Save</button>
              <button type="button" id="close-form">Cancel</button>
            </div>
          </form>
        </div>
    </div>

    <script src="../../../public/js/admin/users.js"></script>
    <script>
document.querySelectorAll(".btn-edit").forEach((btn) => {
  btn.addEventListener("click", function () {
    const row = btn.closest("tr");
    const cells = row.querySelectorAll("td");
    console.log("DEBUG: bouton ✍🏻 cliqué", cells[0].innerText);

    document.getElementById("form-title").innerText = "Edit User";
    document.getElementById("user-form").action = "../../../controller/admin/edit_user.php";

    document.getElementById("userId").value = cells[0].innerText;
    document.getElementById("fullName").value = cells[1].innerText;
    document.getElementById("phone").value = cells[2].innerText;
    document.getElementById("email").value = cells[3].innerText;
    document.getElementById("disabilityType").value = cells[4].innerText.toLowerCase();
    document.getElementById("percentage").value = parseInt(cells[5].innerText);
    document.getElementById("user-form-modal").style.display = "flex";
  });
});
</script>

</body>
</html>
