<div class="container mt-5" style="margin-bottom: 200px; ">
    <h2 class="mb-4">Détails de la Candidature</h2>

    <?php if (!empty($candidature)): ?>
        <div class="mb-5">
            <!-- Informations personnelles -->
            <p><strong>Nom :</strong> <?= esc($candidature[0]['nom']) ?></p>
            <p><strong>Prénom :</strong> <?= esc($candidature[0]['prenom']) ?></p>
            <p><strong>Email :</strong> <?= esc($candidature[0]['email']) ?></p>
            <p><strong>État :</strong> <?= esc($candidature[0]['etat']) ?></p>
            <p><strong>Catégorie :</strong> <?= esc($candidature[0]['categorie']) ?></p>
            <p><strong>Code d'Inscription :</strong> <?= esc($candidature[0]['code_inscription']) ?></p>
            <p><strong>Code Candidat :</strong> <?= esc($candidature[0]['code_candidat']) ?></p>
        </div>

        <!-- Liste des documents associés -->
        <div class="mb-4">
            <h4>Documents Associés</h4>
            <?php 
            $documents = array_filter($candidature, fn($doc) => !empty($doc['doc_nom']));
            ?>
            <?php if (!empty($documents)): ?>
                <?php foreach ($documents as $document): ?>
                    <?php
                    $nom_fichier = esc($document['doc_nom']);
                    $chemin_fichier = base_url('images/' . $nom_fichier);
                    $extension = pathinfo($nom_fichier, PATHINFO_EXTENSION);
                    ?>
                    <div class="mb-3">
                        <?php if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <a href="<?= $chemin_fichier ?>" target="_blank">
                                <img src="<?= $chemin_fichier ?>" alt="<?= $nom_fichier ?>" class="img-thumbnail" style="max-width: 200px;">
                            </a><br>
                        <?php else: ?>
                            <a href="<?= $chemin_fichier ?>" target="_blank"><?= $nom_fichier ?></a><br>
                        <?php endif; ?>
                        <p><?= esc($document['doc_description'] ?? 'Aucune description disponible') ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun document associé.</p>
            <?php endif; ?>
        </div>

        <form action="<?= base_url('/index.php/candidature/supprimer') ?>" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?');">
            <input type="hidden" name="code_candidat" value="<?= esc($candidature[0]['code_candidat']) ?>">
            <input type="hidden" name="code_inscription" value="<?= esc($candidature[0]['code_inscription']) ?>">
            <button type="submit" class="btn btn-danger">Supprimer ma candidature</button>
        </form>
    <?php else: ?>
        <p class="alert alert-warning">Aucune candidature trouvée.</p>
    <?php endif; ?>
</div>
