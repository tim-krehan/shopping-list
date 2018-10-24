<link rel="stylesheet" href="/style/login.css">
<h1>Login</h1>
  <form id="login" action="/php/login.php" method="post">
    <input type="hidden" name="refurl" value="<?php echo $_GET["refurl"]; ?>" >
    <input class="loginform" type="text" name="user" id="name" value="" placeholder="Benutzer" required="required">
    <input class="loginform" type="password" name="pass" id="pass" value="" placeholder="Passwort" required="required">
    <input class="loginform button" type="submit" id="loginButton" value="Login">
    <label class="loginform" id="rememberme"><input type="checkbox" name="rememberme">remember me</label>
    <font id="wrongpw" <?php 
    	if($_COOKIE["token"]=="false")
		{
			echo "style='display: block;'";
  			setcookie("token", "", 1, "/", "");
		}
    	else
		{
			echo "style='display: none;'";
		} 
    	?>
    	> Falsches Passwort!</font>
    <font id="logout" <?php 
    	if($_COOKIE["token"]=="logout")
    		{
    			echo "style='display: block;'";
      			setcookie("token", "", 1, "/", "");
    		}
    		else
			{
				echo "style='display: none;'";
			} 
    			?>
    			> Erfolgreich ausgeloggt!</font>
  </form>
