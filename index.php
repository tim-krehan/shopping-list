<?php
session_start();
if (in_array("site", array_keys($_GET))) {
  $site = $_GET["site"];
} else {
  $site = "-1";
}

if (!(isset($_SESSION["docroot"]))) {
  $_SESSION["docroot"] = __DIR__;
}
include $_SESSION["docroot"] . '/config/config.php';
if (($CONFIG["installed"] == false) && ($site != "error")) {
  header("Location: /install/install.php");
  exit;
}
if ($site != "error") {
  include $_SESSION["docroot"] . '/php/auth.php';
}

include $_SESSION["docroot"] . '/version.php';

include $_SESSION["docroot"] . '/php/classes.user.php';
$user = new user();
$user->get_info($_COOKIE["token"]);
?>
<html lang="de" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="theme-color" content="#4CAF50" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" href="/pic/fav.ico">
  <link rel="shortcut icon" type="image/png" href="/pic/fav.ico" />
  <link rel="stylesheet" href="/style/fontawesome/css/all.css">
  <?php
  if (file_exists($_SESSION["docroot"] . '/style/themes/' . $user->theme . ".css")) {
    print_r('<link rel="stylesheet" href="/style/themes/' . $user->theme . '.css">');
  } else {
    print_r('<link rel="stylesheet" href="/style/main.css">');
  }
  ?>
  <link rel="stylesheet" href="/style/helper.css">
  <script src="/bin/jquery.js"></script>
  <script src="/bin/main.js"></script>
  <title>Einkaufsliste</title>
</head>

<body>
  <?php
  if ($site && ($site != "login")) {
    include $_SESSION["docroot"] . '/cont/nav.php';
  }
  echo '<div id="content" class="container">';
  switch ($site) {
    case "login":
      include $_SESSION["docroot"] . '/cont/login.php';
      break;

    case "list":
      include $_SESSION["docroot"] . '/cont/list.php';
      break;

    case "settings":
      include $_SESSION["docroot"] . '/cont/settings.php';
      break;

    case "recipes":
      include $_SESSION["docroot"] . '/cont/recipes.php';
      break;

    case "recipe":
      include $_SESSION["docroot"] . '/cont/recipe.php';
      break;

    case "new-recipe":
      include $_SESSION["docroot"] . '/cont/manageRecipe.php';
      break;

    case "edit-recipe":
      include $_SESSION["docroot"] . '/cont/manageRecipe.php';
      break;

    case "new-user":
      include $_SESSION["docroot"] . '/cont/adduser.php';
      break;

    case "error":
      include $_SESSION["docroot"] . '/cont/error.php';
      break;

    default:
      include $_SESSION["docroot"] . '/cont/list.php';
      $site = "list";
      break;
  }
  echo "</div>";
  ?>
  <script src="bin/bootstrap.bundle.min.js"></script>
</body>

</html>
