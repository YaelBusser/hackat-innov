<link href="/public/me.css" rel="stylesheet"/>
<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg fullContainer">
    <div class="card cardRadius">
        <div class="card-body">
            <h3>Bienvenue « <?= $connected['nomequipe'] ?> »
                <span class="btn-modal modal-trigger-edit-equipe">
                    <i class="bi bi-pen-fill icon-edit"></i>
                </span>
            </h3>
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
        <div id="modal-Edit-Equipe" class="modal-Edit-Equipe">
            <div class="close-modal modal-trigger-edit-equipe">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <h1>Modifications</h1>
            <form method="POST" action="/editEquipe">
                <div class="formEditEquipe">
                    <div>
                        <p><label for="nom">Nom</label></p>
                        <input class="form-control inputEditEquipe" name="nom" id="nom" type="text"
                               value="<?= $_SESSION["LOGIN"]["nomequipe"]; ?>">
                    </div>
                    <div>
                        <p><label for="login">Login</label></p>
                        <input class="form-control inputEditEquipe" name="login" id="login" type="text"
                               value="<?= $_SESSION["LOGIN"]["login"]; ?>">
                    </div>
                    <div>
                        <p><label for="proto">Lien du prototype</label></p>
                        <input class="form-control inputEditEquipe" name="proto" id="proto" type="text"
                               value="<?= $_SESSION["LOGIN"]["lienprototype"]; ?>">
                    </div>
                    <div>
                        <p><label for="participants">Nombre de participants</label></p>
                        <input class="form-control inputEditEquipe" name="participants" id="participants"
                               type="number"
                               value="<?= $_SESSION["LOGIN"]["nbparticipants"]; ?>">
                    </div>
                    <div>
                        <p><label for="mdp">Mot de passe</label></p>
                        <input class="form-control inputEditEquipe" name="mdp" id="mdp" type="password"
                               value="">
                    </div>
                    <div>
                        <p><label for="mdp2">Confirmation du mot de passe</label></p>
                        <input class="form-control inputEditEquipe" name="mdp2" id="mdp2" type="password"
                               value="">
                    </div>
                    <input type="submit" value="Modifier" name="btnModifierEquipe"
                           class="btn btn-success d-block form-control btnModiferEquipe" id="btnEditEquipe"/>
                    <?php
                    if (isset($errorEditEquipe)) {
                        echo $errorEditEquipe;
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
    <div class="card cardRadius mt-3">
        <div class="card-body">
            <h3>Membres de votre équipe</h3>
            <ul>
                <?php foreach ($membres as $m) { ?>
                    <li class="member">🧑‍💻 <?= "{$m['nom']} {$m['prenom']}" ?>
                        <span class="btn-modal modal-trigger-edit"
                              onclick="getMembreEdit(<?= $m['idmembre']; ?>)">
                            <i class="bi bi-pen-fill icon-edit"></i>
                        </span>
                        <span class="btn-modal modal-trigger-delete"
                              onclick="getMembreDelete(<?= $m["idmembre"]; ?>)">
                            <i class="bi bi-trash-fill icon-delete"></i>
                        </span>
                    </li>
                    <div class="modal-Edit" id="modal-Edit">
                        <div class="close-modal modal-trigger-edit">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <h1>Modifications</h1>
                        <p id="info-edit"></p>
                    </div>
                    <div class="modal-Delete">
                        <div class="close-modal modal-trigger-delete">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <h1>Suppression</h1>
                        <p id="info-delete"></p>
                    </div>
                <?php } ?>
            </ul>
            <div class="formAjouter">
                <form method="post" class="row g-1" action="/membre/add"
                      style="width: 100%; display: flex; justify-content: center; gap: 10px">
                    <input required type="text" placeholder="Nom" name="nom" class="form-control"/>
                    <input required type="text" placeholder="Prénom" name="prenom" class="form-control"/>
                    <input required type="email" placeholder="Email" name="email" class="form-control"/>
                    <input required type="number" placeholder="Téléphone" name="tel" class="form-control"/>
                    <input required type="date" name="dateNaissance" class="form-control"/>
                    <input type="text" placeholder="Portfolio" name="portfolio" class="form-control">
                    <input type="submit" value="Ajouter" name="btnAjouter"
                           class="btn btn-success d-block form-control"/>
                    <?php if (isset($error)) {
                        echo $error;
                    } ?>
                </form>
            </div>
        </div>
        <p class="membres-supp" onclick="getMembreSupp()">Afficher les membres supprimés</p>
        <div id="info-membres-sup"></div>
    </div>
</div>
<script>
    const modalEditEquipe = document.querySelector(".modal-Edit-Equipe");
    const modalTriggersEditEquipe = document.querySelectorAll(".modal-trigger-edit-equipe");
    modalTriggersEditEquipe.forEach(triggerEditEquipe => triggerEditEquipe.addEventListener("click", toggleModalEditEquipe));

    const modalEdit = document.querySelector(".modal-Edit");
    const modalTriggersEdit = document.querySelectorAll(".modal-trigger-edit");
    modalTriggersEdit.forEach(triggerEdit => triggerEdit.addEventListener("click", toggleModalEdit));

    const modalDelete = document.querySelector(".modal-Delete");
    const modalTriggersDelete = document.querySelectorAll(".modal-trigger-delete");
    modalTriggersDelete.forEach(triggerDelete => triggerDelete.addEventListener("click", toggleModalDelete));

    function toggleModalEditEquipe() {
        modalEditEquipe.classList.toggle("active");
    }

    function toggleModalEdit() {
        modalEdit.classList.toggle("active");
    }

    function toggleModalDelete() {
        modalDelete.classList.toggle("active");
    }

    function getMembreEdit(idmembre) {
        fetch("/editMembre/" + idmembre)
            .then((response) => response.text())
            .then((datas) => {
                document.getElementById("info-edit").innerHTML = datas;
            });
    }

    function getMembreDelete(idmembre) {
        fetch("/deleteMembre/" + idmembre)
            .then((response) => response.text())
            .then((datas) => {
                document.getElementById("info-delete").innerHTML = datas;
            });
    }

    function getMembreSupp() {
        fetch("/membreSupp/")
            .then((response) => response.text())
            .then((datas) => {
                document.getElementById("info-membres-sup").innerHTML = datas;
            });
    }
</script>
