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
if (($CONFIG["first_launch"] == true) && ($site != "error")) {
  header("Location: /install/install_adduser.php");
  exit;
}
if ($site != "error") {
  include $_SESSION["docroot"] . '/php/auth.php';
}

include $_SESSION["docroot"] . '/version.php';
include $_SESSION["docroot"] . '/php/classes.user.php';

$token = isset($_COOKIE["token"]) ? $_COOKIE["token"] : "";
$user = new user();
$user->get_info($token);
?>
<html lang="de" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" href="/pic/fav.ico">
  <link rel="shortcut icon" type="image/png" href="/pic/fav.ico" />
  <link rel="stylesheet" href="/style/fontawesome/css/all.css">
  <?php
  if (file_exists($_SESSION["docroot"] . '/style/themes/' . $user->theme . ".css")) {
    $cssFileContents = file_get_contents($_SESSION["docroot"]."/style/themes/".$user->theme.".css");
    preg_match_all('/\s+--primary:\s#(.{3,6})/m', $cssFileContents, $matches, PREG_SET_ORDER, 0);
    $themecolor = $matches[0][1];
    print_r('<link rel="stylesheet" href="/style/themes/' . $user->theme . '.css">');
    print_r('<meta name="theme-color" content="#'.$themecolor.'">');
  } else {
    print_r('<link rel="stylesheet" href="/style/main.css">');
    print_r('<meta name="theme-color" content="#007bff">');
  }
  ?>
  <link rel="stylesheet" href="/style/helper.css">
  <script src="/js/jquery.js"></script>
  <script src="/js/main.js"></script>
  <title>ShoppingList</title>
</head>

<body>
  <?php
  if ($site && ($site != "login")) {
    include $_SESSION["docroot"] . '/cont/nav.php';
  }
  echo '<div id="content" class="container pt-4">';
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
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
