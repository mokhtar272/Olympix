<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #87CEEB; height: 80px;">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center me-5" href="<?php echo base_url('/'); ?>" style="font-size: 3rem; font-weight: bold; margin-right: auto;">
      <i class="fa-solid fa-trophy me-2"></i> OlymPix
    </a>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav" style="font-size: 1.75rem; gap: 4rem;">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo base_url('/'); ?>">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('/index.php/concours/afficher'); ?>">Concours</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('/index.php/candidature/afficher'); ?>">Suivi de Candidature</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('/index.php/contact'); ?>">Contact</a>
        </li>
      </ul>
    </div>

    <a href="<?php echo base_url('/index.php/compte/connecter'); ?>" class="btn btn-light" style="font-size: 1.75rem;">Connexion</a>
  </div>
</nav>



<!-- Formulaire global
<div id="formulaire-inscription" style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, 0); width: 400px; background: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000;">
    <form action="<?php echo base_url('/index.php/candidature/afficher'); ?>" method="post">
        <div class="mb-3">
            <input type="text" name="code_inscription" placeholder="Entrez le code d'inscription" class="form-control" required>
        </div>
        <div class="mb-3">
            <input type="text" name="code_candidat" placeholder="Entrez le code candidat" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('formulaire-inscription').style.display='none';">Fermer</button>
    </form>
</div> -->

