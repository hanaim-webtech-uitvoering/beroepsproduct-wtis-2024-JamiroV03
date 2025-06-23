<?php
session_start();
require_once 'db_connectie.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'klant') {
    header("Location: login.php");
    exit;
}

$conn = maakVerbinding();
$klant = $_SESSION['username'];

// Bestellingen van de klant ophalen
$stmt = $conn->prepare("SELECT * FROM Pizza_Order WHERE client_username = ? ORDER BY datetime DESC");
$stmt->execute([$klant]);
$bestellingen = $stmt->fetchAll();
?>

<h2>Welkom terug, <?= htmlspecialchars($_SESSION['name']) ?>!</h2>
<p>Je bent ingelogd als klant.</p>

<nav>
    <a href="menu.php"> Menu</a>
    <a href="winkelmandje.php"> Winkelmandje</a>
    <a href="logout.php"> Uitloggen</a>
</nav>

<h3>Jouw bestellingen</h3>

<?php if (empty($bestellingen)): ?>
    <p>Je hebt nog geen bestellingen geplaatst.</p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Bestelnummer</th>
            <th>Datum/tijd</th>
            <th>Adres</th>
            <th>Status</th>
        </tr>
        <?php foreach ($bestellingen as $b): ?>
            <tr>
                <td><?= htmlspecialchars($b['order_id']) ?></td>
                <td><?= htmlspecialchars($b['datetime']) ?></td>
                <td><?= htmlspecialchars($b['address']) ?></td>
                <td>
                    <?php
                    $status = [
                        0 => 'Nieuw',
                        1 => 'In de oven',
                        2 => 'Onderweg',
                        3 => 'Afgeleverd'
                    ];
                    echo htmlspecialchars($status[$b['status']] ?? 'Onbekend');
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
