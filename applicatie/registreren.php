<?php
require_once 'db_connectie.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = maakVerbinding();

    $gebruikersnaam = trim(strip_tags($_POST['username']));
    $wachtwoord     = trim($_POST['password']);
    $voornaam       = trim(strip_tags($_POST['first_name']));
    $achternaam     = trim(strip_tags($_POST['last_name']));
    $adres          = trim(strip_tags($_POST['address']));
    $rol            = 'klant';

    if (empty($gebruikersnaam) || empty($wachtwoord) || empty($voornaam) || empty($achternaam) || empty($adres)) {
        $message = "Vul alle velden correct in.";
    } else {
        $hashed_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO [User] (username, password, first_name, last_name, address, role) VALUES (?, ?, ?, ?, ?, ?)");

        try {
            $stmt->execute([$gebruikersnaam, $hashed_wachtwoord, $voornaam, $achternaam, $adres, $rol]);
            $message = "Registratie succesvol! Je kunt nu inloggen.";
        } catch (PDOException $e) {
            $message = "Fout bij registreren: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<h2>Registreren</h2>
<form method="post">
    <input name="username" placeholder="Gebruikersnaam" required><br>
    <input name="password" type="password" placeholder="Wachtwoord" required><br>
    <input name="first_name" placeholder="Voornaam" required><br>
    <input name="last_name" placeholder="Achternaam" required><br>
    <input name="address" placeholder="Adres" required><br>
    <button type="submit">Registreer</button>
</form>

<p><?= htmlspecialchars($message) ?></p>
