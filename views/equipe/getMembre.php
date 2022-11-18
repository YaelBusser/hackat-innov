<div>
    <form method="POST" id="formEditMembre" enctype="multipart/form-data">
        <div class="formEditEquipe">
            <h1>Modifications</h1>
            <div style="position: relative; display: flex; justify-content: center; align-items: center">
                <div class="block-btn-avatar">
                    <i class="bi bi-plus-circle-fill"></i>
                    <input type="file" name="avatar" class="input-avatar" id="avatar">
                </div>
                <img src="<?= $membres['avatar']; ?>">
            </div>
            <div>
                <p><label for="nomMembre">Nom</label></p>
                <input class="form-control inputEditMembre" name="nomMembre" id="nomMembre" type="text"
                       value="<?= "{$membres["nom"]}"; ?>">
            </div>
            <div>
                <p><label for="prenomMembre">Prénom</label></p>
                <input class="form-control inputEditMembre" name="prenomMembre" id="prenomMembre" type="text"
                       value="<?= "{$membres["prenom"]}"; ?>">
            </div>
            <div>
                <p><label for="emailMembre">Email</label></p>
                <input class="form-control inputEditMembre" name="emailMembre" id="emailMembre" type="text"
                       value="<?= "{$membres["email"]}"; ?>">
            </div>
            <div>
                <p><label for="portfolioMembre">Portfolio</label></p>
                <input class="form-control inputEditMembre" name="portfolioMembre" id="portfolioMembre" type="text"
                       value="<?= "{$membres["lienportfolio"]}"; ?>">
            </div>
            <div>
                <p><label for="telMembre">Téléphone</label></p>
                <input class="form-control inputEditMembre" name="telMembre" id="telMembre"
                       type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                       maxlength="10" minlength="10"
                       value="<?= "{$membres["telephone"]}"; ?>">
            </div>
            <div>
                <p><label for="dateNaissMembre">Date de naissance</label></p>
                <input class="form-control inputEditMembre" name="dateNaissMembre" id="dateNaissMembre" type="date"
                       value="<?= "{$membres["datenaissance"]}"; ?>">
            </div>
            <input type="button" onclick="editMembre(<?= $membres['idmembre']; ?>)" value="Modifier"
                   name="btnModifierMembre"
                   class="btn btn-success d-block form-control btnModiferEquipe" id="btnEditEquipe"/>
        </div>
        <div id="msgErrorEditMembre"></div>
    </form>
</div>
