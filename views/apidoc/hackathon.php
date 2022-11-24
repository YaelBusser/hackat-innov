<link href="/public/api.css" rel="stylesheet"/>
<div class="d-flex flex-column justify-content-center align-items-center" style="margin-top: 100px">
    <div class="card col-xl-7  col-lg-9 col-md-10 col-12">
        <div class="card-body">
            <h5 class="card-title">Liste des Hackathons</h5>
            <table class="table card-text">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Thématique</th>
                    <th scope="col">Lieu</th>
                    <th scope="col">Début</th>
                    <th scope="col">Fin</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $hackaton) { ?>
                    <tr>
                        <th><?= $hackaton['idhackathon'] ?></th>
                        <td><?= $hackaton['thematique'] ?></td>
                        <td><?= $hackaton['lieu'] ?></td>
                        <td><?= $hackaton['dateheuredebuth'] ?></td>
                        <td><?= $hackaton['dateheurefinh'] ?></td>
                        <td style="display: flex; gap: 10px; align-items: center">
                            <a class="btn btn-sm btn-primary"
                               href="<?= "/sample/equipes?idh={$hackaton['idhackathon']}" ?>">
                                Les équipes
                            </a>
                            <a href="/sample/hackathon/stats/<?= $hackaton['idhackathon']; ?>"><i
                                        class="bi bi-graph-up"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card col-xl-7  col-lg-9 col-md-10 col-12 mt-5">
        <div class="card-body">
            <h5 class="card-title">API JSON</h5>

            <div class="card-text">
                <div>
                    Les Hackathons :
                    <code>
                        GET /api/hackathon/all
                    </code>
                </div>
                <div>
                    Hackathons actuellement actif :
                    <code>
                        GET /api/hackathon/active
                    </code>
                </div>
            </div>
        </div>
    </div>
</div>