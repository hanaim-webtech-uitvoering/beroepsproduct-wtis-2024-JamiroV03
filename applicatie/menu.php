<?php
session_start();
require_once 'db_connectie.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'klant') {
    header("Location: login.php");
    exit;
}

$conn = maakVerbinding();

// Producten ophalen
$stmt = $conn->query("SELECT * FROM Product ORDER BY name ASC");
$productlijst = $stmt->fetchAll();
?>

<h2>Menu</h2>
<p>Welkom <?= htmlspecialchars($_SESSION['name']) ?> – <a href="logout.php">Uitloggen</a> | <a href="winkelmandje.php">Winkelmandje</a></p>

<form method="post" action="winkelmandje.php">
<table border="1" cellpadding="5">
    <tr>
        <th>Product</th>
        <th>Prijs</th>
        <th>Aantal</th>
    </tr>
    <?php foreach ($productlijst as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td>€<?= number_format($product['price'], 2, ',', '.') ?></td>
            <td>
                <input type="number" name="aantal[<?= $product['name'] ?>]" value="0" min="0">
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<button type="submit">Toevoegen aan winkelmandje</button>
</form>
