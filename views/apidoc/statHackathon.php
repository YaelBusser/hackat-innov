<link href="/public/api.css" rel="stylesheet"/>
<div class="stat-hackathon">
    <h2 class="titreHackathon">
        <?= $hackathon["thematique"]; ?>
    </h2>
    <p class="txt-stats">Statistiques :</p>
    <p>Le <b>nombre d'équipes</b> qui se sont <b>inscrites</b> à cet évènement en fonction de la <b>date
            d'inscription</b>.</p>
    <p><b>Date et heure de fin d'inscriptions</b> : <?= $hackathon["dateFinInscription"]; ?></p>
    <div>
        <canvas id="myChart"></canvas>
    </div>
</div>
<script>
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php
                foreach ($inscrire as $i){
                ?>
                "<?= $i["dateinscription"]; ?>",
                <?php } ?>
            ],
            datasets: [{
                label: "Nombre d'équipes",
                data: [
                    <?php
                    foreach ($inscrire as $i){
                    ?>
                    "<?= $i["nbequipe"]; ?>",
                    <?php } ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>