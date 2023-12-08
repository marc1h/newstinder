<?php
session_start();  // Starten der Session am Anfang des Scripts

unset($_SESSION['currentProfileId']);

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';

function fetchCurrentUser() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    return $stmt->fetch();
}

$currentUser = fetchCurrentUser();

function fetchProfile() {
    global $pdo;

    if (!isset($_SESSION['currentProfileId'])) {
        $stmt = $pdo->prepare("SELECT MAX(id) as maxID FROM profiles");
        $stmt->execute();
        $maxIdResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['currentProfileId'] = $maxIdResult['maxID'];
    }

    // Überprüfen, ob die currentProfileId kleiner als die kleinste ID ist
    $stmtMinId = $pdo->prepare("SELECT MIN(id) as minID FROM profiles");
    $stmtMinId->execute();
    $minIdResult = $stmtMinId->fetch(PDO::FETCH_ASSOC);
    if ($_SESSION['currentProfileId'] < $minIdResult['minID']) {
        // Zurücksetzen der currentProfileId auf die höchste ID
        $_SESSION['currentProfileId'] = $maxIdResult['maxID'];
    }

    $stmt = $pdo->prepare("SELECT id, title, image, category FROM profiles WHERE id = ?");
    $stmt->execute([$_SESSION['currentProfileId']]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$profile) {

        return null;
    }

    return $profile;
}

$profile = fetchProfile();

// Debug-Ausgaben
// echo "Current Profile ID: " . $_SESSION['currentProfileId'] . "<br>";
// if ($profile) {
//    echo "Profile Title: " . $profile['title'] . "<br>";
//} else {
//    echo "No profile found.<br>";
//}

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
    <title>Newstinder - Lets swipe your news</title>
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

          <div id="profileCard" data-user-id="<?php echo $currentUser['id']; ?>" data-profile-id="<?php echo $profile['id']; ?>" style="background-image: url('<?php echo htmlspecialchars($profile['image']); ?>');">
          <button id="categoryButton"><?php echo htmlspecialchars($profile['category']); ?></button>
          <h2 id="profileTitle"><?php echo htmlspecialchars($profile['title']); ?></h2>
          <!-- Die Beschreibung wurde entfernt --><!-- <p id="profileDescription"><?php //echo htmlspecialchars($profile['description']); ?></p> -->
          <!-- Das Audio wurde entfernt --><!-- <audio id="profileAudio" controls src="<?php //echo htmlspecialchars($profile['audio']); ?>"></audio> -->
          <div id="buttonContainer">
            <button id="dislikeButton" onclick="dislikeProfile()">❌</button>
            <button id="likeButton" onclick="likeProfile()">💚</button>
        </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="js/swipe.js"></script>
  </body>
  <script>
      function toggleMenu() {
          var menu = document.getElementById("menu");
          if (menu.style.display === "block") {
              menu.style.display = "none";
          } else {
              menu.style.display = "block";
          }
      }
  </script>
</html>
