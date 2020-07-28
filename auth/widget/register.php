<form action="<?=$action;?>" method="post">
    <?=\fw_micro\security\CSRF::print();?>
    <p><label for="form-login"><?= $loginField ?? 'Login'; ?></label><input type="text" name="login" id="form-login"></p>
    <p><label for="form-password"><?= $passwordField ?? 'Password'; ?></label><input type="password" name="password" id="form-password"></p>
    <button type="submit"><?= $submitText ?? 'Register'; ?></button>
</form>