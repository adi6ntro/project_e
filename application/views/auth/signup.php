<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- start header search area -->
	<section id="login_form_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="login_form_area_container">
						<h3 style="text-transform:none">
							<?php echo ($cek == '')?'Tener una cuenta te permitirá':'Necesitas tener una cuenta para'; ?>
							<br>
							<?php if ($cek == 'createnote') {
								echo 'crear notas sobre los candidatos.';
							} if ($cek == 'createcomment') {
								echo 'crear commentarios sobre los candidatos.';
							} else {
								echo 'seleccionar y guardar candidatos.';
							} ?>
						</h3>
						<h3 style="text-transform:none;font-weight:400;margin-top:10px;margin-bottom:20px">
							Para crear una cuenta sólo ingresa<br>
							un nombre de usuario y un email<br>
							para enviarte una contraseña:
						</h3>
						<form method="post" id="signup">
							<div class="form-group">
								<label for="username">USUARIO(A)</label>
								<input type="text" name="username" placeholder="Ingresar Nombre" id="username" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
							</div>
							<div class="form-group">
								<label for="email">EMAIL</label>
								<input type="email" name="email" placeholder="Ingresar Email" id="email" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
							</div>
							<div class="form-group">
								<label for="reemail">CONFIRMAR EMAIL</label>
								<input type="email" name="reemail" placeholder="Ingresar Email nuevamente" id="reemail" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
							</div>
							<div style="text-align:center">
								<button type="button" onclick="register()" id="send" class="btn btn-swal2-confirm">ENVIAR</button><br><br>
								<a href="<?php echo base_url();?>" class="btn btn-swal2-cancel-light">CANCELAR</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end header search area -->
