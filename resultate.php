<?php
session_start();  // Starten der Session am Anfang des Scripts

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

// Abfrage aller gematchten Profile für einen Benutzer
function fetchMatchedProfiles($userId) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT profiles.* FROM matches INNER JOIN profiles ON matches.profile_id = profiles.id WHERE matches.action = 1 AND matches.user_id = ? ORDER BY profiles.id DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$profiles = fetchMatchedProfiles($currentUser['id']);
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
                <?php include 'menu.php'; ?>
            </div>
        </div>
    </div>

    <div id="resultsContainer">
      <?php foreach ($profiles as $profile): ?>
          <div id="profileCard" class="result" data-user-id="<?php echo $currentUser['id']; ?>" data-profile-id="<?php echo $profile['id']; ?>" style="background-image: url('<?php echo htmlspecialchars($profile['image']); ?>');">
              <button id="categoryButton"><?php echo htmlspecialchars($profile['category']); ?></button>
              <h2 id="profileTitle"><?php echo htmlspecialchars($profile['title']); ?></h2>
              <p id="profileDescription"><?php echo htmlspecialchars($profile['description']); ?></p>

              <?php
              if (!empty($profile['media'])):
                  if (strpos($profile['media'], 'iframe') !== false): ?>
                      <?php echo $profile['media']; ?>
                  <?php else: ?>
                      <audio class="profileAudio" controls src="<?php echo htmlspecialchars($profile['media']); ?>"></audio>
                  <?php endif;
              endif;
              ?>

          </div>
      <?php endforeach; ?>
  </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--<script src="js/swipe.js"></script>-->
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
</body>
</html>
