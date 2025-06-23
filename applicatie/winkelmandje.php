<?php
session_start();
require_once 'db_connectie.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'klant') {
    header("Location: login.php");
    exit;
}

$conn = maakVerbinding();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['aantal'])) {
    $_SESSION['mandje'] = array_filter($_POST['aantal'], fn($a) => $a > 0);
}

// Als klant het bestelformulier bevestigt
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['bevestig'])) {
    $adres = trim(strip_tags($_POST['adres']));
    $klant = $_SESSION['username'];
    $naam = $_SESSION['name'];
    $datum = date('Y-m-d H:i:s');

    // Tijdelijk personeel toewijzen: bijv. 'medewerker1'
    $stmt = $conn->prepare("INSERT INTO Pizza_Order (client_username, client_name, personnel_username, datetime, status, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$klant, $naam, 'medewerker1', $datum, 0, $adres]);
    $order_id = $conn->lastInsertId();

foreach ($_SESSION['mandje'] as $product_naam => $aantal) {
    $stmt = $conn->prepare("INSERT INTO Pizza_Order_Product (order_id, product_name, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$order_id, $product_naam, $aantal]);
}


    unset($_SESSION['mandje']);
    $melding = "Je bestelling is geplaatst!";
}
?>

<h2>Winkelmandje</h2>
<p><a href="menu.php">← Terug naar menu</a> | <a href="logout.php">Uitloggen</a></p>

<?php if (!empty($melding)): ?>
    <p><strong><?= htmlspecialchars($melding) ?></strong></p>
<?php endif; ?>

<?php if (empty($_SESSION['mandje'])): ?>
    <p>Je winkelmandje is leeg.</p>
<?php else: ?>
    <form method="post">
        <p>Geef je afleveradres op:</p>
        <input name="adres" required><br><br>

        <table border="1" cellpadding="5">
            <tr><th>Product</th><th>Aantal</th></tr>
            <?php foreach ($_SESSION['mandje'] as $product => $aantal): ?>
                <tr>
                    <td><?= htmlspecialchars($product) ?></td>
                    <td><?= htmlspecialchars($aantal) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <button type="submit" name="bevestig">Bestelling plaatsen</button>
    </form>
<?php endif; ?>
