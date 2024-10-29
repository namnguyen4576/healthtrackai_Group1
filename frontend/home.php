<?php
session_start(); // Bắt đầu phiên làm việc
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HealthTrackAI</title>
  <link rel="stylesheet" href="assets/css/home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <header>
    <h1>HealthTrackAI</h1>
    <nav>
      <ul>
        <li><a href="home.php" class="<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>"><i class="fas fa-home"></i> HOME</a></li>
        <li><a href="hospitals.php"><i class="fas fa-hospital"></i> HOSPITALS</a></li>
        <li><a href="doctors.php"><i class="fas fa-user-md"></i> DOCTORS</a></li>
        <li><a href="index.php" onclick="resetChat()"><i class="fas fa-lock"></i> LOGOUT</a></li>
      </ul>
    </nav>
  </header>

  <div class="welcome-message">
    <?php if (isset($_SESSION['user_name'])): ?>
      <p>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?>!</p>
    <?php else: ?>
      <p>Welcome...!</p>
    <?php endif; ?>
    <hr>
  </div>

  <script src="https://app.tudongchat.com/js/chatbox.js"></script>
  <script>
    const tudong_chatbox = new TuDongChat('CyClSG4NxJEVI2oYs5AQF');
    tudong_chatbox.initial();

    function resetChat() {
      // Reset chatbox and initialize it
      tudong_chatbox.reset(); // Assuming there is a reset method available
      tudong_chatbox.initial(); // Reinitialize chatbox after reset
    }
  </script>

</body>
</html>
