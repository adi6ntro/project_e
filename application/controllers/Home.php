<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	var $limit;
	public function __construct()
	{
		parent::__construct();
		$this->limit = 10;
	}

	public function index()
	{
		$data['candidates']=$this->candidates_model->get_all_candidates($this->limit);
		$data['is_load']=(count($data['candidates']) < $this->limit)?'no':'yes';
		$data['lang']="TODOS";
		$data['candidate']="";
		$data['language']=array();
		$data['lang_id']="";
		$data['coalition']="";
		$data['start_limit']=$this->limit;
		$data['limit']=$this->limit;
		$this->load->view('header',$data);
		$this->load->view('home_view',$data);
		$this->load->view('footer',$data);
	}

	public function example()
	{
		$this->load->view('example_view');
	}

	function get_autocomplete($type){
        if (isset($_POST['term'])) {
			$term = $this->db->escape_str(trim(str_replace(" ","%",preg_replace('/\s\s+/', ' ', $this->input->post('term')))));
			$results = array();
			preg_match_all('/./u', $term, $results);
			$term = implode('%',$results[0]);

			if($type == 'language')
				$result = $this->candidates_model->search_language($term,$this->input->post('candidate'));
			elseif($type == 'candidate')
				$result = $this->candidates_model->search_candidate($term,$this->input->post('lang_id'));
			else
				$result = array();
			if (count($result) > 0) {
				foreach ($result as $row) {
					$arr_result[] = array(
						"value"=>$row->name, "id"=>$row->id, "name"=>$row->name
					);
				}
				echo json_encode($arr_result);
			}
        }
	}

	public function search($type)
	{
		if ($type != 'language' && $type != 'candidate')
			redirect('/', 'refresh');
		if ($type == 'language')
			if(!isset($_POST['lang_id']))
				redirect('/', 'refresh');
		if ($type == 'candidate')
			if (!isset($_POST['candidate_name']))
				redirect('/', 'refresh');
		$term = $this->db->escape_str(trim(str_replace(" ","%",preg_replace('/\s\s+/', ' ', $this->input->post('search')))));
		$results = array();
		$arr_where = array();
		$like = null;

		if ($type == 'language') {
			if (empty($_POST['lang_id'])) {
				$lang = $term;
				$data['lang']=filter_var($term, FILTER_SANITIZE_STRING);
				$data['lang_id']=filter_var($term, FILTER_SANITIZE_STRING);
				$type='language.name';
			} else if ($this->input->post('search') == "") {
				$data['lang']='TODOS';
				$data['lang_id']='';
			} else {
				$lang = $this->input->post('lang_id');
				$data['lang']=filter_var($this->candidates_model->get_by_id('language','id',$this->input->post('lang_id'))->name, FILTER_SANITIZE_STRING);
				$data['lang_id']=filter_var($this->input->post('lang_id'), FILTER_SANITIZE_STRING);
			}
			if ($this->input->post('search') != "")
				$arr_where[$type] = $lang;
			if ($this->input->post('candidate_name') != ""){
				$arr_where['candidates.candidate'] = $this->input->post('candidate_name');
				$data['candidate'] = filter_var($this->input->post('candidate_name'), FILTER_SANITIZE_STRING);
			} else {
				$data['candidate'] = "";
			}
		} else if ($type == 'candidate') {
			if (empty($_POST['candidate_name'])) {
				$data['candidate']=filter_var($term, FILTER_SANITIZE_STRING);
				preg_match_all('/./u', $term, $results);
				$candidate = implode('%',$results[0]);
				$like = 'like|candidate';
			} else if ($this->input->post('search') == "") {
				$data['candidate']="";
			} else {
				$candidate = $this->input->post('candidate_name');
				$data['candidate']=filter_var($this->input->post('candidate_name'), FILTER_SANITIZE_STRING);
			}
			if ($this->input->post('search') != "")
				$arr_where[$type] = $candidate;
			if ($this->input->post('lang_id') != ""){
				$arr_where['language'] = $this->input->post('lang_id');
				$data['lang_id']=filter_var($this->input->post('lang_id'), FILTER_SANITIZE_STRING);
				$data['lang']=filter_var($this->candidates_model->get_by_id('language','id',$this->input->post('lang_id'))->name, FILTER_SANITIZE_STRING);
			} else {
				$data['lang']='TODOS';
				$data['lang_id']='';
			}
		}
		// $_SESSION['candidate']=$data['candidate'];
		// $_SESSION['lang_id']=$data['lang_id'];
		if (count($arr_where) == 0) {
			$data['language']=array();
			$data['candidates']=$this->candidates_model->get_all_candidates($this->limit);
		} else {
			$data['language']=$this->candidates_model->get_language(array('name'=>$term),'like',$this->limit,0);
			$data['candidates']=$this->candidates_model->get_by_param($arr_where,$this->limit,0,$like);
		}

		if (count($data['language']) == 1) {
			redirect('/language/'.$data['language'][0]->id, 'refresh');
		}

		if (count($data['candidates']) == 1) {
			redirect('/candidates/'.$data['candidates'][0]->id, 'refresh');
		}
		$data['is_load']=(count($data['candidates']) < $this->limit)?'no':'yes';
		$data['start_limit']=$this->limit;
		$data['limit']=$this->limit;
		$data['coalition']="";
		// print_r($data);
		$this->load->view('header',$data);
		$this->load->view('home_view',$data);
		$this->load->view('footer',$data);
	}

	public function loadmore()
	{
		if(isset($_POST["limit"], $_POST["start"], $_POST["selected"], $_POST["candidate"], $_POST["lang"]))
		{
			$arr = array();
			$results = array();
			$limit = $this->input->post('limit')+1;
			if (in_array($this->input->post('selected'), array('selected','todos','coalition'))){
				if ($this->input->post('selected') == 'selected') {
					$candidates=$this->candidates_model->get_favorite($limit,$this->input->post('start'));
				} else if ($this->input->post('selected') == 'todos') {
					if ($this->input->post('lang') == '' && $this->input->post('candidate') == '') {
						$candidates = $this->candidates_model->get_all_candidates($limit,$this->input->post('start'));
					} else {
						if ($this->input->post('lang') != ''){
							$arr['language'] = $this->input->post('lang');
							$like = null;
						}
						if ($this->input->post('candidate') != '') {
							$term=filter_var($this->input->post('candidate'), FILTER_SANITIZE_STRING);
							preg_match_all('/./u', $term, $results);
							$arr['candidate'] = implode('%',$results[0]);
							$like = 'like|candidate';
						}
						$candidates = $this->candidates_model->get_by_param($arr,$limit,$this->input->post('start'),$like);
					}
				} else if ($this->input->post('selected') == 'coalition') {
					$arr['candidates.coalition'] = $this->input->post('candidate');
					if ($lang != '')
						$arr['language'] = $this->input->post('lang');
					$candidates = $this->candidates_model->get_by_param($arr,$limit,$this->input->post('start'));
				}
				$return = "";
				$count_limit = 0;
				$is_load = (count($candidates) <= $this->input->post('limit')) ? 'no':'yes';
				foreach($candidates as $row) {
					$picture = $this->candidates_model->get_candidates_picture($row->id);
					$list_picture = "";
					if(!empty($picture)) { 
						foreach($picture as $pic) {
							$list_picture .= '<div class="swiper-slide">';
							if (strpos($pic->url_path, 'http') !== false) 
								$list_picture .= '<img class="img-fluid" src="'.$pic->url_path.'" alt="'.$pic->pic_name.'">'; 
							else 
								$list_picture .= '<img class="img-fluid" src="'.base_url().'assets/img/'.$pic->url_path.'" alt="'.$pic->pic_name.'">'; 
							$list_picture .='</div>';
						}
					} else {
						$list_picture .= '<div class="swiper-slide">
						<img class="img-fluid" src="http:///project_e/assets/img/sinfoto.jpg" alt="No Image">
						</div>';
					}

					$color = ($row->color != "")?' style="color:'.$row->color.'"':"";
					$checked = '';
					if ($this->session->userdata('logged_in'))
						$checked = ($row->fav_status == 'active')?'checked':'';
					

					$return .= '<a href="'.base_url().'candidates/'.$row->id.'?lang='.rawurlencode($this->input->post('lang')).'&candidate='.rawurlencode($this->input->post('candidate')).'">
						<div class="single_music_item">
							<div class="image_box">
								<div class="swiper-container">
								<div class="swiper-wrapper">'.
								$list_picture.
								'</div></div>
							</div>
							<div class="content_box">
								<div class="candidate_name">
									<h4>'.$row->candidate.'</h4>
								</div>
								<div class="geners">
									<ul>
										<li'.$color.'>'.
										$row->p_leaning.
										'</li>
									</ul>
								</div>
								<div class="candidate_details">
									<p>'.$row->coalition.' <span>('.$row->country.')</span></p>
								</div>
								<div class="year_instoment">
									<ul>
										<li class="year_candidate">'.$row->year.'</li>
										<li class="instoment_candidate">'.$row->instrument.'</li>
									</ul>
								</div>
								<div class="favorite_candidate">
									<input class="star" type="checkbox" title="bookmark page" '.$checked.' onclick="set_favorite(this,'.$row->id.')">
								</div>
								<div class="candidate_main_language">
									<h4>'.$row->language.'</h4>
								</div>
							</div>
						</div>
					</a>';
					if (++$count_limit == $this->input->post('limit')) break;
				}
				echo $is_load.'|'.$return.'|'.count($candidates).'|'.$this->input->post('limit');
			} else {
				echo 'no';
			}
		}
	}
	function frequent_questions()
	{
		$data=[];
		$this->load->view('header',$data);
		$this->load->view('frequent_questions',$data);
		$this->load->view('footer',$data);
	}
	function contact_us()
	{
		$data=[];
		$this->load->view('header',$data);
		$this->load->view('contact_us',$data);
		$this->load->view('footer',$data);
	}
	function coming_soon()
	{
		$data=[];
		$this->load->view('header',$data);
		$this->load->view('coming_soon',$data);
		$this->load->view('footer',$data);
	}
	
}
