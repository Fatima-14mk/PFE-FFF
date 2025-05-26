<?php
$conn = new mysqli("localhost", "root", "", "onaaph");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$sql = "SELECT o.orderID, o.orderDate, o.status, o.note,
               t.name AS toolName, t.description, t.image,
               v.fullName, u.disabilityType, u.disabilityPercentage, t.toolID
        FROM `order` o
        JOIN `user` u ON o.userID = u.userID
        JOIN `visitor` v ON u.userID = v.id
        JOIN `tool` t ON o.toolID = t.toolID
        ORDER BY u.disabilityPercentage DESC, o.orderDate DESC";



$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="requests.css">
    <title>ONAAPH Access</title>
</head>
<body>
<header id="home"> 
  <nav class="fade-in">
    <div class="logo fade-in">
      <img src="../../../public/images/shared/logo.png" alt="Logo" loading="lazy">
    </div>
    <div class="menu fade-in">
      <a href="requests.php" class="active">Requests</a>
      <a href="../tools/tools.php">Tools</a>
      <a href="../users/users.php">Users</a>
      <a href="../messages/msg_list.php">Messages</a>
      <a href="../appointment/appointment.php">Appointment</a>         
    </div>
    <div class="logOut">
      <a href="../../../controller/shared/logouat.php" id="logout-btn">LogOut</a>
    </div>
  </nav>
</header>

<main>
    <h1>Requests</h1>
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
        <table>
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Tool</th>
                    <th>User info</th>
                    <th>Disability Type</th>
                    <th>Disability %</th>
                    <th>Request Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
<td><img src="../../../uploads/<?= htmlspecialchars($row['image']) ?>" alt="pic" width="60"></td>
                    <td><?= htmlspecialchars($row['toolName']) ?></td>
                    <td><?= htmlspecialchars($row['fullName']) ?></td>
                    <td><?= htmlspecialchars($row['disabilityType']) ?></td>
                    <td><?= htmlspecialchars($row['disabilityPercentage']) ?>%</td>
                    <td><?= htmlspecialchars($row['orderDate']) ?></td>
                    <td>
  <strong><?= htmlspecialchars($row['status']) ?></strong>
  <?php if (!empty($row['note'])): ?>
    <div style="font-size: 0.85em; color: #555; margin-top: 5px;">
      <?= htmlspecialchars($row['note']) ?>
    </div>
  <?php endif; ?>
</td>

                    <td>
                        <?php if ($row['status'] === 'pending'): ?>
                           <button class="btn-accept" data-id="<?= $row['orderID'] ?>">Accept</button>
<button class="btn-refuse" data-id="<?= $row['orderID'] ?>">Refuse</button>

                        <?php else: ?>
                            <em>No action</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</main>


<!-- Modal -->
<!-- Modal d'action -->
<div id="action-modal" style="display:none;" class="modal">
  <div class="modal-content">
    <h3 id="modal-title">Confirm Action</h3>

    <form method="POST" action="../../../controller/admin/update_order_status.php" onsubmit="return validateNote();">
      <input type="hidden" name="orderID" id="modal-order-id">
      <input type="hidden" name="action" id="modal-action">

     <!-- Accept section -->
<div id="accept-section" style="display:none;">
  <label for="pickupDate">Pick-up Date:</label>
  <input type="date" name="pickupDate" id="pickupDate" required>
</div>

<!-- Refuse section -->
<div id="refuse-section" style="display:none;">
  <label for="refuseNote">Reason for refusal:</label>
  <textarea name="refuseNote" id="refuseNote" rows="3" required></textarea>
</div>


      <button type="submit">Confirm</button>
      <button type="button" onclick="closeModal()">Cancel</button>
    
    


    </form>
  </div>
</div>




<script>
function openModal(action, orderID) {
  document.getElementById('modal-order-id').value = orderID;
  document.getElementById('modal-action').value = action;

  const pickup = document.getElementById('pickupDate');
  const refuse = document.getElementById('refuseNote');

  if (action === 'accept') {
    document.getElementById('accept-section').style.display = 'block';
    document.getElementById('refuse-section').style.display = 'none';
    pickup.disabled = false;
    refuse.disabled = true;
  } else {
    document.getElementById('accept-section').style.display = 'none';
    document.getElementById('refuse-section').style.display = 'block';
    pickup.disabled = true;
    refuse.disabled = false;
  }

  document.getElementById('action-modal').style.display = 'flex';
}


function closeModal() {
  document.getElementById('action-modal').style.display = 'none';
}

function validateNote() {
  const action = document.getElementById('modal-action').value;
  
  if (action === 'accept') {
    const date = document.getElementById('pickupDate').value;
    if (!date || date.trim() === "") {
      alert("Veuillez choisir une date de récupération.");
      return false;
    }
  } else if (action === 'refuse') {
    const reason = document.getElementById('refuseNote').value;
    if (!reason || reason.trim() === "") {
      alert("Veuillez fournir une raison du refus.");
      return false;
    }
  }
console.log("Date value:", document.getElementById('pickupDate').value);

  return true;
}


// Attacher les événements après chargement DOM
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.btn-accept').forEach(btn => {
    btn.addEventListener('click', () => openModal('accept', btn.dataset.id));
  });

  document.querySelectorAll('.btn-refuse').forEach(btn => {
    btn.addEventListener('click', () => openModal('refuse', btn.dataset.id));
  });
});

const filterSelect = document.getElementById('filter');
    const rows = document.querySelectorAll('table tbody tr');
    
    if(filterSelect) {
        filterSelect.addEventListener('change', function() {
            const selectedValue = this.value.toLowerCase();
            
            rows.forEach(row => {
                const typeCell = row.cells[3];
                const typeValue = typeCell.textContent.trim().toLowerCase();
                row.style.display = (selectedValue === 'all' || typeValue === selectedValue) ? '' : 'none';
            });
        });
    }
</script>


    



</body>
</html>
