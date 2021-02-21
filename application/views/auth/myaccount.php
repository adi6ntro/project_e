<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- start header search area -->
	<section id="login_form_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="login_form_area_container">
						<h3 id="hisusername" style="text-transform:none"><?php echo_secure($username); ?></h3>
						<h5 class="text-center mt-2" style="color:#7f7f7f;font-size:14px">CUENTA</h5>
					</div>
					<hr style="margin: 1rem 2rem;border-top: 3px solid rgba(0,0,0,.1);">
					<div class="login_form_area_container">
						<h4 style="font-weight:500">CAMBIAR CONTRASEÑA</h4>
						<form id="change_pass">
							<div class="form-group">
								<input type="password" name="password" placeholder="Ingresar Nueva Contraseña" minlength="8" id="password" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
								<span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
							</div>
							<div style="text-align:center">
								<button type="button" onclick="change_password()" class="btn btn-swal2-confirm" id="chpassbtn">CAMBIAR</button>
							</div>
						</form>
					</div>
					<hr style="margin: 1rem 2rem;border-top: 3px solid rgba(0,0,0,.1);">
					<div class="login_form_area_container">
						<h4 style="font-weight:500">CAMBIAR NOMBRE DE USUARIO</h4>
						<form id="change_user">
							<div class="form-group">
								<input type="text" name="username" placeholder="Ingresar Nuevo Nombre" id="username" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
							</div>
							<div style="text-align:center">
								<button type="button" onclick="change_username()" class="btn btn-swal2-confirm" id="chuserbtn">CAMBIAR</button>
							</div>
						</form>
					</div>
					<hr style="margin: 1rem 2rem;border-top: 3px solid rgba(0,0,0,.1);">
					<div class="login_form_area_container">
						<h4 style="font-weight:500">ELIMINAR CUENTA</h4>
						<div class="text-center mt-3">
							<button type="button" class="btn btn-swal2-confirm" onclick="delete_account()" id="deletebtn">ELIMINAR</button>
						</div>
					</div>
					<hr style="margin: 1rem 2rem;border-top: 3px solid rgba(0,0,0,.1);">
					<div class="text-center mb-4">
						<a style="margin-top: 10px;" href="javascript:history.back()" class="btn btn-swal2-cancel">VOLVER AL SITIO</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end header search area -->
