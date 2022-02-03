$(document).ready(function () {
    $(".user-input").on("input", checkUserStrings);
    $("#userSaveButton").click(userChange);
    $(".password-input").on("input", checkPasswordStrings);
    $("#passwordSaveButton").click(savePassword);
    $("#export-recipe-button").click(exportRecipe);
    $("#export-list-button").click(exportList);
    $("#changeThemePrepend").change(themeChange)
    $("#themeSaveButton").click(changeTheme);

    $("#import-button").click(function () {
        $('<input type="file" accept=".json">').on('change', function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function () {
                var content = JSON.parse(reader.result);
                if (content.sites != null) {
                    $.post("/api/recipes/import",
                        {
                            content: reader.result
                        },
                        function (data) {
                            if (data == 0) {
                                $("#toast-recipe-import-success").toast("show");
                            }
                            else {
                                $("#toast-recipe-import-warning").toast("show");
                                downloadObjectAsJson(JSON.parse(data), "failed_recipe_import");
                            }
                        }
                    );
                }
                else if (content.list != null) {
                    $.post("/api/list/import",
                        {
                            content: reader.result
                        },
                        function (data) {
                            if (data == 0) {
                                $("#toast-list-import-success").toast("show");
                            }
                        }
                    );
                }
            };
            reader.readAsText(file);
        }).click();
    });
});

function userChange() {
    var mail = $('.user-input.is-valid[aria-label="email"]').val();
    var userName = $('.user-input.is-valid[aria-label="Username"]').val();
    if(mail != null){
        $.post(
            "/api/user/change-mail",
            {
                mail: mail
            },
            function(){
                window.location.href = window.location.href;
            }
        )
    }
    
    if (userName != null) {
        $.post(
            "/api/user/change-username",
            {
                username: userName
            },
            function () {
                window.location.href = window.location.href;
            }
        )
    }
}

function themeChange() {
    $("#themeSaveButton").removeClass("disabled");
    $("#themeSaveButton").attr("disabled", false);
}

function changeTheme() {
    $.post(
        "/api/user/change-theme",
        {
            theme: $('#changeThemePrepend option:selected').val()
        },
        function () {
            window.location.href = window.location.href;
        }
    );
}

function exportList() {
    $.post("/api/list/export", {}, function (data) {
        downloadObjectAsJson(JSON.parse(data), "list");
    });
}

function exportRecipe() {
    $.post("/api/recipes/export", {}, function (data) {
        downloadObjectAsJson(JSON.parse(data), "recipes");
    });
}

function savePassword() {
    $.post("/api/user/change-pw", {
        current: $("#old-password-input").val(),
        new: $("#new-password-input").val()
    }, function (data) {
        if (data == 0) {
            $("#old-password-input").val("");
            $("#new-password-input").val("");
            $("#check-password-input").val("");
            $("#new-password-input").removeClass("is-valid");
            $("#check-password-input").removeClass("is-valid");
            $("#toast-pw-success").toast("show");
        }
        else {
            $("#old-password-input").addClass("is-invalid");
        }
    });
}

function checkPasswordStrings() {
    if ((($("#old-password-input").val()).length > 0) &&
        (($("#new-password-input").val()).length > 0) &&
        (($("#check-password-input").val()).length > 0) &&
        ($("#new-password-input").val() == $("#check-password-input").val())) {

        $("#new-password-input").addClass("is-valid");
        $("#check-password-input").addClass("is-valid");
        $("#passwordSaveButton").prop("disabled", false);
        $("#passwordSaveButton").removeClass("disabled");
    }
    else {
        $("#passwordSaveButton").prop("disabled", true);
        $("#passwordSaveButton").addClass("disabled");
        $("#new-password-input").removeClass("is-valid");
        $("#check-password-input").removeClass("is-valid");
    }
}

function checkUserStrings() {
    switch ($(this).attr("aria-label")) {
        case "Username":
            if ($(this).val().length >= 3) {
                $("#userSaveButton").attr("disabled", false);
                $("#userSaveButton").removeClass("disabled");
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
            }
            else {
                $("#userSaveButton").attr("disabled", true);
                $("#userSaveButton").addClass("disabled");
                $(this).addClass("is-invalid");
                $(this).removeClass("is-valid");
            }
            break;
        case "email":
            mailRegEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (($(this).val().length > 5) && (mailRegEx.exec($(this).val()) !== null)) {
                $("#userSaveButton").attr("disabled", false);
                $("#userSaveButton").removeClass("disabled");
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
            }
            else {
                $("#userSaveButton").attr("disabled", true);
                $("#userSaveButton").addClass("disabled");
                $(this).addClass("is-invalid");
                $(this).removeClass("is-valid");
            }
            break;
        default:
            break;
    }
}

function downloadObjectAsJson(exportObj, exportName) {
    var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(exportObj));
    var downloadAnchorNode = document.createElement('a');
    downloadAnchorNode.setAttribute("href", dataStr);
    downloadAnchorNode.setAttribute("download", exportName + ".json");
    document.body.appendChild(downloadAnchorNode); // required for firefox
    downloadAnchorNode.click();
    downloadAnchorNode.remove();
}
