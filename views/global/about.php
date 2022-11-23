<link href="/public/about.css" rel="stylesheet"/>
<h1>A propos</h1>
<div class="block-body">
    <div class="block-presentation">
        <div class="context">
            <h2>Contexte</h2>
            <p>Contraction de "hack" et de marathon, l'hackathon est un processus créatif utilisé dans le domaine de
                l'innovation
                numérique. Durant généralement un week-end, des développeurs volontaires se réunissent pour faire de la
                programmation informatique collaborative en fonction d'un thème précis
            </p>
        </div>
        <div class="histoire">
            <h2>Histoire</h2>
            <div class="block-histoire">
                <p>Devant l’engouement des hackathons en France répondant à une volonté de développer toujours davantage
                    le
                    numérique
                    au service de la société, il y a 2 ans, a été créée une start-up Hackat’Innov qui a pour but de
                    simplifier
                    la
                    gestion de l'organisation d'Hackathons. Notre start-up a reçu un prix de l'innovation numérique.</p>
                <img src="/public/img/logo.png">
            </div>
        </div>
    </div>
    <div class="block-hackathons">
        <h2>Les hackathons</h2>
        <div class="lesHackathon">
            <?php
            $compteur = 0;
            foreach ($hackathons as $hackathon) {
                $compteur++;
                ?>
                <p class="btn" data-id="<?= $compteur; ?>"><?= $hackathon["thematique"]; ?></p>
                <div class="unHackathon box" id="box-<?= $compteur; ?>">
                    <p class="titreHackathon"><?= $hackathon["thematique"]; ?></p>
                    <div>Informations :</div>
                    <div><em>Date :</em> <?= date_create($hackathon['dateheuredebuth'])->format("d/m/Y H:i") ?>
                        au <?= date_create($hackathon['dateheurefinh'])->format("d/m/Y H:i") ?></div>
                    <div><em>Lieu :</em> <?= $hackathon['ville'] ?></div>
                    <?php
                    foreach ($organisateur as $orga) {
                        if ($orga["idhackathon"] == $hackathon["idhackathon"]) {

                            ?>
                            <div><em>Organisateur :</em> <?= "{$orga['nom']} {$orga['prenom']}" ?></div>
                        <?php }
                    } ?>
                    <?php
                    foreach ($nbEquipe as $nb) {
                        if ($nb["idhackathon"] == $hackathon["idhackathon"]) {
                            ?>
                            <div><em>Nombre de places
                                    :</em> <?= "<b>{$nb['nbequipe']}</b>/<b>{$hackathon['nbEquipMax']}</b>" ?></div>
                        <?php }
                    } ?>
                </div>

            <?php } ?>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // clic sur les boutons
        $('.btn').on('click', function (event) {
            event.stopPropagation(); // important
            var id = $(this).data('id');  // on récupère le data-id
            $(".box:not(#box-" + id + ")").hide(1000); // on ferme les box, sauf celle concernée
            $("#box-" + id).slideToggle(); // on ouvre ou ferme celle concernée
        });
        // clic en dehors des div
        $(window).on('click', function () {
            $(".box").slideUp(); // on ferme
        });

    });
</script>