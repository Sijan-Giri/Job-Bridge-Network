<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Categories</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet" />
  <style>
    /* Global Styles */
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
    }

    /* Wrapper for the form and table */
    .container {
      display: flex;
      justify-content: space-between;
      padding: 40px;
      gap: 30px;
    }

    /* Form Container Styles */
    .form-container {
      width: 45%;
      background: #fff;
      border-radius: 10px;
      padding: 40px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 26px;
      color: #333;
      font-weight: 600;
    }

    .form-container label {
      display: block;
      font-size: 14px;
      margin-bottom: 8px;
      color: #333;
    }

    .form-container input {
      width: 100%;
      padding: 14px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      color: #333;
      outline: none;
      transition: border-color 0.3s ease;
    }

    .form-container input:focus {
      border-color: #007bff;
      box-shadow: 0 0 8px rgba(0, 123, 255, 0.4);
    }

    .form-container input::placeholder {
      color: #888;
    }

    .form-container button {
      width: 100%;
      padding: 14px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .form-container button:hover {
      background-color: #0056b3;
    }

    /* Table Styling */
    .table-container {
      width: 55%;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-family: 'Poppins', sans-serif;
      background-color: #fff;
      border-radius: 8px;
    }

    th, td {
      padding: 15px;
      text-align: left;
      border: 1px solid #ddd;
      font-size: 16px;
      color: #555;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    /* Action Button Styles */
    .action-btn {
      padding: 6px 12px;
      color: white;
      background-color: #28a745;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      font-size: 14px;
    }

    .action-btn:hover {
      background-color: #218838;
    }

    .action-btn.delete {
      background-color: #dc3545;
    }

    .action-btn.delete:hover {
      background-color: #c82333;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        padding: 20px;
      }

      .form-container, .table-container {
        width: 100%;
      }

      .form-container h2 {
        font-size: 22px;
      }

      .form-container input, .form-container button {
        font-size: 16px;
        padding: 12px;
      }

      .table th, .table td {
        padding: 12px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <?php include("header.php") ?>
  <div class="container">
    <!-- Form Container -->
    <div class="form-container">
      <h2>Categories</h2>
      <form action="categories.php" method="POST">
        <div class="form-group">
          <label for="text">Category</label>
          <input type="text" id="text" name="Name" placeholder="Enter category name" required />
        </div>
        <button type="submit" name="addcat">Submit</button>
      </form>
    </div>

    <!-- Table Container -->
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Apple MacBook Pro 17"</td>
            <td>Silver</td>
            <td><a class="action-btn">Edit</a> <a class="action-btn delete">Delete</a></td>
          </tr>
          <tr>
            <td>Microsoft Surface Pro</td>
            <td>White</td>
            <td><a class="action-btn">Edit</a> <a class="action-btn delete">Delete</a></td>
          </tr>
          <tr>
            <td>Magic Mouse 2</td>
            <td>Black</td>
            <td><a class="action-btn">Edit</a> <a class="action-btn delete">Delete</a></td>
          </tr>
          
          
        </tbody>
      </table>
    </div>
  </div>
  <?php include("footer.php") ?>
</body>
</html>

<?php 
    if(isset($_POST['addcat'])) {
        $name = $_POST["Name"];
        print_r($_POST);
    }
?>
