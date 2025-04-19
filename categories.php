<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Categories</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
      min-height: 100vh;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      align-items: flex-start; /* Prevent form from stretching */
      justify-content: space-between;
      padding: 40px 20px;
      max-width: 1200px;
      margin: auto;
      gap: 30px;
    }

    .form-container {
      margin-top: 80px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
      padding: 30px;
      flex: 1 1 45%;
      min-width: 300px;
    }

    .table-container {
      margin-top: 80px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
      padding: 30px;
      flex: 1 1 45%;
      min-width: 300px;
      max-height: 600px;
      overflow-y: auto;
      margin-bottom: 180px;
    }

    .form-container h2 {
      text-align: center;
      font-size: 26px;
      margin-bottom: 25px;
      color: #333;
    }

    label {
      font-size: 14px;
      margin-bottom: 8px;
      display: block;
      color: #444;
    }

    input[type="text"] {
      width: 100%;
      padding: 14px 16px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f9f9f9;
      margin-bottom: 20px;
      outline: none;
      transition: border 0.3s;
    }

    input[type="text"]:focus {
      border-color: #007bff;
      box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    }

    button[type="submit"] {
      width: 100%;
      padding: 14px;
      background-color: #007bff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 500;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s;
    }

    button:hover {
      background-color: #0056b3;
      transform: scale(1.02);
    }

    .table-responsive {
      width: 100%;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 600px;
    }

    th, td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid #eaeaea;
      font-size: 15px;
      color: #333;
    }

    th {
      background-color: #007bff;
      color: white;
      font-weight: 600;
      position: sticky;
      top: 0;
      z-index: 1;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #f1f5f9;
    }

    .action-btn {
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      font-size: 13px;
      color: white;
      margin-right: 6px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .action-btn:hover {
      opacity: 0.9;
    }

    .action-btn.edit {
      background-color: #28a745;
    }

    .action-btn.delete {
      background-color: #dc3545;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        padding: 20px;
      }

      .form-container h2 {
        font-size: 22px;
      }

      input, button {
        font-size: 14px;
        padding: 12px;
      }

      th, td {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

  <?php include("header.php"); ?>
  <?php include("database/db_connect.php"); ?>

  <div class="container">
    <!-- Form Container -->
    <div class="form-container">
      <h2>Categories</h2>
      <form method="POST" action="categories.php">
        <label for="text">Category</label>
        <input type="text" id="text" name="Name" placeholder="Enter category name" required />
        <button type="submit" name="addcat">Add Category</button>
      </form>
    </div>

    <div class="table-container">
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
                <tr>
                   <td>1</td>
                    <td>hello</td>
                    <td>
                        <button class='action-btn edit'>Edit</button>
                        <button class='action-btn delete'>Delete</button>
                        </td>
                    </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php include("footer.php"); ?>

  <?php
  if (isset($_POST['addcat'])) {

      $name = mysqli_real_escape_string($conn, $_POST["Name"]);

      if (!empty($name)) {
          $query = "INSERT INTO categories (name) VALUES ('$name')";
          $result = mysqli_query($conn, $query);

          if ($result) {
              echo "<script>alert('Category added successfully'); window.location.href='categories.php';</script>";
          } else {
              echo "<script>alert('Failed to add category');</script>";
          }
      } else {
          echo "<script>alert('Category name cannot be empty');</script>";
      }

      mysqli_close($conn);
  }
?>

</body>
</html>
