<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria Sole Machina</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        header {
            background-color: #ff4500;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        nav {
            background-color: #333;
            color: white;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 20px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .button {
            display: inline-block;
            background-color: #ff4500;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #e03e00;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welkom bij Pizzeria Sole Machina!</h1>
    </header>
    <nav>
        <a href="#menu">Menu</a>
        <a href="#winkelmandje">Winkelmandje</a>
        <a href="#profiel">Profiel</a>
        <a href="#registratie">Registreren/Inloggen</a>
        <a href="#bestellingen">Bestellingoverzicht</a>
        <a href="#privacy">Privacyverklaring</a>
    </nav>
    <main class="container">
        <section id="menu">
            <h2>Menu</h2>
            <p>Bekijk ons heerlijke assortiment pizza's, drankjes en meer.</p>
        </section>

        <section id="winkelmandje">
            <h2>Winkelmandje</h2>
            <p>Bekijk en bevestig je bestelling.</p>
        </section>

        <section id="profiel">
            <h2>Profiel</h2>
            <p>Bekijk je bestellingen en je accountinformatie.</p>
        </section>

        <section id="registratie">
            <h2>Registreren/Inloggen</h2>
            <p>Maak een account aan of log in om verder te gaan.</p>
            <a href="#" class="button">Registreren</a>
            <a href="#" class="button">Inloggen</a>
        </section>

        <section id="bestellingen">
            <h2>Bestellingoverzicht</h2>
            <p>Overzicht van alle bestellingen (alleen voor personeel).</p>
        </section>

        <section id="privacy">
            <h2>Privacyverklaring</h2>
            <p>Lees hier hoe wij jouw gegevens beschermen.</p>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Pizzeria Sole Machina. Alle rechten voorbehouden.</p>
    </footer>
</body>
</html>
