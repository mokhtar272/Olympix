<div class="container mt-5">
        <h2 class="text-center mb-4">Profil du Admin</h2>
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                   

                    <!-- Informations du Jury -->
                    <div class="col-md-8">
                        <p><strong>e_mail :</strong> <?php echo $admin['e_mail']; ?></p>
                        <p><strong>role :</strong> <?php echo $role; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Boutons -->
        <div class="text-center">
            <a href="<?php echo base_url('/index.php/compte/modifier_profil'); ?>" class="btn btn-primary">Modifier mot de passe</a>
        </div>
    </div>