<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Management</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      display: flex;
      flex-direction: column;
      min-height: 100vh; 
    }

    .container {
      width: 100%;
      max-width: 1170px;
      margin: 0 auto;
      padding: 20px 15px;
      flex: 1;
    }

    .form-container {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
      width: 100%;
      max-width: 600px;
      margin-bottom: 150px; 
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

    input[type="text"], input[type="date"], textarea, select {
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

    input[type="text"]:focus, textarea:focus, select:focus {
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

    button[type="submit"]:hover {
      background-color: #0056b3;
      transform: scale(1.02);
    }

    .footer_bottom {
      background-color: #222;
      color: #fff;
      padding: 30px 0;
      text-align: center;
    }

    .copy {
      margin-top: 20px;
    }

    .copy p {
      font-size: 14px;
      color: #888;
    }

    .copy a {
      color: #fff;
    }

    .copy a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .footer_bottom {
        padding: 20px;
      }

      .container {
        padding: 15px;
      }
    }

  </style>
</head>
<body>
  <div class="footer_bottom">
    <div class="copy">
      <p>Copyright © 2025 Seeking. All Rights Reserved. Design by: Sijan Giri</p>
    </div>
  </div>

</body>
</html>
