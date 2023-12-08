<?php
header('Content-Type: application/json');

session_start();

include 'database.php';

if (!isset($_SESSION['currentProfileId'])) {
    $stmt = $pdo->prepare("SELECT MAX(id) as maxID FROM profiles");
    $stmt->execute();
    $maxIdResult = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['currentProfileId'] = $maxIdResult['maxID'];
} else {
  $_SESSION['currentProfileId']--;
}

$stmt = $pdo->prepare("SELECT id, title, image, category FROM profiles WHERE id = ?");
$stmt->execute([$_SESSION['currentProfileId']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profile) {
    echo json_encode(['endOfProfiles' => true]);
    exit;
}

echo json_encode($profile);
?>
