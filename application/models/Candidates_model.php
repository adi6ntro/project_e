<?php
class candidates_model extends CI_Model

{
    public function __construct()
    {
		parent::__construct();
    }

	public  function get_all_candidates($limit=null,$offset=0)
    {
		$this->db->distinct();
		$fav_status = ($this->session->userdata('logged_in'))?',fav_status':'';
		$this->db->select('candidates.id,candidate,candidates.coalition,p_leaning,p_leaning.color,language,country,country.name as country_name,year,style,instrument,language.name as language_name'.$fav_status);
		$this->db->from('candidates');
		$this->db->join('coalition', 'candidates.coalition = coalition.coalition');
		$this->db->join('p_leaning', 'candidates.p_leaning = p_leaning.name');
		$this->db->join('country', 'coalition.country = country.id');
		$this->db->join('language', 'language.id = candidates.language');
		if ($this->session->userdata('logged_in')) {
			$this->db->join('favorite', "candidates_id = candidates.id and user_id = ".$this->session->userdata('logged_in')['id'], 'left');
		}
		$this->db->order_by('candidates.seq_order', 'ASC');
		if($limit != null)
			$this->db->limit($limit, $offset);
		$query=$this->db->get();

		return $query->result();
    }

    public function get_by_id($table,$column,$id,$type=null)
    {
		$this->db->from($table);
		if ($type == 'like') {
			$this->db->like($column,$id);
		} else {
			$this->db->where($column,$id);
		}
		$query=$this->db->get();

		return $query->row();
	}

	public function get_by_param($arr_where,$limit=null,$offset=0,$type=null)
    {
		if ($this->session->userdata('logged_in')) {
			$fav_status = ",fav_status";
			$fav_join = " left join favorite on candidates_id = candidates.id and user_id = ".$this->session->userdata('logged_in')['id'];
		} else {
			$fav_status = "";
			$fav_join = "";
		}

		$data = explode("|",$type);

		if ($data[0] == 'like') {
			$where = "";
			if($limit != null) $limit+=1; 
			if (isset($arr_where[$data[1]]) && $arr_where[$data[1]]!=""){
				$where .= " and ".$data[1]." like '%".$arr_where[$data[1]]."%'";
				unset($arr_where[$data[1]]);
			}
			foreach ($arr_where as $key => $value) {
				$where .= " and $key = '$value'";
			}
			if ($limit != null){
				if ($offset>0) {
					$qlimit = "LIMIT $offset, $limit";
				} else {
					$qlimit = "LIMIT $limit";
				}
			} else {
				$qlimit = "";
			}
			$query = $this->db->query("select distinct 
			candidates.id,candidate,candidates.coalition,p_leaning,p_leaning.color,language,country,country.name as country_name,
			year,style,instrument,language.name as language_name$fav_status from candidates
			join coalition on candidates.coalition = coalition.coalition
			join p_leaning on candidates.p_leaning = p_leaning.name
			join country on coalition.country = country.id
			join language on language.id = candidates.language$fav_join
			where 1=1$where
			order by candidates.seq_order $qlimit");
		} else {
			$this->db->distinct();
			$this->db->select('candidates.id,candidate,candidates.coalition,p_leaning,p_leaning.color,language,
			country,country.name as country_name,year,style,instrument,language.name as language_name'.$fav_status);
			$this->db->from('candidates');
			$this->db->join('coalition', 'candidates.coalition = coalition.coalition');
			$this->db->join('p_leaning', 'candidates.p_leaning = p_leaning.name');
			$this->db->join('country', 'coalition.country = country.id');
			$this->db->join('language', 'language.id = candidates.language');
			if ($this->session->userdata('logged_in')) {
				$this->db->join('favorite', 'candidates_id = candidates.id and user_id = '.$this->session->userdata('logged_in')['id'], 'left');
			}
			$this->db->where($arr_where);
			$this->db->order_by('candidates.seq_order', 'ASC');
			if($limit != null)
				$this->db->limit($limit, $offset);
			$query=$this->db->get();
		}
		return $query->result();
	}

	public function get_candidates($id)
    {
		$fav_status = ($this->session->userdata('logged_in'))?',fav_status,note':'';
		$this->db->select('candidates.id,candidate,candidates.coalition,p_leaning,p_leaning.color,language,country,
		country.name as country_name,year,style,instrument,language.name as language_name,candidates.info,
		lyrics,source_name_lyrics,source_url_lyrics,subname,language.quantity as language_quantity'.$fav_status);
		$this->db->from('candidates');
		$this->db->join('coalition', 'candidates.coalition = coalition.coalition');
		$this->db->join('p_leaning', 'candidates.p_leaning = p_leaning.name');
		$this->db->join('country', 'coalition.country = country.id');
		$this->db->join('language', 'language.id = candidates.language');
		if ($this->session->userdata('logged_in')) {
			$this->db->join('favorite', 'favorite.candidates_id = candidates.id and favorite.user_id = '.$this->session->userdata('logged_in')['id'], 'left');
			$this->db->join('notes', 'notes.candidates_id = candidates.id and notes.user_id = '.$this->session->userdata('logged_in')['id'], 'left');
		}
		$this->db->where('candidates.id',$id);
		$query=$this->db->get();

		return $query->row();
	}

	public function get_favorite($limit=null,$offset=0)
    {
		$this->db->distinct();
		$this->db->select('candidates.id,candidate,candidates.coalition,p_leaning,p_leaning.color,language,country,country.name as country_name,year,style,instrument,language.name as language_name,fav_status');
		$this->db->from('candidates');
		$this->db->join('coalition', 'candidates.coalition = coalition.coalition');
		$this->db->join('p_leaning', 'candidates.p_leaning = p_leaning.name');
		$this->db->join('country', 'coalition.country = country.id');
		$this->db->join('language', 'language.id = candidates.language');
		$this->db->join('favorite', "candidates_id = candidates.id and user_id = ".$this->session->userdata('logged_in')['id']." and fav_status='active'");
		$this->db->order_by('fav_date', 'DESC');
		if($limit != null)
			$this->db->limit($limit, $offset);
		$query=$this->db->get();

		return $query->result();
	}

	function update_favorite($candidates_id,$fav_status){
		$array = array(
			'user_id' => $this->session->userdata('logged_in')['id'], 
			'candidates_id' => $candidates_id
		);
		$this->db->where($array);
		$query=$this->db->get('favorite');
		if($query->num_rows()==0){
			$insert_data = array(
				'user_id' => $this->session->userdata('logged_in')['id'],
				'candidates_id' => $candidates_id,
				'fav_status' => ($fav_status === 'true')?'active':'inactive'
			);
			$this->db->insert('favorite',$insert_data);
		} else {
			$insert_data = array(
				'fav_status' => ($fav_status === 'true')?'active':'inactive'
			);
			$this->db->where($array);
			$this->db->update('favorite', $insert_data);
		}
		return 'yes';
	}

	public function get_comments($id,$limit=null,$offset=0)
    {
		$like_status = ($this->session->userdata('logged_in'))?',like_status':'';
		$this->db->select("id,username,comments,likes,DATE_FORMAT(created_date, '%d-%b-%Y %H:%i') as cdate".$like_status);
		$this->db->from('comments');
		if ($this->session->userdata('logged_in')) {
			$this->db->join('comments_like', 'comments_id = comments.id and comments_like.user_id = '.$this->session->userdata('logged_in')['id'], 'left');
		}
		$this->db->where(array('state'=>'active','candidates_id'=>$id));
		$this->db->order_by('created_date', 'DESC');
		if($limit != null)
			$this->db->limit($limit, $offset);
		$query=$this->db->get();

		return $query->result();
	}

	function update_comments($type,$comments) {
		if (!is_array($comments)) {
			return false;
		}
		if ($type == 'likes') {
			$array = array(
				'id' => $comments['comments_id']
			);
			$this->db->where($array);
			$query=$this->db->get('comments');
			if($query->num_rows()>0){
				$row = $query->row();
				$array2 = array(
					'user_id' => $this->session->userdata('logged_in')['id'], 
					'comments_id' => $comments['comments_id']
				);
				$this->db->where($array2);
				$query2=$this->db->get('comments_like');
				if($query2->num_rows()==0){
					$insert_data = array(
						'user_id' => $this->session->userdata('logged_in')['id'],
						'comments_id' => $comments['comments_id'],
						'like_status' => ($comments['like'] === 'true')?'active':'inactive'
					);
					$this->db->insert('comments_like',$insert_data);
				} else {
					$insert_data = array(
						'like_status' => ($comments['like'] === 'true')?'active':'inactive'
					);
					$this->db->where($array2);
					$this->db->update('comments_like', $insert_data);
				}
				$insert_data = array(
					'likes' => ($comments['like'] === 'true')?++$row->likes:--$row->likes
				);
				$this->db->where($array);
				$this->db->update('comments', $insert_data);
			}
			return $insert_data['likes'];
		} else if ($type == 'new_comment') {
			$insert_data = array(
				'user_id' => $this->session->userdata('logged_in')['id'],
				'username' => $this->session->userdata('logged_in')['username'],
				'candidates_id' => $comments['candidates_id'],
				'comments' => $comments['comments']
			);
			$this->db->insert('comments',$insert_data);
			return json_encode(array(
				'username' => $this->session->userdata('logged_in')['username'],
				'cdate' => date('d-M-Y H:i'),
				'comments_id' => $this->db->insert_id()
			));
		}
		return false;
	}

	function update_note($candidates_id,$note){
		$array = array(
			'user_id' => $this->session->userdata('logged_in')['id'], 
			'candidates_id' => $candidates_id
		);
		$this->db->where($array);
		$query=$this->db->get('notes');
		if($query->num_rows()==0){
			$insert_data = array(
				'user_id' => $this->session->userdata('logged_in')['id'],
				'candidates_id' => $candidates_id,
				'note' => $note
			);
			$this->db->insert('notes',$insert_data);
		} else {
			$insert_data = array(
				'note' => $note
			);
			$this->db->where($array);
			$this->db->update('notes', $insert_data);
		}
		return 'yes';
	}

	function update_lyrics($candidates_id,$lyrics,$info,$source_url,$source_name){
		$array = array(
			'id' => $candidates_id
		);
		$this->db->where($array);
		$query=$this->db->get('candidates');
		$insert_data = array(
			'lyrics' => $lyrics,
			'info' => $info,
			'source_url_lyrics' => $source_url,
			'source_name_lyrics' => $source_name
		);
		$this->db->where($array);
		$this->db->update('candidates', $insert_data);
		return 'yes';
	}

	function search_language($title,$sess){
		$query = $this->db->query("select id,name from language where name like '%$title%' limit 5");
		if ($sess != "") {
			$query = $this->db->query("select candidates.id,name from candidates join language on language.id=candidates.language
			where language.name like '%$title%' and candidates.candidate = ".$this->db->escape($sess)." limit 5");
		}
		return $query->result();
    }

	function search_candidate($title,$sess){
		$qsess = "";
		if ($sess != "")
			$qsess = " and language.id = ".$this->db->escape($sess);
		$query = $this->db->query("select candidates.id,candidate as name from candidates join language on language.id=candidates.language
		where candidate like '%$title%'".$qsess." limit 5");
		return $query->result();
    }

	function get_direction_candidate($id,$lang,$candidate,$dir){
		$where = "";
		$join = "";
		$row = $this->get_by_id('candidates','id',$id);
		if ($lang != '')
			$where .= " and language=".$this->db->escape($lang);
		if ($candidate != ''){
			if ($candidate == 'selected')
				$join .= " join favorite on candidates_id = candidates.id and user_id = ".$this->session->userdata('logged_in')['id']." and fav_status='active'";
			if ($candidate == 'coalition'){
				$where .= " and candidates.coalition = ".$this->db->escape($row->coalition);
			}
		}
		if ($dir == 'next') {
			$where .= " and candidates.seq_order > ".$row->seq_order;
			$order = "asc";
		} else if ($dir == 'prev') {
			$where .= " and candidates.seq_order < ".$row->seq_order;
			$order = "desc";
		} else {
			return 0;
		}
		if ($this->session->userdata('logged_in')) {
			$fav_status = ",fav_status";
			if ($candidate != 'selected')
				$join .= " left join favorite on candidates_id = candidates.id and user_id = ".$this->session->userdata('logged_in')['id'];
		}
		$query = $this->db->query("select distinct candidates.id,candidates.seq_order from candidates
		join coalition on candidates.coalition = coalition.coalition
		join p_leaning on candidates.p_leaning = p_leaning.name
		join country on coalition.country = country.id
		join language on language.id = candidates.language$join
		where 1=1$where order by candidates.seq_order $order limit 1");
		// print_r($this->db->last_query());
		return ($query->num_rows() == 0)?0:$query->row()->id;
    }

	public function get_candidates_picture($id)
    {
		$this->db->where('candidates_id',$id);
		$this->db->order_by('id', 'ASC');
		$query=$this->db->get('picture');

		return $query->result();
    }

	public function get_source($id)
    {
		$this->db->select('candidates_source_external.source_name,source_url,picture');
		$this->db->join('source_external', 'candidates_source_external.source_name = source_external.source_name');
		$this->db->where('candidates_id',$id);
		$this->db->order_by('seq_order', 'ASC');
		$query=$this->db->get('candidates_source_external');

		return $query->result();
    }
}

?>
