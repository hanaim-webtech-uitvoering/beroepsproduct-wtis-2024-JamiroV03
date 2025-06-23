<?php
session_start();
require_once 'db_connectie.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = maakVerbinding();

    $gebruikersnaam = trim(strip_tags($_POST['username']));
    $wachtwoord     = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM [User] WHERE username = ?");
    $stmt->execute([$gebruikersnaam]);
    $gebruiker = $stmt->fetch();

    if ($gebruiker && password_verify($wachtwoord, $gebruiker['password'])) {
        $_SESSION['username'] = $gebruiker['username'];
        $_SESSION['role'] = $gebruiker['role'];
        $_SESSION['name'] = $gebruiker['first_name'];

        if ($gebruiker['role'] === 'klant') {
            header("Location: profiel.php");
        } elseif ($gebruiker['role'] === 'personeel') {
            header("Location: overzicht.php");
        }
        exit;
    } else {
        $message = "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>

<h2>Inloggen</h2>
<form method="post">
    <input name="username" placeholder="Gebruikersnaam" required><br>
    <input name="password" type="password" placeholder="Wachtwoord" required><br>
    <button type="submit">Inloggen</button>
</form>

<p><?= htmlspecialchars($message) ?></p>
