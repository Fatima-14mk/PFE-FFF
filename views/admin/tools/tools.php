<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tools.css">
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
              <a href="tools.php" class="active">Tools</a>
              <a href="../users/users.php">Users</a>
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
        <h1>Tools</h1>
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
                    <button class="add-newtool-btn">+ Add new tool</button>              
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Picture</th>
                        <th>Tool</th>
                        <th>Quantity</th>
                        <th>Disability Type</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "onaaph");
                    $sql = "SELECT * FROM tool ORDER BY toolID DESC";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><img src="../../../uploads/<?= htmlspecialchars($row['image']) ?>" alt="pic" width="60"></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td><?= htmlspecialchars($row['disabilityType']) ?></td>
                      <td> <textarea readonly><?= htmlspecialchars($row['description']) ?></textarea></td>

                        <td>
                           <button class="btn-edit" 
                                   data-id="<?= $row['toolID'] ?>" 
                                   data-name="<?= htmlspecialchars($row['name']) ?>" 
                                   data-quantity="<?= $row['quantity'] ?>" 
                                   data-image="<?= htmlspecialchars($row['image']) ?>" 
                                   data-type="<?= $row['disabilityType'] ?>"
                                   data-description="<?= htmlspecialchars($row['description']) ?>"
                           >✍🏻</button>

                           <a href="../../../controller/admin/delete_tool.php?id=<?= $row['toolID'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">🗑️</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Modal pour ajouter OU modifier un outil -->
    <div id="tool-form-modal" style="display: none;" class="modal">
      <div class="form-container">
        <h2 id="tool-form-title">Add New Tool</h2>
        <form method="POST" action="../../../controller/admin/save_tool.php" enctype="multipart/form-data">
          <input type="hidden" name="toolID" id="toolID-hidden">

          <label>Image:</label>
          <input type="file" name="image" id="image-field">

          <label>Name:</label>
          <input type="text" name="name" id="name-field" required>

          <label>Quantity:</label>
          <input type="number" name="quantity" id="quantity-field" min="0" required>

          <label>Disability Type:</label>
          <select name="toolDisabilityType" id="type-field" required>
            <option value="motor">Motor</option>
            <option value="visual">Visual</option>
            <option value="hearing">Hearing</option>
          </select>

          <label>Description:</label>
          <textarea name="description" id="description-field" required></textarea>
          
          <div class="form-actions">
             <button type="submit" id="submit">Save</button>
             <button type="button" id="close-tool-form">Cancel</button>
         </div>
        
        </form>
      </div>
    </div>

    <script src="../../../public/js/admin/tools.js"></script>
</body>
</html>
