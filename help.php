<?php
session_start();  // Starten der Session am Anfang des Scripts

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <title>Newstinder - Lets swipe your news!</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div id="header">
    <img id="logo" src="img/favicon.ico" alt="Logo von Newstinder">
      <div id="branding">
          <h2>Newstinder</h2>
          <p>Lets swipe your news</p>

        <!-- Burgermenü-Container -->
      <div id="menu-container">
          <!-- Burger-Symbol (drei horizontale Linien) -->
          <div id="menu-icon" onclick="toggleMenu()">
              <div class="menu-line"></div>
              <div class="menu-line"></div>
              <div class="menu-line"></div>
          </div>
          <!-- Tatsächliches Menü (initial versteckt) -->

          <!-- adminmenue -->
          <?php include 'menu.php'; ?>
      </div>
    </div>
  </div>

      <div id="profileCard">
          <h1 class="help">FAQ/Help</h1>
          <h2>Was ist Newstinder?</h2>
          <p>Newstinder ist ein neuer und innovativer Weg um News zu konsumieren. Neu siehst du nicht sofort den Artikel, sondern entscheidest zu erst, ob du mehr über die News erfahren möchtest. Alle Inhalte stammen von SRF.</p>
          <h2>Wie funktioniert es?</h2>
          <p>Du siehst zu erst die Schlagzeile und ein Bild des Artikels. Entscheide, ob du ihn lesen möchtest (grünes Herz / nach rechts swippen) oder nicht (rotes X / nach links swippen). Am Ende der aktuellsten zehn Meldungen wirst du automatisch zu deinen «gelikten» News weitergeleitet. Jetzt kannst du die Nachricht in voller Länge lesen und/oder einen multimedialen Inhalt dazu schauen.</p>
          <a href="index.php">Bereit? Lets swipe!</a>
          <div id="buttonContainer">
            <button id="dislikeButton" onclick="dislikeProfile()">❌</button>
            <button id="likeButton" onclick="likeProfile()">💚</button>
        </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </body>
</html>
