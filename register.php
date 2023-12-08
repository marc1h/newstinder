<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <title>Newstinder | Registrieren</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="header">
      <img id="logo" src="img/favicon.ico" alt="Logo von Newstinder">
      <div id="branding">
          <h2>Newstinder</h2>
          <p>Lets swipe your news</p>
      </div>
    </div>
    <div id="profileCard" class="prelogin">
      <div id="registerForm">
          <h2>Registrieren</h2>
          <form action="register.php" method="post">
              <label for="username">Benutzername</label>
              <input type="text" id="username" name="username" required><br>

              <label for="email">E-Mail</label>
              <input type="email" id="email" name="email" required><br>

              <label for="password">Passwort</label>
              <input type="password" id="password" name="password" required><br>
              <p>(Bitte wähle ein sicheres Passwort mit mind. 8 Zeichen inkl. Grossbuchstaben, Sonderzeichen (z.B. $ oder !) und Zahl)</p>

              <button type="submit" name="register">Registrieren</button>
          </form>
          <span id="error-message" style="color:red;"><?php echo $errorMsg; ?></span>
      </div>
    </div>


    <?php
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include 'database.php';

    $errorMsg = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $passwordPattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

    if(!preg_match($passwordPattern, $password)) {
        $errorMsg = "Das Passwort muss mindestens 8 Zeichen lang sein, mindestens eine Zahl, ein Sonderzeichen (z.B. $ oder !) und einen Grossbuchstaben enthalten.";
    } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);

            $_SESSION['username'] = $username;
            header("Location: help.php");
            exit();
        }
    }
    ?>
    <script>
       let errorMessage = "<?php echo $errorMsg; ?>";
       if(errorMessage) {
           document.getElementById('error-message').textContent = errorMessage;
       }
   </script>
</body>
</html>
