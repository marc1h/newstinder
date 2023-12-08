<?php
session_start();

include 'database.php';


try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    if(isset($_POST['user_id'], $_POST['profile_id'], $_POST['action'])) {

        $stmtCheckProfile = $pdo->prepare("SELECT id FROM profiles WHERE id = ?");
        $stmtCheckProfile->execute([$_POST['profile_id']]);
        $profileExists = $stmtCheckProfile->fetch();

        if (!$profileExists) {
            echo json_encode(['error' => 'Profile ID existiert nicht in der profiles Tabelle']);
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM matches WHERE user_id = ? AND profile_id = ?");
        $stmt->execute([$_POST['user_id'], $_POST['profile_id']]);
        $result = $stmt->fetch();

        if($result) {
            $stmt = $pdo->prepare("UPDATE matches SET action = ? WHERE user_id = ? AND profile_id = ?");
            $stmt->execute([$_POST['action'], $_POST['user_id'], $_POST['profile_id']]);
        } else {
            // Kein Eintrag gefunden, also neuen hinzufügen
            $stmt = $pdo->prepare("INSERT INTO matches (user_id, profile_id, action) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['user_id'], $_POST['profile_id'], $_POST['action']]);
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Unvollständige Daten']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
