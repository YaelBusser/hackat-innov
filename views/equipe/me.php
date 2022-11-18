<link href="/public/me.css" rel="stylesheet"/>
<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg fullContainer">
    <div class="card cardRadius">
        <div class="card-body">
            <h3>Bienvenue « <?= $connected['nomequipe'] ?> »
                <span class="btn-modal modal-trigger-edit-equipe ">
                    <i class="bi bi-gear icon-edit"></i>
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
            <?php
            if ($hackathon != null) {
                ?>
                <span class="btn btn-danger btn-small modal-trigger-leave-hackathon">Quitter l'évènement</span>
                <div id="modal-Leave-Hackathon" class="modal-Leave-Hackathon">
                    <div class="close-modal modal-trigger-leave-hackathon">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div class="modal-Leave-Hackathon-body">
                        <p>Voulez-vous vraiment quitter l'hackathon ?</p>
                        <a href="/leaveHackathon" class="btn btn-danger btn-small">Quitter l'évènement</a>
                    </div>
                </div>
            <?php } ?>
            <a href="/logout" class="btn btn-danger btn-small">Déconnexion</a>
        </div>
        <div id="modal-Edit-Equipe" class="modal-Edit-Equipe">
            <div class="close-modal modal-trigger-edit-equipe">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <h1>Modifications</h1>
            <form method="POST" id="formEditProfile">
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
                               type="number" min="1" max="<?= $hackathon["nbEquipMax"]; ?>"
                               value="<?= $_SESSION["LOGIN"]["nbparticipants"]; ?>">
                    </div>
                    <?php

                    ?>
                    <div>
                        <p><label for="mdpActuel">Mot de passe actuel</label></p>
                        <input class="form-control inputEditEquipe" name="mdpActuel" id="mdpActuel" type="password"
                               value="">
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
                    <input type="button" onclick="editEquipe()" value="Modifier" name="btnModifierEquipe"
                           class="btn btn-success d-block form-control btnModiferEquipe" id="btnEditEquipe"/>
                    <div id="msgErrorEditProfile"></div>
                </div>
            </form>
        </div>
    </div>
    <div style="display: flex; gap: 10px;">
        <div class="card cardRadius mt-3">
            <div class="card-body">
                <h3 style="margin-bottom: 50px;">Membres de votre équipe</h3>
                <ul>
                    <?php foreach ($membres as $m) { ?>
                        <li class="member">
                            <img class="avatar-user" src="<?= $m['avatar']; ?>">
                            <?= "{$m['nom']} {$m['prenom']}" ?>
                            <span class="block-btn-modal">
                                <span class="btn-modal modal-trigger-edit"
                                      onclick="getMembreEdit(<?= $m['idmembre']; ?>)">
                                    <i class="bi bi-gear icon-edit"></i>
                                </span>
                                <span class="btn-modal modal-trigger-delete"
                                      onclick="getMembreDelete(<?= $m["idmembre"]; ?>)">
                                    <i class="bi bi-trash icon-delete"></i>
                                </span>
                            </span>
                        </li>
                        <div class="modal-Edit" id="modal-Edit">
                            <div class="close-modal modal-trigger-edit">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>
                            <div id="info-edit"></div>
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
            </div>
        </div>
        <div class="card cardRadius mt-3">
            <div class="card-body">
                <h3 style="margin-bottom: 50px">Ajouter un membre</h3>
                <div class="formAjouter">
                    <form method="post" class="row g-1"
                          style="width: 100%; display: flex; justify-content: center; gap: 10px" id="addMembre">
                        <input required type="text" placeholder="Nom" name="nom" class="form-control"/>
                        <input required type="text" placeholder="Prénom" name="prenom" class="form-control"/>
                        <input required type="email" placeholder="Email" name="email" class="form-control"/>
                        <input required type="number" placeholder="Téléphone" name="tel" class="form-control"/>
                        <input required type="date" name="dateNaissance" class="form-control"/>
                        <input type="text" placeholder="Portfolio" name="portfolio" class="form-control">
                        <input type="button" onclick="addMembre()" value="Ajouter" name="btnAjouter"
                               class="btn btn-success d-block form-control"/>
                        <div id="msgErrorAddMembre"></div>
                    </form>
                </div>
                <p class="membres-supp" onclick="getMembreSupp()">Afficher les membres supprimés</p>
                <div id="info-membres-sup"></div>
            </div>
        </div>
    </div>
</div>
<script>
    // Modification de l'équipe par ajax
    function editEquipe() {
        const data = new URLSearchParams();
        for (const pair of new FormData(document.getElementById("formEditProfile"))) {
            data.append(pair[0], pair[1]);
        }
        fetch("/editEquipe", {
            method: 'post',
            body: data,
        })
            .then((response) => response.text())
            .then((datas) => {
                if (datas) {
                    document.getElementById("msgErrorEditProfile").innerHTML = datas;
                } else {
                    location.reload();
                }
            });
    }

    function editMembre(idmembre) {
        const data = new URLSearchParams();
        for (const pair of new FormData(document.getElementById("formEditMembre"))) {
            data.append(pair[0], pair[1]);
        }
        fetch("/editMembre/" + idmembre, {
            method: 'post',
            body: data,
        })
            .then((response) => response.text())
            .then((datas) => {
                if (datas) {
                    document.getElementById("msgErrorEditMembre").innerHTML = datas;
                } else {
                    location.reload();
                }
            });
    }


    function addMembre() {
        const data = new URLSearchParams();
        for (const pair of new FormData(document.getElementById("addMembre"))) {
            data.append(pair[0], pair[1]);
        }
        fetch("/addMembre", {
            method: 'post',
            body: data,
        })
            .then((response) => response.text())
            .then((datas) => {
                if (datas) {
                    document.getElementById("msgErrorAddMembre").innerHTML = datas;
                } else {
                    location.reload();
                }
            });
    }

    const modalEditEquipe = document.querySelector(".modal-Edit-Equipe");
    const modalTriggersEditEquipe = document.querySelectorAll(".modal-trigger-edit-equipe");
    modalTriggersEditEquipe.forEach(triggerEditEquipe => triggerEditEquipe.addEventListener("click", toggleModalEditEquipe));

    const modalEdit = document.querySelector(".modal-Edit");
    const modalTriggersEdit = document.querySelectorAll(".modal-trigger-edit");
    modalTriggersEdit.forEach(triggerEdit => triggerEdit.addEventListener("click", toggleModalEdit));

    const modalDelete = document.querySelector(".modal-Delete");
    const modalTriggersDelete = document.querySelectorAll(".modal-trigger-delete");
    modalTriggersDelete.forEach(triggerDelete => triggerDelete.addEventListener("click", toggleModalDelete));

    const modalLeaveHackathon = document.querySelector(".modal-Leave-Hackathon");
    const modalTriggersLeaveHackathon = document.querySelectorAll(".modal-trigger-leave-hackathon");
    modalTriggersLeaveHackathon.forEach(triggerLeaveHackathon => triggerLeaveHackathon.addEventListener("click", toggleModalLeaveHackathon));

    function toggleModalEditEquipe() {
        modalEditEquipe.classList.toggle("active");
    }

    function toggleModalEdit() {
        modalEdit.classList.toggle("active");
    }

    function toggleModalDelete() {
        modalDelete.classList.toggle("active");
    }

    function toggleModalLeaveHackathon() {
        modalLeaveHackathon.classList.toggle("active");
    }

    function getMembreEdit(idmembre) {
        fetch("/membre/" + idmembre)
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
