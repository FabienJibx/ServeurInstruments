<?php ob_start(); ?>

<form method="POST" action="<?= URL ?>back/instruments/creationValidation" enctype="multipart/form-data">
    <div class="form-group mb-3">
        <label for="instrument_nom" class="form-label">Nom de l'instrument</label>
        <input type="text" class="form-control" id="instrument_nom" name="instrument_nom">
    </div>
    <div class="form-group mb-3">
        <label for="instrument_description" class="form-label">Description</label>
        <textarea class="form-control" id="instrument_description" name="instrument_description" rows="3"></textarea>
    </div>
    <div class="form-group mb-3">
        <label for="image" class="form-label">Image :</label>
        <input class="form-control-file" type="file" id="image" name="image">
    </div>
    <div class="form-group mb-3">
        <label for="image">Familles :</label>
        <select class="form-select" aria-label="Default select example" name="family_id">
            <option selected>Open this select menu</option>
            <?php foreach ($familys as $family) : ?>
                <option value="<?= $family['family_id'] ?>">
                    <?= $family['family_id'] ?> - <?= $family['family_libelle'] ?>
                </option>
            <?php endforeach; ?>
        </select> 
    </div>
    <div class="justify-content-evenly row no-gutters">
        <div class="col-1"></div>
        <?php foreach($studios as $studio) : ?>
            <div class="form-group mb-3 form-check col-2">
                <input type="checkbox" class="form-check-input" name="studio-<?= $studio['studio_id'] ?>">
                <label class="form-check-label" for="exampleCheck1"><?= $studio['studio_libelle'] ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-primary">Créer</button>
</form>

<?php 
$content = ob_get_clean();
$titre = "Page de création d'un instrument";
require "views/commons/template.php";