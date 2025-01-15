<div class="container mt-5">
        <h2 class="text-center mb-4">Profil du Jury</h2>
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <!-- Photo du Jury -->
                    <div class="col-md-4 text-center">
                    </div>

                    <!-- Informations du Jury -->
                    <div class="col-md-8">
                        <h4><?php echo $jury['jry_prenom'] . ' ' . $jury['jry_nom']; ?></h4>
                        <p><strong>Discipline :</strong> <?php echo $jury['jry_discipline_expertise']; ?></p>
                        <p><strong>Biographie :</strong> <?php echo $jury['jry_biographie']; ?></p>
                        <p><strong>Site Web :</strong> <a href="<?php echo $jury['jry_url']; ?>" target="_blank"><?php echo $jury['jry_url']; ?></a></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Boutons -->
        <div class="text-center">
            <a href="<?php echo base_url('/index.php/compte/modifier_profil'); ?>" class="btn btn-primary">Modifier informations</a>
        </div>
    </div>