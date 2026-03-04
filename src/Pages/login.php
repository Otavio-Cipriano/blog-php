<?php
    /**
     *  @var $errors
     * */
?>

<div class="p-2" style="max-width: 500px; margin: auto; height: 100vh; display: grid; align-content: center;">
    <form class="form" method="POST" action="/login">
        <h2 class="text-center">Login</h2>
        <?= $csrf ?>
        <div>
            <label for="inputUsername" class="form-label <?= $errors['username']? 'text-danger' : ''?>"">Username:</label>
            <input name="username" id="inputUsername" type="text" class="form-control <?= $errors['username']? 'error' : ''?>"/>
            <?php if(isset($errors['username'])): ?>
                <span class="form-text text-danger"><?= $errors['username'] ?></span>
            <?php endif; ?>
        </div>
        <div>
            <label for="inputPassword" class="form-label  <?= $errors['password']? 'text-danger' : ''?>">Password:</label>
            <input name="password" id="inputPassword"  type="password" class="form-control <?= $errors['password']? 'error' : ''?>"/>
            <?php if(isset($errors['password'])): ?>
                <span class="form-text text-danger"><?= $errors['password'] ?></span>
            <?php endif; ?>
        </div>
        <div>
            <button type="submit" class="btn btn-primary mt-3">Login</button>
        </div>
    </form>
</div>