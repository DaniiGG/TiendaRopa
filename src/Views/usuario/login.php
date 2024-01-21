<h1>Login</h1>
<?php use Utils\Utils; ?>
 
    <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?> 
        <strong class="alert_red">Registro fallido, introduzca bien los datos</strong> 

        <?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'carrito'): ?> 
        <strong class="alert_red">Para comprar debe iniciar sesion</strong> 
        <?php endif; ?>
<?php Utils::deleteSession('register'); ?>
<form action="<?=BASE_URL?>usuario/login/" method="post"> 
<label for="email">Email</label>
<input type="email" name="data[email]" id="email" />
<label for="pass">Contraseña</label>
<input type="pass" name="data[pass]" id="pass"/> 
<input type="submit" value="Enviar" />
</form>