<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- start header search area -->
	<section id="login_form_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="login_form_area_container">
						<h3>INICIAR SESIÓN</h3>
						<form method="post" action="<?php echo site_url('verify');?>" id="login">
							<div class="form-group">
								<label for="username">EMAIL</label>
								<input type="text" name="username" placeholder="Ingresar Email" id="username" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
							</div>
							<div class="form-group">
								<label for="password">CONTRASEÑA</label>
								<input type="password" name="password" placeholder="Ingresar Contraseña" id="password" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
								<span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
							</div>
							<div style="text-align:center">
								<button type="submit" class="btn btn-swal2-confirm">INICIAR SESIÓN</button>
							</div>
						</form>
					</div>
					<hr style="margin: 5px 2rem 3px;border-top: 3px solid rgba(0,0,0,.1);">
					<div class="login_form_area_container">
						<h4 style="font-weight:400">¿OLVIDASTE TU CONTRASEÑA?</h4>
						<h4>RECUPÉRALA:</h4>
						<form method="post" action="<?php echo site_url('forgot');?>" id="forgot">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" name="email" placeholder="Ingresar Email" id="email" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
							</div>
							<div style="text-align:center">
								<button type="button" onclick="reset_password()" class="btn btn-swal2-confirm" id="forgotbtn">ENVIAR MI CONTRASEÑA</button>
							</div>
						</form>
					</div>
					<hr style="margin: 5px 2rem 3px;border-top: 3px solid rgba(0,0,0,.1);">
					<div style="text-align:center;padding: 15px;">
						<a href="javascript:history.back()" class="btn btn-swal2-cancel">VOLVER</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end header search area -->
