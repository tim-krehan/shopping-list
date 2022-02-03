<div class="container mt-5">
    <h1>Login</h1>
</div>

<form action="/php/login.php" method="post">
    <input type="hidden" name="refurl" value="<?php echo $_GET["refurl"]; ?>">
    <div class="form-group">
        <label for="name">Benutzer</label>
        <input type="text" class="form-control" name="user" id="name" aria-describedby="benutzerHelp" placeholder="Benutzername"
            required="required">
        <small id="benutzerHelp" class="form-text text-muted">Ihr persönlcher Benutzername für die ShoppingList!</small>
    </div>
    <div class="form-group">
        <label for="pass">Password</label>
        <input type="password" class="form-control" name="pass" id="pass" placeholder="**********" required="required">
    </div>
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="rememberme" name="rememberme">
        <label class="form-check-label" for="rememberme">Angemeldet bleiben</label>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>

<div class="alert alert-danger" role="alert" <?php
	if(isset($_COOKIE["token"]) && $_COOKIE["token"]=="false"){
		echo "style='display: block;'";
		setcookie("token", "", 1, "/", "");
	}
	else{echo "style='display: none;'";} 
?>>
  Entweder das Passwort, oder der Benutzername ist falsch!
</div>
<div class="alert alert-success" role="alert" <?php 
	if(isset($_COOKIE["token"]) && $_COOKIE["token"]=="logout"){
		echo "style='display: block;'";
		setcookie("token", "", 1, "/", "");
	}
	else{echo "style='display: none;'";} 
?>>
  Erfolgreich ausgeloggt!
</div>