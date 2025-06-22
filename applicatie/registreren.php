<?php
require 'db_connectie.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = maakVerbinding();
    
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $role = 'klant'; // standaard rol

    $stmt = $conn->prepare("INSERT INTO [User] (username, password, first_name, last_name, address, role) VALUES (?, ?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$username, $password, $first_name, $last_name, $address, $role]);
        $message = "Registratie succesvol! Je kunt nu inloggen.";
    } catch (PDOException $e) {
        $message = "Fout bij registreren: " . $e->getMessage();
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

<p><?= $message ?></p>
