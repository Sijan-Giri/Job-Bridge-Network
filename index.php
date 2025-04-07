<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form</title>
  <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* Global Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Arial', sans-serif;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(to bottom right, #6366F1, #4F46E5); /* Gradient background */
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100vh;
}

.form-container {
  background-color: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 500px;
}

.heading {
  text-align: center;
  font-size: 2rem;
  font-weight: 700;
  color: #4F46E5;
  margin-bottom: 1.5rem;
}

.input-group {
  margin-bottom: 1.5rem;
}

.label {
  font-size: 0.875rem;
  font-weight: 600;
  color: #4A4A4A;
  margin-bottom: 0.5rem;
  display: block;
}

.input {
  width: 100%;
  padding: 0.75rem;
  border-radius: 8px;
  border: 1px solid #D1D5DB;
  font-size: 1rem;
  color: #333;
  outline: none;
  transition: all 0.3s;
}

.input:focus {
  border-color: #6366F1;
  box-shadow: 0 0 5px rgba(99, 102, 241, 0.6);
}

.submit-btn {
  width: 100%;
  padding: 1rem;
  background-color: #6366F1;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 1.125rem;
  font-weight: 700;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.submit-btn:hover {
  background-color: #4F46E5;
}

.submit-btn:active {
  transform: scale(0.98);
}

</style>
<body class="bg-gradient">

  <div class="container">
    <div class="form-container">
      <h1 class="heading">Create an Account</h1>

      <form action="insert.php" method="post">
        Name Input -->
        <div class="input-group">
          <label for="name" class="label">Name</label>
          <input
            type="text"
            name="name"
            id="name"
            class="input"
            placeholder="Enter your name"
            required
          />
        </div>

        <!-- Email Input -->
        <div class="input-group">
          <label for="email" class="label">Email Address</label>
          <input
            type="email"
            name="email"
            id="email"
            class="input"
            placeholder="youremail@example.com"
            required
          />
        </div>

        <!-- Password Input -->
        <div class="input-group">
          <label for="password" class="label">Password</label>
          <input
            type="password"
            name="password"
            id="password"
            class="input"
            placeholder="Enter your password"
            required
          />
        </div>

        <!-- User Type Select -->
        <div class="input-group">
          <label for="user_type" class="label">User Type</label>
          <select name="user_type" id="user_type" class="input" required>
            <option value="job_seeker">Job Seeker</option>
            <option value="employee">Employee</option>
            <option value="admin">Admin</option>
          </select>
        </div>

        <!-- Phone Number Input -->
        <div class="input-group">
          <label for="phone" class="label">Phone Number</label>
          <input
            type="number"
            name="phone"
            id="phone"
            class="input"
            placeholder="Enter your phone number"
            required
          />
        </div>

        <!-- Address Input -->
        <div class="input-group">
          <label for="address" class="label">Address</label>
          <input
            type="text"
            name="address"
            id="address"
            class="input"
            placeholder="Enter your address"
            required
          />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Submit</button>
      </form>
    </div>
  </div>

</body>
</html>
