<link href="/public/stats.css" rel="stylesheet"/>
<h1>Statistiques</h1>
<div class="stat-site">
    <div>
        <h2>Nombre de pages visitées en fonction de la date :</h2>
        <canvas id="vues"></canvas>
    </div>
</div>
<div class="stat-site">
    <div>
        <h2>Age moyen des équipes par hackathon :</h2>
        <canvas id="age"></canvas>
    </div>
</div>
<script>
    const vues = document.getElementById('vues');
    new Chart(vues, {
        type: 'bar',
        data: {
            labels: [
                <?php
                foreach ($visites as $visite){
                ?>
                "<?= date_create($visite["date"])->format("d/m/Y"); ?>",
                <?php } ?>
            ],
            datasets: [{
                label: "Nombre de visites",
                data: [
                    <?php
                    foreach ($visites as $visite){
                    ?>
                    "<?= $visite["vues"]; ?>",
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
    const age = document.getElementById('age');
    new Chart(age, {
        type: 'bar',
        data: {
            labels: [
                <?php
                foreach ($avgAge as $age){
                ?>
                "<?= $age["thematique"]; ?>",
                <?php } ?>
            ],
            datasets: [{
                label: "Age moyen des équipes",
                data: [
                    <?php
                    foreach ($avgAge as $age){
                    ?>
                    "<?= $age["age"]; ?>",
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
