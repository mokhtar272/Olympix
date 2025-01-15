<div class="container mt-5">
    <h2 class="text-center mb-4"><?= esc($titre); ?></h2>

    <?php if (isset($validation) && $validation->listErrors()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($validation->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?= form_open('/concours/creer'); ?>
    <?= csrf_field() ?>

    <!-- Champ Titre -->
    <div class="form-group">
        <label for="titre" class="control-label">Titre</label>
        <input type="text" name="titre" id="titre" class="form-control" value="<?= old('titre') ?>" required>
    </div>

    <!-- Champ Description -->
    <div class="form-group">
        <label for="description" class="control-label">Description</label>
        <textarea name="description" id="description" class="form-control" required><?= old('description') ?></textarea>
    </div>

    <!-- Champ Date de Début -->
    <div class="form-group">
        <label for="date_debut" class="control-label">Date de début</label>
        <input type="date" name="date_debut" id="date_debut" class="form-control" value="<?= old('date_debut') ?>" required>
        <!-- Affichage de l'erreur spécifique pour la date -->
        <?php if (isset($date_error)): ?>
            <div class="text-danger"><?= esc($date_error); ?></div>
        <?php endif; ?>
    </div>

    <!-- Nombre de jours pour les candidatures -->
    <div class="form-group">
        <label for="nb_jours_condidature" class="control-label">Nombre de jours pour candidatures</label>
        <input type="number" name="nb_jours_condidature" id="nb_jours_condidature" class="form-control" value="<?= old('nb_jours_condidature') ?>" required>
    </div>

    <!-- Nombre de jours pour la préselection -->
    <div class="form-group">
        <label for="nb_jours_preselection" class="control-label">Nombre de jours pour la présélection</label>
        <input type="number" name="nb_jours_preselection" id="nb_jours_preselection" class="form-control" value="<?= old('nb_jours_preselection') ?>" required>
    </div>

    <!-- Nombre de jours pour la sélection -->
    <div class="form-group">
        <label for="nb_jours_selection" class="control-label">Nombre de jours pour la sélection</label>
        <input type="number" name="nb_jours_selection" id="nb_jours_selection" class="form-control" value="<?= old('nb_jours_selection') ?>" required>
    </div>

    <!-- Champ Édition -->
    <div class="form-group">
        <label for="edition" class="control-label">Édition</label>
        <input type="text" name="edition" id="edition" class="form-control" value="<?= old('edition') ?>" required>
    </div>

    <!-- Champ Image -->
    <div class="form-group">
        <label for="image" class="control-label">URL de l'image</label>
        <input type="url" name="image" id="image" class="form-control" value="<?= old('image') ?>">
    </div>

    <!-- Champ Admin ID -->
    <!-- <div class="form-group">
        <label for="admin_id" class="control-label">ID de l'administrateur</label>
        <input type="number" name="admin_id" id="admin_id" class="form-control" value="<?= old('admin_id') ?>" required>
    </div> -->

    <!-- Bouton Soumettre -->
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Créer un concours</button>
    </div>
    </form>
</div>
