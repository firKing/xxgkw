<?php
	class CommonAction extends Action{
		public function nav_get_data(){
			 Load('extend');
			$np=M('article')->field('art_id,art_title')->where(array('art_type'=>4,'art_locked'=>'no'))->order('art_add_time DESC')->limit(0,10)->select();
			$this->assign('np',$np);
		}
	}