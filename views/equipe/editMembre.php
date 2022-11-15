<div>
    <form method="POST">
        <div class="formEditEquipe">
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
                <p><label for="telMembre">Numéro de téléphone</label></p>
                <input class="form-control inputEditMembre" name="telMembre" id="telMembre"
                       type="tel" pattern="[0-9]{10}" maxlength="10" minlength="10"
                       value="<?= "{$membres["telephone"]}"; ?>">
            </div>
            <?php

            ?>
            <div>
                <p><label for="dateNaissMembre">Date de naissance</label></p>
                <input class="form-control inputEditMembre" name="dateNaissMembre" id="dateNaissMembre" type="date"
                       value="<?= "{$membres["datenaissance"]}"; ?>">
            </div>
            <input type="button" onclick="editEquipe()" value="Modifier" name="btnModifierEquipe"
                   class="btn btn-success d-block form-control btnModiferEquipe" id="btnEditEquipe"/>
            <div id="msgErrorEditProfile"></div>
        </div>
    </form>
</div>
