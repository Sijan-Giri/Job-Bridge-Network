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
      align-items: flex-start;
      justify-content: space-between;
      padding: 40px 20px;
      max-width: 1200px;
      margin: auto;
      gap: 30px;
    }

    .form-container {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
      padding: 30px;
      flex: 1 1 45%;
      min-width: 300px;
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

    .table-container {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 0;
      flex: 1 1 45%;
      min-width: 300px;
      max-height: 600px;
      overflow-y: auto;
      overflow-x: auto;
      margin-bottom: 180px;
    }

    .styled-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      min-width: 600px;
      font-size: 15px;
      border-radius: 12px;
      overflow: hidden;
      background-color: white;
    }

    .styled-table thead {
      background: linear-gradient(to right, #007bff, #3399ff);
      color: white;
      text-transform: uppercase;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 0.04em;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .styled-table th,
    .styled-table td {
      padding: 16px 18px;
      text-align: left;
    }

    .styled-table tbody tr:nth-child(even) {
      background-color: #f8fafd;
    }

    .styled-table tbody tr:hover {
      background-color: #eaf2ff;
      transition: background-color 0.2s ease-in-out;
    }

    .styled-table td:first-child,
    .styled-table th:first-child {
      border-top-left-radius: 10px;
      border-bottom-left-radius: 10px;
    }

    .styled-table td:last-child,
    .styled-table th:last-child {
      border-top-right-radius: 10px;
      border-bottom-right-radius: 10px;
    }

    .action-btn {
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      font-size: 13px;
      color: white;
      margin-right: 6px;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
    }

    .action-btn:hover {
      transform: scale(1.05);
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

      .action-btn {
        font-size: 12px;
        padding: 6px 10px;
      }

      .styled-table {
        min-width: 100%;
      }
    }
  </style>
</head>
<body>

<?php include("header.php"); ?>
<?php include("database/db_connect.php"); ?>

<?php
$editMode = false;
$editCatName = "";
$editCatId = "";

if (isset($_GET['edit'])) {
    $editCatId = $_GET['edit'];
    $editMode = true;

    $editQuery = "SELECT * FROM categories WHERE catid = '$editCatId'";
    $editResult = mysqli_query($conn, $editQuery);

    if ($editResult && mysqli_num_rows($editResult) > 0) {
        $editData = mysqli_fetch_assoc($editResult);
        $editCatName = htmlspecialchars($editData['name']);
    }
}

if (isset($_GET['delete'])) {
    $catId = $_GET['delete'];
    $deleteQuery = "DELETE FROM categories WHERE catid = '$catId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('Category deleted successfully'); window.location.href='categories.php';</script>";
    } else {
        echo "<script>alert('Failed to delete category');</script>";
    }
}
?>

<div class="container">
  <div class="form-container">
    <h2><?php echo $editMode ? 'Edit Category' : 'Categories'; ?></h2>
    <form method="POST" action="categories.php<?php echo $editMode ? '?edit=' . $editCatId : ''; ?>">
      <label for="text">Category</label>
      <input 
        type="text" 
        id="text" 
        name="Name" 
        placeholder="Enter category name" 
        value="<?php echo $editMode ? $editCatName : ''; ?>" 
        required 
        autofocus
      />
      <button type="submit" name="<?php echo $editMode ? 'updatecat' : 'addcat'; ?>">
        <?php echo $editMode ? 'Update Category' : 'Add Category'; ?>
      </button>
    </form>
    <?php if ($editMode): ?>
      <p style="text-align:center; margin-top:10px;">
        <a href="categories.php" style="text-decoration:none; color:#007bff;">Cancel Edit</a>
      </p>
    <?php endif; ?>
  </div>

  <div class="table-container">
    <div class="table-responsive">
      <table class="styled-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $query = "SELECT * FROM categories ORDER BY catid DESC";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  $catId = htmlspecialchars($row['catid']);
                  $catName = htmlspecialchars($row['name']);
                  echo "<tr>";
                  echo "<td>$catId</td>";
                  echo "<td>$catName</td>";
                  echo "<td>
                          <a href='categories.php?edit=$catId' class='action-btn edit'>Edit</a>
                          <a href='categories.php?delete=$catId' class='action-btn delete' onclick='return confirm(\"Are you sure you want to delete this category?\");'>Delete</a>
                        </td>";
                  echo "</tr>";
              }
            } else {
                echo "<tr><td colspan='3'>No categories found.</td></tr>";
            }
          ?>
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
}


if (isset($_POST['updatecat']) && isset($_GET['edit'])) {
  $updatedName = mysqli_real_escape_string($conn, $_POST["Name"]);
  $updateId = $_GET['edit'];

  if (!empty($updatedName)) {
      $updateQuery = "UPDATE categories SET name = '$updatedName' WHERE catid = '$updateId'";
      $updateResult = mysqli_query($conn, $updateQuery);

      if ($updateResult) {
          echo "<script>alert('Category updated successfully'); window.location.href='categories.php';</script>";
      } else {
          echo "<script>alert('Failed to update category');</script>";
      }
  } else {
      echo "<script>alert('Category name cannot be empty');</script>";
  }
}

mysqli_close($conn);
?>

<script>
  const form = document.querySelector("form");
  const categoryInput = document.getElementById("text");

  form.addEventListener("submit", function (e) {
    const categoryValue = categoryInput.value.trim();

    if (categoryValue === "") {
      e.preventDefault();
      alert("Category name cannot be empty!");
    }
  });
</script>

</body>
</html>
