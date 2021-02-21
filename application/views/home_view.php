<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<!-- start header search area -->
	<section id="header_search_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="header_search_area_container">
						<h3>Buscar por Distrito</h3>
						<form method="post" action="<?php echo site_url('search/language');?>" id="searchLangForm">
							<div id="simpleSearch">
								<input type="hidden" name="lang_id" id="lang_id" value="<?php echo $lang_id;?>">
								<input type="hidden" name="candidate_name" id="candidate_name_lang" value="<?php echo $candidate;?>">
								<input type="search" name="search" placeholder="Ingresar Distrito" autocapitalize="sentences" value="<?php echo ($lang == 'TODOS')?'':$lang;?>"
								title="Buscar Distrito [ctrl-option-f]" accesskey="f" id="searchLang" autocomplete="off">
								<input type="submit" name="go" value="Lanjut" title="Buscar por Distrito" id="searchButtonLang" class="searchButtonLang">
							</div>
						</form>
						<div class="style_name text-center">
							<p>CONSTITUYENTES</p>
						</div>
					</div>
					<div class="header_search_area_container">
						<h3>Buscar por Nombre</h3>
						<form method="post" action="<?php echo site_url('search/candidate');?>" id="searchcandidateForm">
							<div id="simpleSearch">
								<input type="hidden" name="lang_id" id="lang_id_candidate" value="<?php echo $lang_id;?>">
								<input type="hidden" name="candidate_name" id="candidate_name" value="<?php echo $candidate;?>">
								<input type="search" name="search" placeholder="Ingresar Nombre" autocapitalize="sentences" value="<?php echo $candidate;?>"
								title="Buscar Candidatos [ctrl-option-f]" accesskey="f" id="searchcandidate" autocomplete="off">
								<input type="submit" name="go" value="Lanjut" title="Buscar por Nombre" id="searchButtoncandidate" class="searchButtoncandidate">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end header search area -->
	<!-- start filter language name -->
	<section id="filter_name">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="filter_name_container text-center">
						<p>CANDIDATOS - <span><?php echo $lang; ?></span></p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end filter language name -->

	<!-- start music list main area -->
	<section id="music_list_main_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="music_list_main_area_container" id="load_data">
						<?php $checkartist = ""; 
							foreach($candidates as $row) { 
								if ($checkartist !== "" && $checkartist !== $row->coalition) {
									$separate = ' separator-list'; 
								} else {
									$separate = "";
								}
								$checkartist = $row->coalition; ?>
						<a href="<?php echo base_url().'candidates/'.$row->id.'?lang='.rawurlencode($lang_id).'&candidate='.rawurlencode($candidate);?>">
							<div class="single_music_item<?php echo $separate; ?>">
								<div class="image_box">
									<?php $picture = $this->candidates_model->get_candidates_picture($row->id);?>
									<div class="swiper-container">
										<div class="swiper-wrapper">
											<?php if(!empty($picture)) { foreach($picture as $pic) { ?>
											<div class="swiper-slide">
												<img class="img-fluid" src="<?php if (strpos($pic->url_path, 'http') !== false) echo $pic->url_path; else echo base_url().'assets/img/'.$pic->url_path; ?>" alt="<?php echo $pic->pic_name; ?>">
											</div>
											<?php }} else { ?>
											<div class="swiper-slide">
											<img class="img-fluid" src="<?php echo base_url().'img/sinfoto.jpg';?>" alt="No Image">
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="content_box">
									<div class="candidate_name">
										<h4><?php echo $row->candidate; ?></h4>
									</div>
									<div class="geners">
										<ul>
											<li <?php if($row->color != "") { ?> 
											style="color:<?php echo $row->color; ?>" <?php } ?> >
											<?php echo $row->p_leaning; ?>
											</li>
										</ul>
									</div>
									<div class="candidate_details">
										<p><?php echo $row->coalition; ?> <span>(<?php echo $row->country; ?>)</span></p>
									</div>
									<div class="year_instoment">
										<ul>
											<li class="year_candidate"><?php echo $row->year; ?></li>
											<li class="instoment_candidate">&nbsp<?php echo $row->instrument; ?></li>
										</ul>
									</div>
									<div class="favorite_candidate">
										<input class="star" type="checkbox" title="bookmark page" <?php if ($this->session->userdata('logged_in')){ echo ($row->fav_status == 'active')?'checked':''; } ?> onclick="set_favorite(this,<?php echo $row->id;?>)">
									</div>
									<div class="candidate_main_language">
										<h4><?php echo $row->language; ?></h4>
									</div>
								</div>
							</div>
						</a>
						<?php } ?>
					</div>
					<?php if ($is_load == 'yes') { ?>
					<div id="load_data_message" style="text-align: center;margin-top: 1px;margin-bottom: 25px;">
						<a class='btn btn-loadmore' id="loadMore" onclick="load_more_candidates('todos',<?php echo $limit; ?>,<?php echo $start_limit; ?>);"><i class='fa fa-caret-down' aria-hidden='true'></i> Más candidatos...</a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
	<!-- end music list main area -->
