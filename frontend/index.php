<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HealthTrackAI</title>
  <link rel="stylesheet" href="assets/css/home.css">
</head>

<body>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <header>
    <h1>HealthTrackAI</h1>
    <nav>
      <ul>
        <li><a href="#chat"><i class="fas fa-home"></i> HOME</a></li>
        <li><a href="#about"><i class="fas fa-info-circle"></i> ABOUT US</a></li>
        <li><a href="#contact"><i class="fas fa-envelope"></i> CONTACT</a></li>
        <li><a href="#admin-login"><i class="fas fa-user-shield"></i> ADMIN LOGIN</a></li>
        <li><a href="#user-login"><i class="fas fa-user"></i> USER LOGIN</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="chat" id="chat">
    <img src="assets/images/chat-image.jpg" alt="Chat Interface" class="full-image" />
    </section>

    

    <section class="login-admin" id="admin-login">
      <h2>Admin Login</h2>
      <form action="#">
        <div>
          <label for="admin-id">Admin ID:</label>
          <input type="text" id="admin-id" name="admin-id" required>
        </div>

        <div>
          <label for="admin-password">Password:</label>
          <input type="password" id="admin-password" name="admin-password" required>
        </div>

        <button type="submit">LOGIN</button>
      </form>
    </section>

    <section class="login-user" id="user-login">
      <h2>User Login</h2>
      <form action="#">
        <div>
          <label for="user-email">Email:</label>
          <input type="email" id="user-email" name="user-email" required>
        </div>

        <div>
          <label for="user-password">Password:</label>
          <input type="password" id="user-password" name="user-password" required>
        </div>

        <button type="submit">LOGIN</button>
        <p>Not registered? <a href="register.php">Create an account</a></p>
      </form>
    </section>
    <section class="intro" id="about">
      <h2>About Us</h2>
      <p>Passionate about medicine. Caring for people.</p>
    </section>

    <section class="contact" id="contact">
      <h2>Contact Us</h2>
      <p>Address: HealthTrackAI, DHA Phase III Medical Center.</p>
    </section>
  </main>

</body>

</html>