<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* description: 后台--标签管理
* author: zg
* date: 2013-07-07
*/

class Relation_tag extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
        //初始化父类成员变量
        //当前控制器名，用于view中复用
        $this->data['_class'] = Strtolower(__CLASS__);
		$this->load->model('admin/tag_model','tag');
	}

    //列表页
	//function showlist($obj_type='wiki',$obj_id=0)
	function showlist($name='')
	{
        $this->data['type'] = trim(addslashes($this->input->get('type')));
        $this->data['id'] = trim(addslashes($this->input->get('id')));
        $this->load->helper('form'); 
        //搜索
        $where = array();
        //搜内容segment(5)
        $name = urldecode(trim($this->uri->segment(4)));
        $this->data['name'] = 0;
        if($name)  
        {
            $this->data['name'] = urldecode(trim(addslashes($name))); 
            $where['name'] = $this->data['name']; 
        }
		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url('admin/tag/showlist/'.$this->data['name'].'/');
		//每页
		$config['per_page'] = $this->data['pagesize'] = 15 ; 
		//总数
		$config['total_rows'] = $this->tag->getTotal($where);
		$config['uri_segment'] = 6;
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$this->pagination->initialize($config); 
		$this->data['page'] = $this->pagination->create_links();
		$offset = $this->uri->segment(6);
		$arr = $this->tag->getList($this->data['pagesize'], $offset, $where);
		$this->data['tagArr'] = $arr;
        unset($arr);
        $this->data['number'] = $offset+1; 
		$this->load->view('admin/relation_tagList', $this->data);
	}

	//添加
	function add()
	{
		$this->load->model('admin/relation_tag_model','relation_tag');
        $tag_id = trim(addslashes($this->input->get('tag_id')));
        $target_id = trim(addslashes($this->input->get('target_id')));
        if ( empty($tag_id) || empty($target_id) )
        {
            exit -1;
        }
        $data = array('tag_id'=>$tag_id, 'target_id'=>$target_id, 'target_type'=>1);
        $affected_rows = $this->relation_tag->insertNew($data);
        unset($data);
        echo ($affected_rows>0) ? '1' : '-2';
    }    

    //删除	
	function del()
	{
		$this->load->model('admin/relation_tag_model','relation_tag');
		$tag_id = trim(addslashes($this->input->get('tag_id')));
        $target_id = trim(addslashes($this->input->get('target_id')));
        if ( empty($tag_id) || empty($target_id) )
        {
            exit -1;
        }
        $data = array('tag_id'=>$tag_id, 'target_id'=>$target_id, 'target_type'=>1);
        $affected_rows = $this->relation_tag->del($data);
		echo ($affected_rows>0) ? '1' : '-2';
	}

    //ajax获取标签
    function ajax_get($key)
    {
        header('Content-Type: text/html; charset=utf-8');
        //用于调试sql等
        $arr = $arrTag = array();
        if(!empty($key))
        {
            $key = urldecode($key);
            $not_in_ids = explode('-',$this->uri->segment(5));
            //模糊查询$key相关的标签
            $arr = $this->tag->getBy_name($key,$not_in_ids);
            foreach($arr as $v)
            {
                $arrTag[$v['id']] = $v['name'];
            }
            unset($arr);
        }
        $arrTag['len'] = count($arrTag);
        echo json_encode($arrTag);
    }
    

}
