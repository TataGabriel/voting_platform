<?php
require_once 'config.php';

// Values passed from details page
$participant_id = isset($_GET['participant_id']) ? (int)$_GET['participant_id'] : 0;
$votes = isset($_GET['votes']) ? (int)$_GET['votes'] : 0;

// fetch participant if needed
$stmt = $pdo->prepare('SELECT name FROM participants WHERE id = ?');
$stmt->execute([$participant_id]);
$participant = $stmt->fetch();

$amount = $votes * 100; // 100frs per vote
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/scripts.js" defer></script>
</head>
<body>
    <h1>Payment for <?php echo htmlspecialchars($participant ? $participant['name'] : ''); ?></h1>
    <form id="paymentForm" action="momo_api.php" method="POST">
        <input type="hidden" name="participant_id" value="<?php echo $participant_id; ?>">
        <input type="hidden" name="votes" value="<?php echo $votes; ?>">
        <div>
            <label>Payment method:</label>
            <select name="method" id="method">
                <option value="mtn">MTN MOMO</option>
                <option value="orange">Orange Money</option>
            </select>
        </div>
        <div>
            <label>Phone number:</label>
            <input type="text" name="phone" required>
        </div>
        <div>
            <p>Votes: <?php echo $votes; ?></p>
            <p>Total to pay: <span id="totalAmount"><?php echo $amount; ?></span> frs</p>
        </div>
        <button type="submit">Pay</button>
    </form>
</body>
</html>