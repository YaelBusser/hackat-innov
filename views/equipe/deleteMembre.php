<link href="/public/me.css" rel="stylesheet"/>
<div class="block-delete">
    <p class="presentationSupp">Voulez-vous vraiment supprimer
        <span><?= "{$membres["nom"]} {$membres["prenom"]}" ?></span> ?</p>
    <div class="block-delete-body">
        <div class="block-delete-icon">
            <a href="/deleteLeMembre/<?= $membres["idmembre"]; ?>"><i
                        class="bi bi-check-square-fill icon-check"></i></a>
            <a href="/me"><i class="bi bi-x-square-fill icon-x"></i></a>
        </div>
    </div>
</div>
