<html>
<body>
	<h1><?php echo sprintf('Hola '.$identidad.', esta es su solicitud para restablecer su contraseña. %s');?></h1>
	<p><?php echo sprintf('Por favor haga clic en el enlace para realizar el cambio de contraseña. %s.', anchor('cuenta/resetear_contrasena/'. $codigo, 'Restablecer Tu Contraseña'));?></p>
	<br>
	<p><small>Si usted no ha solicitado el cambio de contraseña, por favor verifique el acceso a su cuenta.</small></p>
</body>
</html>