<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HealthTrackAI</title>
  <link rel="stylesheet" href="assets/css/query.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <header>
    <h1>HealthTrackAI</h1>
    <nav>
      <ul>
        <li><a href="home.php"><i class="fas fa-home"></i> HOME</a></li>
        <li><a href="hospitals.php"><i class="fas fa-hospital"></i> HOSPITALS</a></li>
        <li><a href="doctors.php"><i class="fas fa-user-md"></i> DOCTORS</a></li>
        <li><a href="query.php" class="<?= basename($_SERVER['PHP_SELF']) == 'query.php' ? 'active' : '' ?>"><i class="fas fa-comments"></i> QUERY</a></li>
        <li><a href="index.php"><i class="fas fa-lock"></i> LOGOUT</a></li>
      </ul>
    </nav>
  </header>

  <div class="welcome-message">
    <p>Welcome... !</p>
    <hr>
  </div>

</body>

</html>
