<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <title>Newstinder | Login</title>
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
        <div id="loginForm">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <label for="login_username">Benutzername</label>
                <input type="text" id="login_username" name="login_username" required><br>

                <label for="login_password">Passwort</label>
                <input type="password" id="login_password" name="login_password" required><br>

                <div class="button-container">
                  <button type="submit" name="login">Anmelden</button>
                  <button type="button" onclick="location.href='register.php'">Registrieren</button>
              </div>
            </form>

            <?php
            session_start();

            include 'database.php';

            // Funktion zum Überprüfen des Passworts
            function verifyPassword($input_password, $hashed_password, $salt) {
                $salted_password = $input_password . $salt;
                return password_verify($salted_password, $hashed_password);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
                $login_username = $_POST["login_username"];
                $login_password = $_POST["login_password"];

                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$login_username]);
                $user = $stmt->fetch();

                if ($user) {
                    if (verifyPassword($login_password, $user['password_hash'], $user['salt'])) {
                        $_SESSION['username'] = $user['username'];
                        header("Location: index.php");
                        exit();
                    } else {
                        $login_error = "Benutzername und/oder Passwort falsch.";
                        echo "<p>$login_error</p>";
                    }
                } else {
                    $login_error = "Dieser Benutzername wurde nicht gefunden.";
                    echo "<p>$login_error</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
