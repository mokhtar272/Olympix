<div class="container mt-5">
    <h2 class="mb-4">Tableau de Bord</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Concours Total</h5>
                    <p class="card-text h3"><?= esc($stats['total_concours']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Concours à Venir</h5>
                    <p class="card-text h3"><?= esc($stats['concours_a_venir']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Concours en Inscription</h5>
                    <p class="card-text h3"><?= esc($stats['concours_inscription']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Concours en Pré-Sélection</h5>
                    <p class="card-text h3"><?= esc($stats['concours_preselection']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-secondary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Concours en Phase Finale</h5>
                    <p class="card-text h3"><?= esc($stats['concours_phase_finale']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Concours Terminés</h5>
                    <p class="card-text h3"><?= esc($stats['concours_termines']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card text-white bg-dark shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total de Candidatures</h5>
                    <p class="card-text h3"><?= esc($stats['total_candidatures']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Nombre de Jury</h5>
                    <p class="card-text h3"><?= esc($stats['total_jury']) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
