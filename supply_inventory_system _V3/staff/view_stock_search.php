<?php
session_start(); // FIXED: Required to access $_SESSION
include '../database.php';

// Security: Verify user is Staff
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Staff') {
    exit("<tr><td colspan='6' class='text-center text-danger py-4'>Access Denied.</td></tr>");
}

$q = $_GET['q'] ?? '';
$like = "%$q%";

$stmt = $conn->prepare("
    SELECT items.*, categories.name AS cat_name
    FROM items
    JOIN categories ON items.category_id = categories.id
    WHERE items.name LIKE ? OR categories.name LIKE ? OR items.supplier LIKE ?
    ORDER BY items.name ASC
");
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
?>
    <tr>
        <td class="ps-4">
            <span class="fw-bold d-block text-dark"><?= htmlspecialchars($row['name']) ?></span>
        </td>
        <td class="text-center">
            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3">
                <?= htmlspecialchars($row['cat_name']) ?>
            </span>
        </td>
        <td class="text-center">
            <?php if ($row['quantity'] <= 5): ?>
                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1">
                    <?= $row['quantity'] ?> <i class="bi bi-exclamation-triangle ms-1"></i>
                </span>
            <?php else: ?>
                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1">
                    <?= $row['quantity'] ?>
                </span>
            <?php endif; ?>
        </td>
        <td class="text-center text-muted small"><?= htmlspecialchars($row['unit']) ?></td>
        <td class="text-muted small"><?= htmlspecialchars($row['supplier']) ?></td>
        <td class="pe-4 text-end">
            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-50 px-3 py-1 fw-bold">
                ₱<?= number_format($row['price'], 2) ?>
            </span>
        </td>
    </tr>
<?php 
    endwhile; 
else: 
    echo "<tr><td colspan='6' class='text-center py-5 text-muted'>No items found matching '$q'.</td></tr>";
endif;
?>