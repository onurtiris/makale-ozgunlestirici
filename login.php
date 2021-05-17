<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <meta name="description" content="Makale özgünleştirme Aracı">
    <meta name="author" content="Onur Tiriş">
    <title>Makale Özgünleştirme Aracı</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/spinner.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <main class="form-spinner">
      <form action="" method="POST">
          <h1 class="h2 fw-normal fw-bold mb-2">Makale Özgünleştir</h1>
          <h1 class="h3 mb-3 fw-normal">Admin Paneli</h1>
          <div class="form-floating">
            <img src="captcha.php" class="w-25" />
            <input type="text" class="w-25 form-spinner" required name="security" placeholder="Güvenlik">
          </div>
          <div class="form-floating">
            <input type="password" class="w-50 form-spinner mt-3" required name="password" placeholder="Parola">
          </div>
          <button class="w-50 mb-1 mt-3 submit-spinner" type="submit" name="submit">GİRİŞ</button>
      </form>
    </main>
  </body>
</html>

<?php
include("settings.php");
session_start();
ob_start();

if ($_POST) {
  if (isset($_POST['security'])) {
    if ($_POST['security'] == $_SESSION['code']) {
      if(($_POST["password"]==$admin_password)){
        $_SESSION["login"] = "true";
        $_SESSION["pass"] = $admin_password;
        header("Location:admin.php");
      }
      else {
        echo '<script>alert("Parola yanlış.")</script>';
      }
    }
    else {
      echo '<script>alert("Güvenlik kodu yanlış ya da eksik girildi.")</script>';
    }
  }
}

ob_end_flush();
?>