<script src="/bin/settings.js" charset="utf-8"></script>
<div class="container mt-5">
    <h1>Einstellungen</h1>
</div>
<div class="container d-flex flex-column">

    <div class="card mb-3">
        <div class="card-body">

            <h5 class="card-title">Benutzer</h5>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="userPrepend">Benutzername</span>
                </div>
                <input type="text" class="user-input form-control" placeholder="<?php echo $user->username; ?>" aria-label="Username" aria-describedby="userPrepend">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="mailPrepend">Mail</span>
                </div>
                <input type="email" class="user-input form-control" placeholder="<?php echo $user->email; ?>" aria-label="email" aria-describedby="mailPrepend">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="loginPrepend">Letzter Login</span>
                </div>
                <input type="text" class="form-control" value="<?php echo $user->last_login; ?>" aria-label="login" aria-describedby="loginPrepend" readonly>
            </div>
            <button class="btn btn-primary disabled" id="userSaveButton" disabled>Speichern</button>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Passwort</h5>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="oldPasswdPretend">Altes Passwort</span>
                </div>
                <input id="old-password-input" type="password" class="password-input form-control" aria-describedby="oldPasswdPretend" placeholder="********">
                <div class="invalid-feedback">
                    Passwort ist falsch.
                </div>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="newPasswdPretend">Neues Passwort</span>
                </div>
                <input id="new-password-input" type="password" class="password-input form-control" aria-describedby="newPasswdPretend" placeholder="********">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="newWdhPasswdPretend">Neues Passwort</span>
                </div>
                <input id="check-password-input" type="password" class="password-input form-control" aria-describedby="newWdhPasswdPretend" placeholder="********">
            </div>
            <button class="btn btn-primary disabled" id="passwordSaveButton" disabled>Speichern</button>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Thema</h5>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="changeThemePrepend">Thema</label>
                </div>
                <select class="custom-select" id="changeThemePrepend">
                    <option value="default">Standard</option>
                <?php
                    foreach(glob($_SESSION['docroot'].'/style/themes/*.css') as $themepath){
                        $pathinfo = pathinfo($themepath);
                        if($pathinfo["filename"]==$user->theme){$selected="selected";}
                        else{$selected = "";}
                        print_r("<option value='".$pathinfo["filename"]."' $selected>".$pathinfo["filename"]."</option>");
                    }
                ?>
                </select>
            </div>

            <button class="btn btn-primary disabled" id="themeSaveButton" disabled>Speichern</button>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Datenbank</h5>
            <h6 class="card-subtitle text-muted mb-3">Export</h6>
            <p class="card-text">Hiermit werden alle Rezepte und sich zurzeit auf der Shoppingliste befindlichen Einträge als Download zur
                Verfügung gestellt. Diese Datei kann dann an anderer Stelle wieder Importiert werden, oder als Backup
                abgespeichert werden.</p>
            <button id="export-recipe-button" class="btn btn-primary">Export Rezepte</button>
            <button id="export-list-button" class="btn btn-primary">Export Shoppingliste</button>
            <h6 class="card-subtitle text-muted mt-3 mb-3">Import</h6>
            <p>Der Import kann benutzt werden, um alle Daten von einer exportierten Datei in diese Datenbank
                einzupflegen. Hierbei werden nur die Einträge in der Shoppingliste, sowie die Rezepte beachtet. Die
                Benutzer bleiben unberührt!</p>
            <button id="import-button" class="btn btn-primary">Import ...</button>
        </div>
    </div>
</div>



<div class="toast fixed-bottom m-2" role="alert" id="toast-pw-success" aria-live="assertive" aria-atomic="true" data-delay="4000" data-animation="true">
    <div class="toast-header">
        <i class="close_toast fas fa-check-square w-auto mr-2"></i>
        <strong class="mr-auto">ShoppingList</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        Passwort erfolgreich geändert!
    </div>
</div>

<div class="toast fixed-bottom m-2" role="alert" id="toast-list-import-success" aria-live="assertive" aria-atomic="true" data-delay="4000" data-animation="true">
    <div class="toast-header">
        <i class="close_toast fas fa-check-square w-auto mr-2"></i>
        <strong class="mr-auto">ShoppingList</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        Liste erfolgreich importiert!
    </div>
</div>

<div class="toast fixed-bottom m-2" role="alert" id="toast-recipe-import-success" aria-live="assertive" aria-atomic="true" data-delay="4000" data-animation="true">
    <div class="toast-header">
        <i class="close_toast fas fa-check-square w-auto mr-2"></i>
        <strong class="mr-auto">ShoppingList</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        Rezepte erfolgreich importiert!
    </div>
</div>

<div class="toast fixed-bottom m-2" role="alert" id="toast-recipe-import-warning" aria-live="assertive" aria-atomic="true" data-autohide="false" data-animation="true">
    <div class="toast-header">
        <i class="close_toast fas fa-check-square w-auto mr-2"></i>
        <strong class="mr-auto">ShoppingList</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        Nicht alle Rezepte konnten importiert werden! Fehlerhafte Rezepte wieder exportiert.
    </div>
</div>
