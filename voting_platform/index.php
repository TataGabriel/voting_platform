<?php
require_once 'config.php';

// fetch participants from database
$stmt = $pdo->query('SELECT id, name, talent, image_path FROM participants');
$participants = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voting Platform</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Christian Youth Talent Show Voting Platform</h1>
    <div class="card-container">
        <?php foreach ($participants as $p): ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($p['image_path']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                <h2><?php echo htmlspecialchars($p['name']); ?></h2>
                <p><?php echo htmlspecialchars($p['talent']); ?></p>
                <a class="vote-button" href="details.php?id=<?php echo $p['id']; ?>">Vote</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>