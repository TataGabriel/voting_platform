<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = (int)$_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM participants WHERE id = ?');
$stmt->execute([$id]);
$participant = $stmt->fetch();
if (!$participant) {
    echo "Participant not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($participant['name']); ?> - Details</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/scripts.js" defer></script>
</head>
<body>
    <div class="detail-card">
        <img src="<?php echo htmlspecialchars($participant['image_path']); ?>" alt="<?php echo htmlspecialchars($participant['name']); ?>">
        <h2><?php echo htmlspecialchars($participant['name']); ?></h2>
        <p>Age: <?php echo htmlspecialchars($participant['age']); ?></p>
        <p>Address: <?php echo htmlspecialchars($participant['address']); ?></p>
        <p>Email: <?php echo htmlspecialchars($participant['email']); ?></p>
        <p>Church: <?php echo htmlspecialchars($participant['church']); ?></p>
        <p>Phone: <?php echo htmlspecialchars($participant['phone']); ?></p>
        <p>Country: <?php echo htmlspecialchars($participant['country']); ?></p>

        <div class="vote-selector">
            <button id="minus">-</button>
            <input type="number" id="voteCount" value="1" min="1">
            <button id="plus">+</button>
        </div>

        <form id="voteForm" action="payment.php" method="GET">
            <input type="hidden" name="participant_id" value="<?php echo $participant['id']; ?>">
            <input type="hidden" name="votes" id="votesField" value="1">
            <button type="submit" class="vote-button">Proceed to Payment</button>
        </form>
    </div>
</body>
</html>