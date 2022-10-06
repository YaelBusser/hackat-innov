<link href="/public/me.css" rel="stylesheet"/>
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
                    <li class="member">🧑‍💻 <?= "{$m['nom']} {$m['prenom']}" ?>
                        <span class="btn-modal modal-trigger-edit"><i class="bi bi-pen-fill icon-edit"></i></span>
                        <span class="btn-modal modal-trigger-delete"><i class="bi bi-trash-fill icon-delete"></i></span>
                    </li>
                <?php } ?>
            </ul>
            <div class="modal-Edit">
                <div class="close-modal modal-trigger-edit">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <h1>Modifications du profil <?= $lemembre["nom"] . " " . $lemembre["prenom"]; ?></h1>
            </div>
            <div class="modal-Delete">
                <div class="close-modal modal-trigger-delete">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <h1>Suppression</h1>
                <p>COCUCI8HCIHCSFCD</p>
            </div>
            <form method="post" class="row g-1" action="/membre/add">
                <div class="col">
                    <input required type="text" placeholder="Nom" name="nom" class="form-control"/>
                </div>
                <div class="col">
                    <input required type="text" placeholder="Prénom" name="prenom" class="form-control"/>
                </div>
                <div class="col">
                    <input type="submit" value="Ajouter" class="btn btn-success d-block"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const modalEdit = document.querySelector(".modal-Edit");
    const modalTriggersEdit = document.querySelectorAll(".modal-trigger-edit");
    modalTriggersEdit.forEach(triggerEdit => triggerEdit.addEventListener("click", toggleModalEdit));

    const modalDelete = document.querySelector(".modal-Delete");
    const modalTriggersDelete = document.querySelectorAll(".modal-trigger-delete");
    modalTriggersDelete.forEach(triggerDelete => triggerDelete.addEventListener("click", toggleModalDelete));

    function toggleModalEdit() {
        modalEdit.classList.toggle("active");
    }

    function toggleModalDelete() {
        modalDelete.classList.toggle("active");
    }
</script>
