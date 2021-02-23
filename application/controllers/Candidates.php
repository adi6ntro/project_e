<?php defined('BASEPATH') OR exit('No direct script access allowed');

class candidates extends CI_Controller {

	var $limit;
	public function __construct()
	{
		parent::__construct();
		$this->limit = 10;
		// $this->limit2 = 2;
	}

	public function detail($id)
	{
		if ($this->input->get('candidate') == 'selected' && !$this->session->userdata('logged_in')){
			redirect('/', 'refresh');
		}

		$data['row'] = $this->candidates_model->get_candidates($id);
		$lang = rawurldecode($this->input->get('lang'));
		$candidate = rawurldecode($this->input->get('candidate'));

		$arr_where = array('candidates.coalition'=>$data['row']->coalition, 'candidates.id <>'=>$id);
		if ($lang != '')
			$arr_where['language'] = $lang;
		$data['candidates']=$this->candidates_model->get_by_param($arr_where,$this->limit);
		$data['comments']=$this->candidates_model->get_comments($id,2);
		// $data['is_load']=(count($data['candidates']) <= $this->limit)?'no':'yes';
		$data['is_load']='no';
		$data['is_load_comment']=(count($data['comments']) < 2)?'no':'yes';
		$data['start_limit_comment']=3;
		$data['limit_comment']=3;
		$data['next']=$this->candidates_model->get_direction_candidate($id,$lang,$candidate,'next');
		$data['prev']=$this->candidates_model->get_direction_candidate($id,$lang,$candidate,'prev');
		$data['lang_id']=$lang;
		$data['lang']=($lang == '')?'':$this->candidates_model->get_by_id('language','id',$lang)->name;
		$data['candidate']=$candidate;
		$data['coalition']=$data['row']->coalition;

		$this->load->view('header',$data);
		$this->load->view('candidate_view',$data);
		$this->load->view('footer',$data);
	}

	public function language($id)
	{
		$data['language']=$this->candidates_model->get_language(array('id'=>$id));
		$data['candidates']=$this->candidates_model->get_by_param(array('language'=>$id),$this->limit);
		$data['is_load']=(count($data['candidates']) < $this->limit)?'no':'yes';
		$data['candidate']="";
		$data['lang_id']="";
		$data['lang']="";
		$data['coalition']="";
		$data['start_limit']=$this->limit;
		$data['limit']=$this->limit;
		$this->load->view('header',$data);
		$this->load->view('home_view',$data);
		$this->load->view('footer',$data);
	}

	public function selected_save() {
		if (!$this->session->userdata('logged_in')) {
			echo false;
		} else {
			$rr = $this->candidates_model->update_favorite($this->db->escape_str($this->input->post('candidatesid')),$this->db->escape_str($this->input->post('favorite')));
			// $this->session->set_flashdata('result', $rr);
			echo $rr;
		}
	}

	public function savenote() {
		if (!$this->session->userdata('logged_in')) {
			echo false;
		} else {
			$rr = $this->candidates_model->update_note($this->db->escape_str($this->input->post('candidate_id')),$this->db->escape_str($this->input->post('note')));
			// $this->session->set_flashdata('result', $rr);
			echo $rr;
		}
	}

	public function savelyrics() {
		if (!$this->session->userdata('logged_in') && $this->session->userdata('logged_in')['status'] != "special") {
			echo false;
		} else {
			// print_r($_POST);
			$rr = $this->candidates_model->update_lyrics($this->db->escape_str($this->input->post('candidate_id')),
			$this->db->escape_str($this->input->post('lyrics')),$this->db->escape_str($this->input->post('info')),
			$this->db->escape_str($this->input->post('source_url')),$this->db->escape_str($this->input->post('source_name')));
			echo $rr;
		}
	}

	public function like_comments() {
		if (!$this->session->userdata('logged_in')) {
			echo false;
		} else {
			$array = array(
				'comments_id' => $this->db->escape_str($this->input->post('comments_id')),
				'like' => $this->db->escape_str($this->input->post('like')),
			);
			$rr = $this->candidates_model->update_comments('likes',$array);
			echo $rr;
		}
	}

	public function savecomments() {
		if (!$this->session->userdata('logged_in')) {
			echo false;
		} else {
			$array = array(
				'candidates_id' => $this->db->escape_str($this->input->post('candidate_id')),
				'comments' => $this->db->escape_str($this->input->post('comments'))
			);
			$rr = $this->candidates_model->update_comments('new_comment',$array);
			echo $rr;
		}
	}

	public function selected() {
		if (!$this->session->userdata('logged_in')) {
			redirect('login', 'refresh');
		}
		$data['candidates']=$this->candidates_model->get_favorite($this->limit);
		$data['is_load']=(count($data['candidates']) < $this->limit)?'no':'yes';
		$data['lang']="TODOS";
		$data['lang_id']="";
		$data['candidate']="selected";
		$data['coalition']="";
		$data['start_limit']=$this->limit;
		$data['limit']=$this->limit;
		$this->load->view('header',$data);
		$this->load->view('selected_view',$data);
		$this->load->view('footer',$data);
	}

	public function morecomments()
	{
		if(isset($_POST["limit"], $_POST["start"], $_POST["candidate"]))
		{
			$arr = array();
			$results = array();
			$limit = $this->db->escape_str($this->input->post('limit')+1);
			$start = $this->db->escape_str($this->input->post('start'));
			$id = $this->db->escape_str($this->input->post('candidate'));
			$comments=$this->candidates_model->get_comments($id,$limit,$start);
			$return = "";
			$count_limit = 0;
			$is_load = (count($comments) <= $this->input->post('limit')) ? 'no':'yes';
			foreach($comments as $row) {
				$checked = '';
				if ($this->session->userdata('logged_in'))
					$checked = ($row->like_status == 'active')?'checked':'';

				$return .= '<div class="the-comments" style="margin-bottom:5px">
						<div class="row" style="margin-bottom:5px">
							<div class="col-8" style="padding: unset;font-weight: 700;">'.$row->username.'
							</div>
							<div class="col-4" style="padding: unset;color: grey;text-align:right;">'.$row->cdate.'
							</div>
						</div>
						<div class="comment">'.$row->comments.'</div>
						<div class="like-comment" style="text-align: right;position: relative;bottom: 10px;">
							<label for="flexCheckDefault" style="margin: 0 5px;vertical-align: middle;color: grey;">
								<input class="star" type="checkbox" id="flexCheckDefault" 
								title="bookmark comments" '.$checked.'
								onclick="set_like(this,'.$row->id.')">0
							</label>
						</div>
					</div>';
				if (++$count_limit == $this->input->post('limit')) break;
			}
			echo $is_load.'|'.$return.'|'.count($comments).'|'.$this->input->post('limit');
		}
	}
}

