<?php ob_start(); ?>

<form method="POST" action="<?= URL ?>back/instruments/modificationValidation" enctype="multipart/form-data">
    <input type="hidden" name="instrument_id" value="<?= $instrument['instrument_id']; ?>" />
    <div class="form-group mb-3">
        <label for="instrument_nom">Nom de l'instrument</label>
        <input type="text" class="form-control" id="instrument_nom" name="instrument_nom" value="<?= $instrument['instrument_nom']?>">
    </div>
    <div class="form-group mb-3">
        <label for="instrument_description">Description</label>
        <textarea class="form-control" id="instrument_description" name="instrument_description" rows="3"><?= $instrument['instrument_description'] ?></textarea>
    </div>
    <div class="form-group mb-3">
        <img src="<?= URL ?>public/images/<?= $instrument['instrument_image'] ?>" style="width:100px;" />
        <label for="image">Image :</label>
        <input class="form-control-file" type="file" id="image" name="image">
    </div>
    <div class="form-group mb-3">
        <label for="image">Familles :</label>
        <select class="form-select" aria-label="Default select example" name="family_id">
            <option selected>Open this select menu</option>
            <?php foreach ($familys as $family) : ?>
                <option value="<?= $family['family_id'] ?>"
                    <?php if($family['family_id'] === $instrument['family_id']) echo "selected"; ?>
                    >
                    <?= $family['family_id'] ?> - <?= $family['family_libelle'] ?>
                </option>
            <?php endforeach; ?>
        </select> 
    </div>
    <div class="justify-content-evenly row no-gutters">
        <div class="col-1"></div>
        <?php foreach($studios as $studio) : ?>
            <div class="form-group mb-3 form-check col-2">
                <input type="checkbox" class="form-check-input" name="studio-<?= $studio['studio_id'] ?>"
                    <?php if(in_array($studio['studio_id'],$tabStudios))
                        echo "checked";
                    ?>
                >
                <label class="form-check-label" for="exampleCheck1"><?= $studio['studio_libelle'] ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>

<?php 
$content = ob_get_clean();
$titre = "Page de modification de l'instrument : ".$lignesInstrument[0]['instrument_nom'];
require "views/commons/template.php";