<?php
session_start();
require_once 'db_connectie.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'personeel') {
    header("Location: login.php");
    exit;
}

$conn = maakVerbinding();

// Status wijzigen als er op de knop geklikt wordt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = intval($_POST['status']);
    
    $stmt = $conn->prepare("UPDATE Pizza_Order SET status = ? WHERE order_id = ?");
    $stmt->execute([$status, $order_id]);
}

// Alle bestellingen ophalen
$stmt = $conn->query("SELECT * FROM Pizza_Order ORDER BY datetime DESC");
$bestellingen = $stmt->fetchAll();
?>

<h2>Bestellingoverzicht personeel</h2>
<p>Welkom <?= htmlspecialchars($_SESSION['name']) ?> – <a href="logout.php">Uitloggen</a></p>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Klant</th>
        <th>Adres</th>
        <th>Datum/tijd</th>
        <th>Status</th>
        <th>Wijzig status</th>
    </tr>

    <?php foreach ($bestellingen as $b): ?>
        <tr>
            <td><?= htmlspecialchars($b['order_id'] ?? 'Onbekend') ?></td>
            <td><?= htmlspecialchars($b['client_username'] ?? 'Onbekend') ?></td>
            <td><?= htmlspecialchars($b['address'] ?? 'Onbekend') ?></td>
            <td><?= htmlspecialchars($b['datetime'] ?? 'Onbekend') ?></td>
            <td><?= htmlspecialchars($b['status'] ?? 'Onbekend') ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="order_id" value="<?= $b['order_id'] ?>">
                    <select name="status">
                        <option value="0" <?= $b['status'] == 0 ? 'selected' : '' ?>>Nieuw</option>
                        <option value="1" <?= $b['status'] == 1 ? 'selected' : '' ?>>In de oven</option>
                        <option value="2" <?= $b['status'] == 2 ? 'selected' : '' ?>>Onderweg</option>
                        <option value="3" <?= $b['status'] == 3 ? 'selected' : '' ?>>Afgeleverd</option>
                    </select>
                    <button type="submit">Opslaan</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
