<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg fullContainer">
    <div class="card cardRadius">
        <div class="card-body">
            <h3>Créer une nouvelle équipe</h3>
            <p>Vous souhaitez nous rejoindre ?</p>

            <?php if (!empty($erreur)){ ?>
                <div class="alert alert-danger" role="alert"><?= $erreur ?></div>
            <?php } ?>

            <form action="/create-team?idh=<?= $idh ?>" method="post">
                <p>Information de votre équipe</p>
                <input required type="text" class="form-control my-3" placeholder="Nom de votre équipe" name="nom"/>
                <input required type="text" class="form-control my-3" placeholder="Lien de votre site" name="lien"/>

                <hr/>
                <p>Vos informations de connexion</p>
                <input required type="text" class="form-control my-3" placeholder="Login" name="login"/>
                <input required type="password" class="form-control my-3" placeholder="Mot de passe" name="password"/>

                <hr/>
                <input type="submit" value="Créer mon équipe" class="btn btn-success">

            </form>
        </div>
    </div>
</div>