<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- start footer top -->
	<section id="footer_top">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="footer_top_container">
						<?php if (!$this->session->userdata('logged_in')) { ?>
						<a href="<?php echo base_url().'signup'; ?>">
							<div class="footer_top_content">
								<h3>Crear Cuenta</h3>
							</div>
						</a>
						<?php } ?>
						<a href="<?php echo ($this->session->userdata('logged_in'))?base_url().'selected':base_url().'login';?>">
							<div class="footer_top_content">
								<h3>Selección</h3>
							</div>
						</a>
						<a href="<?php echo base_url();?>frequent-questions">
							<div class="footer_top_content">
								<h3>Preguntas Frecuentes</h3>
							</div>
						</a>
						<a href="<?php echo base_url();?>contact-us">
							<div class="footer_top_content">
								<h3>Contactar</h3>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end footer top -->
	<!-- start main footer -->
	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="footer_container text-center">
						<img src="<?php echo base_url();?>assets/img/logo_vs.svg" alt="Logo" height="25" width="150" style="margin: 0px -3px;">
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- start main footer -->
	<!-- all javascript load here -->
	<script src="<?php echo base_url();?>assets/js/vendor/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url().'assets/js/vendor/jquery-ui.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/js/swiper-bundle.min.js'?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/ckeditor5/build/ckeditor.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.14.0/dist/sweetalert2.all.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/custom.js?v=2021"></script>
	<script type="text/javascript">
        $(document).ready(function(){
            $( "#searchLang" ).autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: "<?php echo site_url('autocomplete/language');?>",
						type: 'post',
						dataType: "json",
						data: {
							term: request.term,candidate:$( "#candidate_name_lang" ).val()
						},
						success: function( data ) {
							response( data );
						}
					});
				},
				select: function(event, ui){
					$('#lang_id').val(ui.item.id);
					$('#lang_id_candidate').val(ui.item.name);
					$('#searchLang').val(ui.item.name);
					$("#searchLangForm").submit();
				},
				focus: function(event, ui){
					$('#lang_id').val(ui.item.id);
					$('#searchLang').val(ui.item.name);
				}
            });

            $( "#searchcandidate" ).autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: "<?php echo site_url('autocomplete/candidate');?>",
						type: 'post',
						dataType: "json",
						data: {
							term: request.term,lang_id:$( "#lang_id_candidate" ).val()
						},
						success: function( data ) {
							response( data );
						}
					});
				},
				select: function(event, ui){
					$('#candidate_name').val(ui.item.name);
					$('#candidate_name_lang').val(ui.item.name);
					$('#searchcandidate').val(ui.item.name);
					$("#searchcandidateForm").submit();
				},
				focus: function(event, ui){
					$('#candidate_id').val(ui.item.id);
					$('#searchcandidate').val(ui.item.name);
				}
            });

			$(".toggle-password").click(function() {
				$(this).toggleClass("fa-eye fa-eye-slash");
				var input = $($(this).attr("toggle"));
				if (input.attr("type") == "password") {
					input.attr("type", "text");
				} else {
					input.attr("type", "password");
				}
			});

			$('#email,#reemail').bind("cut copy paste",function(e) {
				e.preventDefault();
			});

			<?php if (in_array($this->uri->segment(1), array('coming-soon','contact-us')) || ($this->uri->segment(1) == 'selected' && count($candidates) == 0)) { ?>
			$("#footer").addClass("sticky-footer");
			$("#footer_top").addClass("sticky-footer-top");
			<?php } ?>

		});

		function cancelEnter(event) {
			if (event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		}

		// function countLines() {
		// 	var el = document.getElementById('content');
		// 	var divHeight = el.offsetHeight
		// 	var lineHeight = parseInt(el.style.lineHeight);
		// 	var lines = divHeight / lineHeight;
		// 	alert("Lines: " + lines);
		// }

		// countLines();
		<?php if ($this->uri->segment(1) == 'candidates'){ ?>
		document.addEventListener('touchstart', handleTouchStart, false);        
		document.addEventListener('touchmove', handleTouchMove, false);

		var xDown = null;                                                        
		var yDown = null;

		function getTouches(evt) {
			return evt.touches ||             // browser API
				evt.originalEvent.touches; // jQuery
		}

		function handleTouchStart(evt) {
			const firstTouch = getTouches(evt)[0];                                      
			xDown = firstTouch.clientX;                                      
			yDown = firstTouch.clientY;                                      
		};                                                

		function handleTouchMove(evt) {
			if ( ! xDown || ! yDown ) {
				return;
			}

			var xUp = evt.touches[0].clientX;                                    
			var yUp = evt.touches[0].clientY;

			var xDiff = xDown - xUp;
			var yDiff = yDown - yUp;

			if(evt.target.id != "swiper"){
				if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {/*most significant*/
					if ( xDiff > 0 ) {
						/* left swipe */ 
						<?php echo ($next == 0)?"":'window.location.href = "'.base_url().'candidates/'.$next.'?lang='.rawurlencode($lang_id).'&candidate='.rawurlencode($candidate).'";'; ?>
					} else {
						/* right swipe */
						<?php echo ($prev == 0)?"":'window.location.href = "'.base_url().'candidates/'.$prev.'?lang='.rawurlencode($lang_id).'&candidate='.rawurlencode($candidate).'";'; ?>
					}                       
				} else {
					if ( yDiff > 0 ) {
						/* up swipe */ 
					} else { 
						/* down swipe */
					}
				}
			}
			/* reset values */
			xDown = null;
			yDown = null;                                             
		};

		<? if (isset($this->session->userdata('logged_in')['status']) && $this->session->userdata('logged_in')['status'] == 'special') { ?>
		let lyrics;
		ClassicEditor.create( document.querySelector( '#lyricseditor' ), {
			link: {
				addTargetToExternalLinks: true,
				decorators: [
					{
						mode: 'manual',
						label: 'Downloadable',
						attributes: {
							download: 'download'
						}
					}
				]
			}
		})
		.then( editor => { lyrics = editor; } )
		.catch( error => { console.error( error ); } );

		let info;
		ClassicEditor.create( document.querySelector( '#infoeditor' ), {
			link: {
				addTargetToExternalLinks: true,
				decorators: [
					{
						mode: 'manual',
						label: 'Downloadable',
						attributes: {
							download: 'download'
						}
					}
				]
			}
		})
		.then( editor => { info = editor; } )
		.catch( error => { console.error( error ); } );
		
		function updatelyrics() {
			$('#updatelyrics').hide();
			$('#savelyrics').show();
			$('#lyrics').hide();
			$('#lyricss').show();
			$('#info').hide();
			$('#infos').show();
			$('#source_lyrics').hide();
			$('#source_lyricss').show();
			// $('#noteeditor').show();
			$('#lyricss .ck-editor').show();
			$('#infos .ck-editor').show();
		}

		function savelyrics() {
			$('#savelyrics').hide();
			$.ajax({
				url:"<?php echo site_url('savelyrics');?>",
				method:"POST",
				data:{
					candidate_id:<?php echo $row->id; ?>,
					lyrics:lyrics.getData(),
					source_url:$('#source_url').val(),
					source_name:$('#source_name').val(),
					info:info.getData()
				},
				cache:false,
				success:function(data){
					if(data){
						$('#info').html(info.getData());
						$('#lyrics').html(lyrics.getData());
						$("#source_lyrics").attr("href", $('#source_url').val());
						$("#source_lyrics").html($('#source_name').val());
						$('#info').show();
						$('#lyrics').show();
						$('#source_lyrics').show();
					}
				}
			});
			$('#updatelyrics').show();
			$('#infos .ck-editor').hide();
			$('#lyricss .ck-editor').hide();
		}
		<?php } ?>

		const maxCharacters = 200;
		const container = document.querySelector( '.comments' );
		const progressCircle = document.querySelector( '.comments__chart__circle' );
		const charactersBox = document.querySelector( '.comments__chart__characters' );
		// const wordsBox = document.querySelector( '.comments__words' );
		const circleCircumference = Math.floor( 2 * Math.PI * progressCircle.getAttribute( 'r' ) );
		const sendButton = document.querySelector( '.comments__send' );
		let comments;
		ClassicEditor.create( document.querySelector( '#comments__editor' ), {
			wordCount: {
				onUpdate: stats => {
					const charactersProgress = circleCircumference - (stats.characters / maxCharacters * circleCircumference);
					const isLimitExceeded = stats.characters > maxCharacters;
					const isCloseToLimit = !isLimitExceeded && stats.characters > maxCharacters * .8;
					const circleDashArray = Math.min( charactersProgress, circleCircumference );
					progressCircle.setAttribute( 'stroke-dasharray', `${ circleDashArray },${ circleCircumference }` );
					charactersBox.textContent = ( isLimitExceeded ) ? `-${ stats.characters - maxCharacters }` : maxCharacters - stats.characters;
					// wordsBox.textContent = `Words in the post: ${ stats.words }`;
					container.classList.toggle( 'comments__limit-close', isCloseToLimit );
					container.classList.toggle( 'comments__limit-exceeded', isLimitExceeded );
					sendButton.toggleAttribute( 'disabled', isLimitExceeded );
				}
			},
			link: {
				addTargetToExternalLinks: true,
				decorators: [
					{
						mode: 'manual',
						label: 'Downloadable',
						attributes: {
							download: 'download'
						}
					}
				]
			}
		} )
		.then( editor => { comments = editor; } )
		.catch( error => { console.error( error ); } );

		function updatecomments() {
			$('#updatecomments').hide();
			$('#savecomments').show();
			$('#comments').show();
			$('#comments .ck-editor').show();
		}

		function savecomments() {
			$('#savecomments').hide();
			console.log(comments.getData());
			let mycomment = comments.getData();
			if (mycomment != ""){
				$('.comments_list .no-comment').remove();
				$.ajax({
					url:"<?php echo site_url('savecomments');?>",
					method:"POST",
					data:{comments:mycomment,candidate_id:<?php echo $row->id; ?>},
					cache:false,
					success:function(data){
						if(data){
							data = JSON.parse(data);
							$( ".comments_list" ).prepend( `<div class="the-comments" style="margin-bottom:5px">
								<div class="row" style="margin-bottom:5px">
									<div class="col-8" style="padding: unset;font-weight: 700;">
										${data.username}
									</div>
									<div class="col-4" style="padding: unset;color: grey;text-align:right;">
									${data.cdate}
									</div>
								</div>
								<div class="comment">
								${mycomment}
								</div>
								<div class="like-comment" style="text-align: right;position: relative;bottom: 10px;">
									<label for="flexCheckDefault" style="margin: 0 5px;vertical-align: middle;color: grey;">
										<input class="star" type="checkbox" id="flexCheckDefault" 
										title="bookmark comments" 
										onclick="set_like(this,${data.comments_id})">0
									</label>
								</div>
							</div>` );
						}
					}
				});
			}
			$('#comments').hide();
			comments.setData('');
			$('#updatecomments').show();
			$('#comments .ck-editor').hide();
		}

		let note;
		ClassicEditor.create( document.querySelector( '#noteeditor' ), {
			link: {
				addTargetToExternalLinks: true,
				decorators: [
					{
						mode: 'manual',
						label: 'Downloadable',
						attributes: {
							download: 'download'
						}
					}
				]
			}
		})
		.then( editor => {
			note = editor;
		} )
		.catch( error => {
			console.error( error );
		} );
		
		function updatenotes() {
			$('#updatenotes').hide();
			$('#savenotes').show();
			$('#note').hide();
			$('#notes').show();
			// $('#noteeditor').show();
			$('#notes .ck-editor').show();
		}

		function savenotes() {
			$('#savenotes').hide();
			$.ajax({
				url:"<?php echo site_url('savenote');?>",
				method:"POST",
				data:{note:note.getData(),candidate_id:<?php echo $row->id; ?>},
				cache:false,
				success:function(data){
					if(data){
						if (note.getData() == ""){
							$('#updatenotes').html('CREAR');
							$('#note').hide();
							$('#notes').hide();
						} else {
							$('#note').html(note.getData());
							$('#updatenotes').html('EDITAR');
							$('#note').show();
						}
					}
				}
			});
			$('#updatenotes').show();
			$('#notes .ck-editor').hide();
		}

		function load_more_comments(limit, start) {
			$('#load_data_comments').html('<img src="<?php echo base_url();?>assets/img/Loading.gif" alt="Loading" height=100>');
			$.ajax({
				url:"<?php echo site_url('morecomments');?>",
				method:"POST",
				data:{limit:limit, start:start, candidate:<?php echo $row->id; ?>},
				cache:false,
				success:function(data){
					var res = data.split("|");
					if (typeof res[1] !== 'undefined' && res[1].length > 0) {
						$('#load_comments').append(res[1]);
					}
					if(res[0] == 'no'){
						$('#load_data_comments').css("display","none");
					}else{
						start = start + limit;
						$('#load_data_comments').html(`<a style="color: #05386B;" onclick="load_more_comments(${limit},${start})" id="loadMoreComments">Más commentarios...</a>`);
					}
				}
			});
		};
		<?php } ?>

		<?php if (in_array($this->uri->segment(1), array('','search','selected','home','candidates'))){ ?>
		function load_more_candidates(tipe, limit, start) {
			<?php // tipe ('selected','todos','coalition') ?>
			$('#load_data_message').html('<img src="<?php echo base_url();?>assets/img/Loading.gif" alt="Loading" height=100>');
			var candidate = (tipe == 'coalition')?'<?php echo $coalition;?>':'<?php echo $candidate;?>';
			// location.hash = tipe+'-'+limit+'-'+start;
			// localStorage.setItem("lastload", tipe+'-'+limit+'-'+start);
			$.ajax({
				url:"<?php echo site_url('loadmore');?>",
				method:"POST",
				data:{limit:limit, start:start, selected:tipe, candidate:candidate, lang: '<?php echo $lang_id;?>'},
				cache:false,
				success:function(data){
					var res = data.split("|");
					if (typeof res[1] !== 'undefined' && res[1].length > 0) {
						$('#load_data').append(res[1]);
					}
					if(res[0] == 'no'){
						$('#load_data_message').css("display","none");
					}else{
						start = start + limit;
						$('#load_data_message').html(`<a class="btn btn-loadmore" onclick="load_more_candidates('${tipe}',${limit},${start})" id="loadMore"><i class="fa fa-caret-down" aria-hidden="true"></i> Más candidatos...</a>`);
					}
				}
			});
		};
		<?php } ?>

		function readmore() {
			document.getElementById("lyrics").classList.toggle("truncate");
			if(document.getElementById("lyrics").classList.contains('truncate')) {
				document.getElementById("readmore").innerHTML = "More..."; 
			} else {
				document.getElementById("readmore").innerHTML = "Less"; 
			}
		}

		function set_favorite(elem,id) {
			<?php if (!$this->session->userdata('logged_in')) { ?>
				window.location = '<?php echo base_url().'sign-up'; ?>';
			<?php } else { ?>
				$.ajax({
					url:"<?php echo site_url('selected/record');?>",
					method:"POST",
					data:{candidatesid:id,favorite:$(elem)[0].checked},
					cache:false,
					success:function(data){
						if (!data) {
							window.location = '<?php echo base_url().'sign-up'; ?>';
						}
					}
				});
			<?php } ?>
		}

		function set_like(elem,id) {
			<?php if (!$this->session->userdata('logged_in')) { ?>
				window.location = '<?php echo base_url().'signup/createcomment'; ?>';
			<?php } else { ?>
				$.ajax({
					url:"<?php echo site_url('like-comments');?>",
					method:"POST",
					data:{comments_id:id,like:$(elem)[0].checked},
					cache:false,
					success:function(data){
						if (!data) {
							window.location = '<?php echo base_url().'signup/createcomment'; ?>';
						} else {
							$('#like_label span').text(data);
						}
					}
				});
			<?php } ?>
		}

		function show_popup(type, msg) {
			let bowal = Swal.fire({
				// title: 'username',
				html: msg,
				confirmButtonText: 'CERRAR',
				customClass: {
					confirmButton: 'btn btn-swal2-confirm',
					cancelButton: 'btn btn-swal2-cancel-darker'
				},
				buttonsStyling: false,
				allowOutsideClick: false,
			});
			if (type == 'register' || type == 'delete-account'){
				bowal.then((result) => {
					if (result.isConfirmed) {
						window.location = (type == 'delete-account')?'<?php echo base_url().'logout'; ?>':'<?php echo base_url(); ?>';
					}
				});
			}
		}

		// var csrfName = '<?php //echo $this->security->get_csrf_token_name(); ?>',
		// 	csrfHash = '<?php //echo $this->security->get_csrf_hash(); ?>';
		function change_username() {
			$('#chuserbtn').attr('disabled','true');
			$.ajax({
				url:"<?php echo site_url('change/username');?>",
				method:"POST",
				data:$('#change_user').serialize(),
				cache:false,
				success:function(data){
					$('#chuserbtn').removeAttr('disabled');
					if (data == 'yes') {
						$('#hisusername').html($('#username').val());
						$('#h-username').html($('#username').val());
						$('#username').val('');
						show_popup('username',"Tu <b>nombre de usuario</b><br>ha sido cambiado.");
					} else {
						show_popup('username',data);
					}
				}
			});
		}

		function change_password() {
			$('#chpassbtn').attr('disabled','true');
			if ($("#password").val().length >= 8) {
				$.ajax({
					url:"<?php echo site_url('change/password');?>",
					method:"POST",
					data:$('#change_pass').serialize(),
					cache:false,
					success:function(data){
						$('#chpassbtn').removeAttr('disabled');
						if (data=='yes') {
							$('#password').val('');
							show_popup('password',"Tu <b>contraseña</b><br>ha sido cambiada");
						} else {
							show_popup('password',data);
						}
					}
				});
			} else {
				$('#chpassbtn').removeAttr('disabled');
				show_popup('password',"Password can be changed at least 8 characters");
			}
		}

		function register() {
			$('#send').attr('disabled','true');
			$.ajax({
				url:"<?php echo site_url('register');?>",
				method:"POST",
				data:$('#signup').serialize(),
				cache:false,
				success:function(data){
					$('#send').removeAttr('disabled');
					if (data == 'email') {
						Swal.fire({
							html: `Este email <b>${$('#email').val()}</b><br>ya está siendo usado por una cuenta.<br><br>
								Si la cuenta y el email<br>son tuyos, te podemos enviar<br>tu contraseña a este mismo email.`,
							showCancelButton: true,
							confirmButtonText: 'SÍ, ENVIAR MI CONTRASEÑA',
							cancelButtonText: 'CANCELAR',
							customClass: {
								confirmButton: 'btn btn-swal2-confirm',
								cancelButton: 'btn btn-swal2-cancel-dark'
							},
							buttonsStyling: false,
							allowOutsideClick: false,
						}).then((result) => {
							if (result.isConfirmed) {
								$.ajax({
									url:"<?php echo site_url('forgot');?>",
									method:"POST",
									data:{email:$('#email').val()},
									cache:false,
									success:function(data){
										if (data == 'yes') {
											show_popup('register',`Te hemos enviado tu <b>contraseña</b> a tu email<br>
												<b style="color:darkred">${$('#email').val()}</b><br>para que puedas usarla para <b>iniciar tu sesión.</b>`);
										} else {
											show_popup('reset password',data);
										}
									}
								});
							}
						});
					} else if (data.includes("successfully")) {
						$('#username').val('');
						$('#email').val('');
						$('#reemail').val('');
						show_popup('register',data);
					} else {
						show_popup('register not',data);
					}
				}
			});
		}

		function reset_password() {
			$('#forgotbtn').attr('disabled','true');
			$.ajax({
				url:"<?php echo site_url('forgot');?>",
				method:"POST",
				data:$('#forgot').serialize(),
				cache:false,
				success:function(data){
					$('#forgotbtn').removeAttr('disabled');
					if (data == 'yes') {
						show_popup('reset password',`Te hemos enviado tu <b>contraseña</b> a tu email<br>
							<b style="color:#C00100">${$('#email').val()}</b><br>para que puedas usarla para <b>iniciar tu sesión.</b>`);
						$('#email').val('');
					} else {
						show_popup('reset password',data);
					}
				}
			});
		}
		
		<?php if($this->session->flashdata('result_signup')){ ?>
			show_popup('show result',`<?php echo $this->session->flashdata('result_signup');?>`);
		<?php } ?>

		<?php if ($this->uri->segment(1) == 'candidates') { ?>
		var swiper1 = new Swiper('.swiper1', {
			slidesPerView: 1,
			spaceBetween: 30,
			centeredSlides: true,
			// loop: true,
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});
		var swiper2 = new Swiper('.swiper2', {
			spaceBetween: 0,
			width: 100,
			centeredSlides: true,
			/*autoplay: {
				delay: 5500,
				disableOnInteraction: false,
			}, */
		});
		<?php } else { ?>
		var swiper = new Swiper('.swiper-container', {
			spaceBetween: 0,
			width: 100,
			centeredSlides: true,
			/*autoplay: {
				delay: 5500,
				disableOnInteraction: false,
			}, */
		});
		<?php } ?>

		function delete_account(){
			Swal.fire({
				html: `¿Estás seguro(a) de que <br>quieres <b>eliminar</b><br>tu cuenta?<br>
					<div style='margin-top:10px;color: #C00100;font-weight:700;font-size:17px'>
					Esto no se puede deshacer<br>y perderás<br>todos tus datos guardados<br>y tus preferencias.</div>`,
				showCancelButton: true,
				reverseButtons: true,
				confirmButtonText: 'Sí, eliminar mi cuenta',
				cancelButtonText: 'No, por favor mantener mi cuenta',
				customClass: {
					confirmButton: 'btn btn-swal2-confirm',
					cancelButton: 'btn btn-swal2-cancel-darker'
				},
				buttonsStyling: false,
				allowOutsideClick: false,
			}).then((result) => {
				if (result.isConfirmed) {
					confirmdelete();
				}
			});
		}

		async function confirmdelete() {
			const { value: password } = await Swal.fire({
				html: "Por favor ingresa tu <b>contraseña</b>",
				input: 'password',
				inputAttributes: {
					autocapitalize: 'off'
				},
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonText: 'ELIMINAR MI CUENTA',
				cancelButtonText: 'CANCELAR',
				inputValidator: (value) => {
					if (!value) {
						return 'Necesitas ingresar tu contraseña.'
					}
				},
				customClass: {
					confirmButton: 'btn btn-swal2-confirm',
					cancelButton: 'btn btn-swal2-cancel-dark'
				},
				buttonsStyling: false,
				allowOutsideClick: false,
			});
			if (password) {
				$.ajax({
					url:"<?php echo site_url('delete-account');?>",
					method:"POST",
					data:{password:password},
					cache:false,
					success:function(data){
						if (data == 'yes') {
							show_popup('delete-account',`Tu cuenta ha sido eliminada. <br>Si quieres iniciar una sesión <br>necesitarás crear una nueva cuenta.`);
						} else {
							show_popup('password',data);
						}
					}
				});
			}
		}
	</script>
</body>

</html>
