<?php
session_start();
require 'db_connectie.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM [User] WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['first_name'];

        if ($user['role'] === 'klant') {
            header("Location: profiel.php");
        } elseif ($user['role'] === 'personeel') {
            header("Location: overzicht.php");
        }
        exit;
    } else {
        $message = "Ongeldige logingegevens";
    }
}
?>

<h2>Inloggen</h2>
<form method="post">
    <input name="username" placeholder="Gebruikersnaam" required><br>
    <input name="password" type="password" placeholder="Wachtwoord" required><br>
    <button type="submit">Inloggen</button>
</form>

<p><?= $message ?></p>
