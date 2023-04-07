<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Instrument</th>
            <th scope="col">Description</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($instruments as $instrument) : ?>
            <tr>
                <td><?= $instrument['instrument_id'] ?></td>
                <td>
                    <img src="<?= URL ?>public/images/<?= $instrument['instrument_image']?>" style="width: 25px;" />
                </td>
                <td><?= $instrument['instrument_nom'] ?></td>
                <td><?= $instrument['instrument_description'] ?></td>
                <td>
                    <a href="<?= URL ?>back/instruments/modification/<?= $instrument['instrument_id'] ?>" class="btn btn-warning">Modifier </a>
                    <!-- <form method="post" action="">
                        <input type="hidden" name="instrument_id" value="<?= $instrument['instrument_id'] ?>" />   
                        <button class="btn btn-warning" type="submit">Modifier</button>
                    </form> -->
                </td>
                <td>
                    <form method="post" action="<?= URL ?>back/instruments/validationSuppression" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                        <input type="hidden" name="instrument_id" value="<?= $instrument['instrument_id'] ?>" />
                        <button class="btn btn-danger" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>           
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
$content = ob_get_clean();
$titre = "Les instruments";
require "views/commons/template.php";