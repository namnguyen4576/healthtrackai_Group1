<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - HealthTrackAI</title>
  <link rel="stylesheet" href="assets/css/register.css">
</head>

<body>
  <header>
    <h1>HealthTrackAI</h1>
  </header>

  <main>
    <section class="registration" id="registration">
      <h2>Create Your Account</h2>
      <form action="process_registration.php" method="POST">
        <div>
          <label for="user-id">User ID:</label>
          <input type="text" id="user-id" name="user-id" required>
        </div>

        <div>
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required>
        </div>

        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div>
          <label for="contact">Contact Number:</label>
          <input type="tel" id="contact" name="contact" required>
        </div>

        <div>
          <label for="gender">Gender:</label>
          <select id="gender" name="gender" required>
            <option value="" disabled selected>Select your gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>

        <div>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Register</button>
      </form>
    </section>
  </main>

</body>

</html>
