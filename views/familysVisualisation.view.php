<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Famille</th>
            <th scope="col">Description</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($familys as $family) : ?>
            <?php if(empty($_POST['family_id']) || $_POST['family_id'] !== $family['family_id']) : ?>
                <tr>
                    <td><?= $family['family_id'] ?></td>
                    <td><?= $family['family_libelle'] ?></td>
                    <td><?= $family['family_description'] ?></td>
                    <td>
                        <form method="post" action="<?= URL ?>back/familles/modificationFamily">
                            <input type="hidden" name="family_id" value="<?= $family['family_id'] ?>" />   
                            <button class="btn btn-warning" type="submit">Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?= URL ?>back/familles/validationSuppression" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                            <input type="hidden" name="family_id" value="<?= $family['family_id'] ?>" />
                            <button class="btn btn-danger" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php else: ?>
                <form method="post" action="<?= URL ?>back/familles/validationModification">
                    <tr>
                        <td><?= $family['family_id'] ?></td>
                        <td><input type="text" name="family_libelle" class="form-control" value="<?= $family['family_libelle'] ?>"  /></td>
                        <td><textarea name='family_description' class="form-control" rows="3"><?= $family['family_description'] ?></textarea></td>
                        <td colspan="2">
                            <input type="hidden" name="family_id" value="<?= $family['family_id'] ?>" />   
                            <button class="btn btn-primary" type="submit">Valider</button>
                        </td>
                    </tr>
                </form>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
$content = ob_get_clean();
$titre = "Les familles d'instruments";
require "views/commons/template.php";