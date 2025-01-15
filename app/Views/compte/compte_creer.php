<div class="container mt-5" style="margin-bottom: 300px;">
    <h2 class="text-center mb-4"><?= esc($titre); ?></h2>

    <!-- Affichage des messages d'erreur globaux -->
    <?php if (isset($validation) && $validation->listErrors()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($validation->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Formulaire -->
    <?= form_open('/compte/creer'); ?>
    <?= csrf_field() ?>

    <!-- Champ Pseudo -->
    <div class="form-group">
        <label for="pseudo" class="control-label">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?= old('pseudo') ?>" required>
    </div>

    <!-- Champ Mot de Passe -->
    <div class="form-group">
        <label for="mdp" class="control-label">Mot de passe</label>
        <input type="password" name="mdp" id="mdp" class="form-control" required>
    </div>
    <!-- Champ Confirmation du Mot de Passe -->
<div class="form-group">
    <label for="mdp_confirm" class="control-label">Confirmez le mot de passe</label>
    <input type="password" name="mdp_confirm" id="mdp_confirm" class="form-control" required>
</div>


    <!-- Sélection du Rôle -->
    <div class="form-group">
        <label class="control-label">Rôle</label><br>
        <div class="form-check">
            <input type="radio" name="role" value="jury" id="jury" class="form-check-input" onclick="afficher()" <?= old('role') === 'jury' ? 'checked' : '' ?>>
            <label for="jury" class="form-check-label ml-4">Jury</label>
        </div>
        <div class="form-check">
            <input type="radio" name="role" value="admin" id="admin" class="form-check-input" onclick="afficher()" <?= old('role') === 'admin' ? 'checked' : '' ?>>
            <label for="admin" class="form-check-label ml-4">Admin</label>
        </div>
    </div>

    <!-- Champs supplémentaires pour Jury -->
    <div id="extra-fields" style="display: <?= old('role') === 'jury' ? 'block' : 'none'; ?>">
        <div class="form-group">
            <label for="nom" class="control-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="<?= old('nom') ?>">
        </div>
        <div class="form-group">
            <label for="prenom" class="control-label">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" value="<?= old('prenom') ?>">
        </div>
        <div class="form-group">
            <label for="expertise" class="control-label">Expertise</label>
            <textarea name="expertise" id="expertise" class="form-control"><?= old('expertise') ?></textarea>
        </div>
        <div class="form-group">
            <label for="biographie" class="control-label">biographie</label>
            <textarea name="biographie" id="biographie" class="form-control"><?= old('expertise') ?></textarea>
        </div>
        <div class="form-group">
            <label for="URL" class="control-label">URL</label>
            <input type="URL" name="URL" id="expertise" class="form-control"><?= old('URL') ?></input>
        </div>
    </div>

    <!-- Bouton Soumettre -->
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Créer un nouveau compte</button>
    </div>
    </form>
</div>

<script>
    function afficher() {
        const roleJury = document.getElementById('jury');
        const extraFields = document.getElementById('extra-fields');

        // Afficher les champs supplémentaires pour Jury
        extraFields.style.display = roleJury.checked ? 'block' : 'none';
    }
</script>
