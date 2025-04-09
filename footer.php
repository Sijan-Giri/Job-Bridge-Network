<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer</title>
  <style>
    /* Global reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  line-height: 1.6;
}

.container {
  width: 100%;
  max-width: 1170px;
  margin: 0 auto;
  padding: 0 15px;
}

.footer_bottom {
  background-color: #222;
  color: #fff;
  padding: 30px 0;
}

.f_list2 {
  list-style-type: none;
}

.f_list2 li {
  margin-bottom: 10px;
}

.f_list2 a {
  color: #fff;
  text-decoration: none;
  font-size: 16px;
}

.f_list2 a:hover {
  text-decoration: underline;
}

.footer_text {
  margin-top: 20px;
}

.footer_text p {
  font-size: 14px;
  line-height: 1.8;
}

.clearfix::after {
  content: "";
  display: table;
  clear: both;
}

.copy {
  text-align: center;
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

/* Responsive Design */
@media (max-width: 768px) {
  .col-sm-2, .col-sm-6 {
    width: 100%;
    text-align: center;
    margin-bottom: 20px;
  }
  
  .footer_text {
    margin-top: 10px;
  }
}

  </style>
</head>
<body>
  <div class="footer_bottom">
    <div class="container">
      <div class="clearfix"></div>
      <div class="copy">
        <p>Copyright © 2015 Seeking . All Rights Reserved . Design by :- Sijan Giri</p>
      </div>
    </div>
  </div>
</body>
</html>
