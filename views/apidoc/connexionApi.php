<link rel="stylesheet" href="/public/login.css" />

<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg fullContainer">

    <div class="wrapper fadeInDown">
        <form action="/connexionApi" method="post" id="formContent">
            <!-- Icon -->
            <div class="fadeIn first">
                <img src="/public/img/user.png" class="icon" id="icon" alt="User Icon"/>
            </div>

            <?php if (!empty($erreur)){ ?>
                <div class="alert alert-danger" role="alert"><?= $erreur ?></div>
            <?php } ?>

            <!-- Login Form -->
            <form>
                <input type="text" id="login" class="fadeIn second" name="login" placeholder="Identifiant administrateur"/>
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Mot de passe"/>
                <input type="submit" class="fadeIn fourth" value="Log In">
            </form>

        </form>
    </div>

</div>