<link rel="stylesheet" href="/public/login.css"/>

<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg fullContainer">

    <div class="wrapper fadeInDown">
        <form action="/connexionApi" method="post" id="formContent">
            <!-- Icon -->
            <div class="fadeIn first">
                <img src="/public/img/user.png" class="icon" id="icon" alt="User Icon"/>
            </div>
            <?php if (!empty($errorApi)) { ?>
                <div class="alert alert-danger" role="alert"><?= $errorApi ?></div>
            <?php } ?>
            <!-- Login Form -->
            <form method="POST" action="/sample/">
                <input type="text" id="login" class="fadeIn second" name="login"
                       placeholder="Identifiant administrateur" value="<?php if (!empty($_POST["login"])) {
                    echo $_POST["login"];
                } ?>"/>
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Mot de passe"/>
                <input type="submit" class="fadeIn fourth" value="Log In" name="btnAdmin">
            </form>

        </form>
    </div>

</div>