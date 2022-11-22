<?php ob_start(); ?>

<form method="POST" action="<?= URL ?>back/familles/creationValidation">
    <div class="mb-3">
        <label for="family_libelle" class="form-label">Libelle</label>
        <input type="text" class="form-control" id="family_libelle" name="family_libelle">
    </div>
    <div class="mb-3">
        <label for="family_description" class="form-label">Description</label>
        <textarea class="form-control" id="family_description" name="family_description" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
</form>

<?php 
$content = ob_get_clean();
$titre = "Page de création d'une famille";
require "views/commons/template.php";