<?php

class NewspaperAction extends CommonAction {
    public function index(){
        $this->nav_get_data();
    	$art=M('article');
        $this->nav_get_data();
        $fnp=$art->field('art_id')->where(array('art_type'=>5,'art_locked'=>'no'))->order('art_add_time desc')->find();
        if(isset($_GET['aid'])){
            $firstArt=$art->field('art_content,art_title')->find($_GET['aid']);
        }else if(!empty($fnp)){
            $firstArt=$art->field('art_content,art_title')->find($fnp['art_id']);
        }
        $np_list=$art->field('art_id,art_title')->where(array('art_type'=>5,'art_locked'=>'no'))->order('art_add_time desc')->select();
        $this->assign('np_list',$np_list);
        $this->assign('firstArt',$firstArt);
        $this->display();
    }

}