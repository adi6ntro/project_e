<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<section id="detail_candidate_area" style="
		padding: 10px 0px 0px 0px;
		background: #fff;">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="detail_candidate_area_container" style="padding: 13px 10px 0px;">
						<div class="single_music_item">
							<div class="image_box" id="swiper">
							<?php $picture = $this->candidates_model->get_candidates_picture($row->id);?>
								<div class="swiper-container swiper1" id="swiper">
									<div class="swiper-wrapper" id="swiper">
										<?php if(!empty($picture)) { foreach($picture as $pic) { ?>
										<div class="swiper-slide text-center" id="swiper">
											<img class="img-fluid pic-candidates-shadow" id="swiper" style="height: 209px;width: 209px;"
											src="<?php if (strpos($pic->url_path, 'http') !== false) echo $pic->url_path; else echo base_url().'assets/img/'.$pic->url_path; ?>" alt="<?php echo $pic->pic_name; ?>">
										</div>
										<?php }} else { ?>
										<div class="swiper-slide text-center" id="swiper">
											<img class="img-fluid pic-candidates-shadow" id="swiper" style="height: 209px;width: 209px;" 
											src="<?php echo base_url();?>assets/img/sinfoto.jpg" alt="No Image">
										</div>
										<?php } ?>
									</div>
									<div class="swiper-pagination" id="swiper" style="position: unset;margin-top: 3px;"></div>
									<div class="swiper-button-prev" id="swiper"></div>
									<div class="swiper-button-next" id="swiper"></div>
								</div>
							</div>
							<div class="content_box">
								<div class="candidate_name" style="
									text-align: center;
									margin-top: 7px;
									font-weight: 800;
									font-size: 20px
								">
									<?php echo $row->candidate; ?>
								</div>
								<div class="candidate_subname" style="
									text-align:center;
									margin-top: 2px;
									font-size:12px;
									color: #7E8083;
								">
									<?php echo $row->subname; ?>
								</div>								
								<div class="geners" style="
									text-align: center;
									margin-top: 3px;
									font-weight: 700;
									font-size: 12px;
								">
									<p <?php if($row->color != "") { ?> 
										style="color:<?php echo $row->color; ?>" <?php } ?> >
										<?php echo $row->p_leaning; ?>
									</p>
								</div>
								<div class="candidate_details" style="
									text-align: center;
									margin-top: 1px;
									font-size: 18px;
									font-weight: 300;
								">
									<?php echo $row->coalition; ?> 
									<span style="color: green;font-size:12px;font-weight:600;">&nbsp(<?php echo $row->country; ?>)</span>
								</div>
								<div class="year_instrument" style="
								
									justify-content: center;
									margin-top: 2px;
									font-size: 14px;
									font-weight: 600;
								">
									<div style="width: 100%;margin: 0 0px;font-size:14px;text-align:center;">
										<?php echo $row->year; ?>
					
									<?php if ($row->instrument != ""){ ?>

									<span style="color: orange;font-size: 12px;width: 100%;margin: 0 10px;">
										<?php echo $row->instrument; ?></span>
								
									<?php } ?>
								</div>
								<div class="candidate_main_language_2" style=" 										
									
									justify-content: center;
									margin-top: 2px;
									font-size: 16px;
									font-weight: 600;
								">

									<div style="width: 100%;margin: 0 0px;text-align: center;">
										<?php echo $row->language_name; ?>									
									<span style="font-size: 12px;font-weight: 400;width: 100%;margin: 0 5px;align-self: center;">
										(<?php echo $row->language_quantity; ?>)</span>
									</div>																	
								</div>
								<div class="favorite_candidate" style="text-align: center;margin: -8px -2px 25px 0px;">
									<input class="star" type="checkbox" title="bookmark page" <?php if ($this->session->userdata('logged_in')){ echo ($row->fav_status == 'active')?'checked':''; } ?> onclick="set_favorite(this,<?php echo $row->id;?>)">
								</div>
								<div class="candidate_source" style="text-align: center;padding: 2px 20px 0px;border-top: 1px solid #dadada;">
									<div class="more_information" style="padding: 1px 0px 7px;font-size:9px">
										<p style="color: #9FA1A4;">MÁS INFORMACIÓN:</p>
									</div>
									<?php $source = $this->candidates_model->get_source($row->id);?>
									<?php foreach($source as $web) { ?>
									<a href="<?php echo $web->source_url; ?>" target="_blank"><img style="height: 40px;margin: 0px 3px 10px 3px;" src="<?php echo base_url().'assets/img/'.$web->picture; ?>"></a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end header search area -->
	<!-- start music list main area -->
	<section id="summary_area" style="padding: 0px 0px 10px 0px;background: #fff;">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="summary_area_container" style="padding: 0px 10px;">
						<?php if (isset($this->session->userdata('logged_in')['status']) 
						&& $this->session->userdata('logged_in')['status'] == 'special'){ ?>
						<div class="lyrics" id="lyricss" style="padding: 10px 20px;border-top: 1px solid #dadada;<?php echo ($row->lyrics == '')?'display:none;':'';?>">
							<div class="truncate" id="lyrics" <?php echo ($row->lyrics == '')?'style="display:none;"':'';?>><?php echo $row->lyrics; ?></div>
							<a onclick="readmore()" id="readmore" style="color: #0056b3;text-decoration: none;">Más...</a>
							
							<textarea name="lyrics" id="lyricseditor" cols="30" rows="10" style="display:none;width:100%">
							<?php echo $row->lyrics; ?></textarea>
							<br>
						</div>

						<div class="source_lyricss" id="source_lyricss" style="padding: 5px 20px;
							<?php echo ($row->source_url_lyrics == '' || $row->source_name_lyrics == '')?'display:none;':'';?>">
							<a href="<?php echo $row->source_url_lyrics; ?>" id="source_lyrics"
							style="color: #0056b3;text-decoration: none;font-weight:700;font-size:16px"
							<?php echo ($row->source_url_lyrics == '' || $row->source_name_lyrics == '')?'display:none;':'';?>>
							<?php echo $row->source_name_lyrics; ?></a>
							
							<input type="text" class="form-control ck-editor" name="source_url_lyrics" style="display:none;"
							placeholder="https://yourdomain.com" id="source_url" value="<?php echo $row->source_url_lyrics; ?>">
							<input type="text" class="form-control ck-editor" name="source_name_lyrics" style="display:none;"
							placeholder="yourdomain" id="source_name" value="<?php echo $row->source_name_lyrics; ?>">
						</div>

						<div class="infos" id="infos" style="padding: 0px 20px;border-top: 1px solid #dadada;<?php echo ($row->info == '')?'display:none;':'';?>">
							<div id="info" <?php echo ($row->info == '')?'style="display:none;"':'';?>><?php echo $row->info; ?></div>
							<textarea name="info" id="infoeditor" cols="30" rows="3" style="display:none;width:100%">
							<?php echo $row->info; ?></textarea>
						</div>

						<div class="text-center">
							<a class="btn btn-notes" onclick="updatelyrics()" style="color: #0056b3;
							background-color: white;border: 1px solid #0056b3;padding: 3px 18px 0px;" id="updatelyrics">
							EDITAR</a>
							<a class="btn btn-notes" onclick="savelyrics()" style="display:none;color: #0056b3;
							background-color: white;border: 1px solid #0056b3;padding: 3px 18px 0px;" id="savelyrics">GUARDAR</a>
						</div>
						<?php } else { ?>
						<div class="lyrics" id="lyricss" style="padding: 10px 20px;border-top: 1px solid #dadada;<?php echo ($row->lyrics == '')?'display:none;':'';?>">
							<div class="truncate" id="lyrics" <?php echo ($row->lyrics == '')?'style="display:none;"':'';?>><?php echo $row->lyrics; ?></div>
							<a onclick="readmore()" id="readmore" style="color: #0056b3;text-decoration: none;">Más...</a>
							<br>
						</div>
						<div class="source_lyricss" id="source_lyricss" style="padding: 5px 20px;
							<?php echo ($row->source_url_lyrics == '' || $row->source_name_lyrics == '')?'display:none;':'';?>">
							<a href="<?php echo $row->source_url_lyrics; ?>" id="source_lyrics"
							style="color: #0056b3;text-decoration: none;font-weight:700;font-size:16px"
							<?php echo ($row->source_url_lyrics == '' || $row->source_name_lyrics == '')?'display:none;':'';?>>
							<?php echo $row->source_name_lyrics; ?></a>
						</div>
						<div class="infos" id="infos" style="padding: 0px 20px;border-top: 1px solid white;<?php echo ($row->info == '')?'display:none;':'';?>">
							<div id="info" <?php echo ($row->info == '')?'style="display:none;"':'';?>><?php echo $row->info; ?></div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="filter_name">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="filter_name_container text-center">
						<p>NOTAS</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="notes_area" style="padding: 10px 0px 0px 0px;background: #fff;">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="notes_area_container" style="padding: 0px 20px 10px;">
						<?php if ($this->session->userdata('logged_in')){ ?>
						<div class="notes" id="notes" style="padding: 0px 10px 9px;<?php echo ($row->note == '')?'display:none;':'';?>">
							<div id="note" <?php echo ($row->note == '')?'style="display:none;"':'';?>>
							<?php echo $row->note; ?></div>
							<!-- <div id="note"></div> -->
							<textarea name="note" id="noteeditor" cols="30" rows="10" style="display:none;width:100%">
							<?php echo $row->note; ?></textarea>
							<br>
						</div>
						<div class="text-center">
							<a class="btn btn-notes" onclick="updatenotes()" style="color: #0056b3;
							background-color: white;border: 1px solid #0056b3;padding: 3px 18px 0px;" id="updatenotes">
							<?php echo ($row->note == '')?'CREAR':'EDITAR';?></a>
							<a class="btn btn-notes" onclick="savenotes()" style="display:none;color: #0056b3;
							background-color: white;border: 1px solid #0056b3;padding: 3px 18px 0px;" id="savenotes">GUARDAR</a>
						</div>
						<?php } else { ?>
						<div class="text-center">
							<a class="btn btn-notes" href="<?php echo base_url().'signup/createnote';?>" style="color: #0056b3;
							background-color: white;border: 1px solid #0056b3;padding: 3px 18px 0px;">CREAR</a>
						</div>
						<?php } ?>
						<div class="more_information" style="text-align: center;padding: 4px 0px 0px;font-size:10px">
							<p style="color: #9FA1A4;">Estas notas son personales. Sólo son visibles para quien posee la cuenta.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="filter_name">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="filter_name_container text-center">
						<p>COMENTARIOS</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="comments_area" style="padding: 10px 0px 0px 0px;background: #fff;">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="comments_area_container" style="padding: 0px 20px 10px;">
						<?php if ($this->session->userdata('logged_in')){ ?>
						<div class="comments" id="comments" style="display:none">
							<h3>Post Comments</h3>
							<div id="comments__editor"></div>
							<div class="comments__controls">
								<span class="comments__words"></span>
								<svg class="comments__chart" viewbox="0 0 40 40" width="40" height="40" xmlns="http://www.w3.org/2000/svg">
									<circle stroke="hsl(0, 0%, 93%)" stroke-width="3" fill="none" cx="20" cy="20" r="17" />
									<circle class="comments__chart__circle" stroke="hsl(202, 92%, 59%)" stroke-width="3" stroke-dasharray="134,534" stroke-linecap="round" fill="none" cx="20" cy="20" r="17" />
									<text class="comments__chart__characters" x="50%" y="50%" dominant-baseline="central" text-anchor="middle"></text>
								</svg>
								<button type="button" onclick="savecomments()" id="savecomments" class="btn comments__send">Send Comments</button>
							</div>
						</div>
						<div class="text-center">
							<a class="btn btn-notes" onclick="updatecomments()" style="color: #0056b3;
							background-color: white;border: 1px solid #0056b3;padding: 3px 18px 0px;" id="updatecomments">Crear Nuevo</a>
						</div>
						<?php } else { ?>
						<div class="text-center">
							<a class="btn btn-notes" href="<?php echo base_url().'signup/createcomment';?>" style="color: #0056b3;
							background-color: white;border: 1px solid #0056b3;padding: 3px 18px 0px;">Crear Nuevo</a>
						</div>
						<?php } ?>
						<div class="comments_list" id="load_comments">
							<?php if (count($comments) > 0) { foreach($comments as $row) { ?>
							<div class="the-comments" style="margin-bottom:5px">
								<div class="row" style="margin-bottom:5px">
									<div class="col-8" style="padding: unset;font-weight: 700;">
										<?php echo $row->username; ?>
									</div>
									<div class="col-4" style="padding: unset;color: grey;text-align:right;">
									<?php echo $row->cdate; ?>
									</div>
								</div>
								<div class="comment">
								<?php echo $row->comments; ?>
								</div>
								<div class="like-comment" style="text-align: right;position: relative;bottom: 10px;">
									<label for="like_comment" id="like_label" style="margin: 0 5px;vertical-align: middle;color: grey;">
										<input class="star" type="checkbox" id="like_comment" 
										title="bookmark comments" <?php if ($this->session->userdata('logged_in')){ echo ($row->like_status == 'active')?'checked':''; } ?> 
										onclick="set_like(this,<?php echo $row->id;?>)"><span><?php echo $row->likes; ?></span>
									</label>
								</div>
							</div>
							<?php }} else { ?>
							<div class="the-comments text-center no-comment">
							No hay más commentarios en esta lista.
							</div>
							<?php } ?>
						</div>
						<?php if ($is_load_comment == 'yes') { ?>
						<div id="load_data_comments" style="margin-bottom: 20px;">
							<a style="color: #05386B;" id="loadMoreComments" onclick="load_more_comments(<?php echo $limit_comment; ?>,<?php echo $start_limit_comment; ?>);">Más commentarios...</a>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end music list main area -->
	<section id="filter_name">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="filter_name_container text-center" style="padding:6px 10px 3px;">
						<p style="font-size:12px">OTROS CANDIDATOS DE LA LISTA <?php echo ($lang == '')?'':'EN EL '.strtoupper($lang); ?></p>
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
						<?php if (count($candidates) > 0) { $checkartist = ""; 
							foreach($candidates as $row) { 
								if ($checkartist !== "" && $checkartist !== $row->coalition) {
									$separate = ' separator-list'; 
								} else {
									$separate = "";
								}
								$checkartist = $row->coalition;?>
						<a href="<?php echo base_url().'candidates/'.$row->id.'?lang='.rawurlencode($lang_id).'&candidate=coalition';?>">
							<div class="single_music_item<?php echo $separate; ?>">
								<div class="image_box">
									<?php $picture = $this->candidates_model->get_candidates_picture($row->id);?>
									<div class="swiper-container swiper2">
										<div class="swiper-wrapper swiper-wrapper-custom">
											<?php if(!empty($picture)) { foreach($picture as $pic) { ?>
											<div class="swiper-slide">
												<img class="img-fluid" src="<?php if (strpos($pic->url_path, 'http') !== false) echo $pic->url_path; else echo base_url().'assets/img/'.$pic->url_path; ?>" alt="<?php echo $pic->pic_name; ?>">
											</div>
											<?php }} else { ?>
											<div class="swiper-slide">
												<img class="img-fluid" src="<?php echo base_url();?>assets/img/sinfoto.jpg" alt="No Image">
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
											<li class="instoment_candidate"><?php echo $row->instrument; ?></li>
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
						<?php }} else { ?>
							<div class="single_music_item justify-content-center text-center">
							No hay más candidatos en esta lista.
							</div>
						<?php } ?>
					</div>
					<?php if ($is_load == 'yes') { ?>
					<div id="load_data_message" style="text-align: center;margin-bottom: 20px;">
						<a class='btn btn-loadmore' id="loadMore" onclick="load_more_candidates('coalition',<?php echo $limit; ?>,<?php echo $start_limit; ?>);"><i class='fa fa-caret-down' aria-hidden='true'></i> Más candidatos...</a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
	<!-- end music list main area -->
	<section id="filter_name">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="filter_name_container text-center" style="padding:6px 10px 3px;">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="music_list_main_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto py-4">
					<div class="text-center mb-2 mx-5">
						<a href="<?php echo ($next == 0)?"javascript:void(0)":base_url().'candidates/'.$next.'?lang='.rawurlencode($lang_id).'&candidate='.rawurlencode($candidate); ?>" class="btn btn-direction-candidate">SIGUIENTE</a>
						</div>
						<div class="text-center mb-2 mx-5">
						<a href="<?php echo ($prev == 0)?"javascript:void(0)":base_url().'candidates/'.$prev.'?lang='.rawurlencode($lang_id).'&candidate='.rawurlencode($candidate); ?>" class="btn btn-direction-candidate">ANTERIOR</a>
						</div>
						<div class="text-center mb-2 mx-5">
						<a href="<?php echo base_url(); ?>" class="btn btn-direction-candidate">INICIO - BUSCAR</a>
					</div>
				</div>
			</div>
		</div>
	</section>
