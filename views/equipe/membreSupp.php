<link href="/public/me.css" rel="stylesheet"/>
<div class="block-membres-supp" id="block">
    <a href="/me" class="membres-supp-cacher"><p>Cacher les membres supprimés</p></a>
    <?php
    foreach ($membresSupp as $m) {
        $date = new DateTime($m["date_supp_equipe"]);
        date("F Y", strtotime($m["date_supp_equipe"]));
        ?>
        <div class="block-each-supp">
            <div class="dateSupp">Le <span><?= $m["date_supp_equipe"] ?></span></div>
            <p><?= "{$m["nom"]} {$m["prenom"]}" ?></p>
            <p class="recup-membre">Récupérer ce membre ?</p>
            <div class="block-each-icon">
                <a href="/backToEquipe/<?= $m["idmembre"]; ?>"><i
                            class="bi bi-check-square-fill icon-check-supp"></i></a>
                <a href="/deleteFromEquipe/<?= $m["idmembre"]; ?>"><i
                            class="bi bi-x-square-fill icon-x icon-delete-supp"></i></a>
            </div>
        </div>
        <div id="msgErrorBackMembre"></div>
    <?php } ?>

</div>
<?php
if (!empty($error)) {
    echo "<div class='msgError'>" . $error . "</div>";
}
?>

