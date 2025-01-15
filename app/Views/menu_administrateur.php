<?php ini_set('display_errors', 1);
error_reporting(E_ALL); ?>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="text-white vh-100 p-3" style="background-color: #2f9ac5; width: 250px; position: fixed; top: 0; left: 0; z-index: 1000;">
        <h4 class="text-center mb-4">Espace <?php echo $role; ?></h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="<?php echo base_url('/index.php/compte/afficher_profil'); ?>" class="nav-link text-white">
                    <i class="bi bi-person-circle"></i> Mon Profil
                </a>
            </li>

            <?php if ($role === 'Admin'): ?>
                <li class="nav-item mb-2">
                    <a href="<?php echo base_url('/index.php/actualite/liste'); ?>" class="nav-link text-white">
                        <i class="bi bi-file-earmark-text"></i> Actualité
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="<?php echo base_url('/index.php/compte/afficher_admin'); ?>" class="nav-link text-white">
                        <i class="bi bi-people"></i> Comptes
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="<?php echo base_url('/index.php/concours/afficher_admin'); ?>" class="nav-link text-white">
                        <i class="bi bi-trophy"></i> Concours
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="<?php echo base_url('/index.php/compte/dashBord'); ?>" class="nav-link text-white">
                    <i class="fa-solid fa-chart-line"></i> DashBoard
                    </a>
                </li>
            <?php elseif ($role === 'Jury'): ?>
                <li class="nav-item mb-2">
                    <a href="<?php echo base_url('/index.php/concours/afficher_jury'); ?>" class="nav-link text-white">
                        <i class="bi bi-trophy"></i> Mes Concours
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item mb-2">
                <a href="<?php echo base_url('/index.php/compte/deconnecter'); ?>" class="nav-link text-white">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div style="margin-left: 250px;">
        <!-- Votre contenu principal ici -->
    </div>
</div>

<!-- Bootstrap JS (optionnel, pour fonctionnalités avancées) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
