<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg fullContainer">

    <div class="card cardRadius">
        <div class="card-body">

            <h3>Bienvenue « <?= $connected['nomequipe'] ?> »</h3>

            <p>
                <?php if ($hackathon != null) { ?>
                    Votre équipe participera à « <?= $hackathon["thematique"] ?> »
                <?php } else { ?>
                    Vous ne participez à aucun évènement.
                <?php } ?>
            </p>

        </div>

        <div class="card-actions">
            <a href="/logout" class="btn btn-danger btn-small">Déconnexion</a>
        </div>
    </div>

    <div class="card cardRadius mt-3">
        <div class="card-body">
            <h3>Membres de votre équipe</h3>

            <ul>
                <?php foreach ($membres as $m) { ?>
                    <li class="member">🧑‍💻 <?= "{$m['nom']} {$m['prenom']}" ?></li>
                <?php } ?>
            </ul>

            <form method="post" class="row g-1" action="/membre/add">
                <div class="col">
                    <input required type="text" placeholder="Nom" name="nom" class="form-control"/>
                </div>
                <div class="col">
                    <input required type="text" placeholder="Prénom" name="prenom" class="form-control"/>
                </div>
                <div class="col">
                    <input type="submit" value="Ajouter" class="btn btn-success d-block" />
                </div>
            </form>
        </div>
    </div>


</div>
