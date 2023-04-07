<?php ob_start(); ?>  <!-- la fonction ob-start me permet de déverser tout ce qui s'y trouve dans le template, au travers de la variable content utilisée dans la view -->

<form method="POST" action="<?= URL ?>back/connexion">
  <div class="mb-3">
    <label for="login" class="form-label">Login</label>
    <input type="text" class="form-control" id="login1" name="login" aria-describedby="loginHelp">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Valider</button>
</form>

<?php
$content = ob_get_clean();
$titre = "Login";
require "views/commons/template.php";