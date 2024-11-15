<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Body Style */
        body {
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding-top: 70px;
            color: #333;
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 15px;
            background-color: #2ca4ed;
            color: #ffffff;
            text-align: center;
            z-index: 1000;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        nav ul li a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            background-color: #1c80b8;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #14699d;
        }

        /* Form Container */
        .form-container {
            width: 90%;
            max-width: 500px;
            background-color: #ffffff;
            padding: 25px;
            margin-top: 100px;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            color: #2ca4ed;
            margin-bottom: 20px;
        }

        /* Form Styles */
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, select:focus {
            border-color: #2ca4ed;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
<header>
    <h1>HealthTrackAI</h1>
    <nav>
        <ul>
            <li><a href="admin.php"><i class="fas fa-key"></i> Account User List</a></li>
            <li><a href="admin_doctor.php" class="section-btn">Doctor List</a></li>
            <li><a href="schedule_appointment.php" class="section-btn">Schedule Appointment List</a></li>
            <li><a href="add_doctor.php" class="section-btn">Add Doctor</a></li>
            <li><a href="add_schedule_appointment.php" class="section-btn">Add Schedule Appointment</a></li>
            <li><a href="index.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</header>

<div class="form-container">
    <h2>Add Customer</h2>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="contact">Hotline:</label>
        <input type="text" id="contact" name="contact" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Add Customer</button>
        <a href="admin.php">Back</a>
    </form>
</div>
</body>
</html>
