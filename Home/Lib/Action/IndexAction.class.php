<?php

class IndexAction extends CommonAction {
    public function index(){
		$article=M('article');
		$new=$article->field('art_id,art_title,art_type,art_add_time')->where(array('art_type'=>7,'art_locked'=>'no'))->order('art_add_time desc')->limit(0,7)->select();
		$this->assign('new',$new);
		$inform=$article->field('art_id,art_title,art_type,art_add_time')->where(array('art_type'=>20,'art_locked'=>'no'))->order('art_add_time desc')->limit(0,7)->select();
		$this->nav_get_data();
		$this->assign('inform',$inform);
		$this->display();
	}
}