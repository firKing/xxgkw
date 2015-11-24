<?php

class GuideAction extends CommonAction {
    public function index(){
		$art=M('article');
        $this->nav_get_data();
        //根据传的类型id来取对应的数据列表
        $tid=isset($_GET['tid'])?$_GET['tid']:1;
        import('ORG.Util.CustomPage');    // 导入分页类
        $count=$art->where(array('art_type'=>$tid))->count();   // 查询满足要求的总记录数
        $page=new CustomPage($count,12);  // 实例化分页类 传入总记录数和每页显示的记录数
        $page->setConfig('header','篇文章');
        $page->setConfig('theme','%upPage% %linkPage% %downPage%');
        $pageshow=$page->show();    // 分页显示输出
        $guide=$art->field('art_id,art_title,art_type')->where(array('art_type'=>$tid,'art_locked'=>'no'))->order('art_add_time desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('guide',$guide);
        $this->assign('pageshow',$pageshow);
        $t=M('type');
        if ($tid>7) {
            $type_list=$t->where('typeid>7')->select();
        }else{
            $type_list=$t->where('typeid<4')->select();
        }
        $type=$t->field('typedetail')->find($tid);
        
        $this->assign('type',$type['typedetail']);
        $this->assign('type_list',$type_list);


		$this->display();
    }

    public function detail(){
        $aid=$_GET['aid'];
        $tid=$_GET['type'];
        $this->nav_get_data();
        $t=M('type');
        if ($tid>7) {
            $type_list=$t->where('typeid>7')->select();
        }else{
            $type_list=$t->where('typeid<4')->select();
        }

        //通过文章id找出文章的信息
        $content=M('article')->find($aid);

        //输出属于那个小类
        $type=$t->field('typedetail')->find($tid);

        //查找是否有附件
        $ann=M('annex')->where(array('ann_article_id'=>$aid,'ann_lock'=>'no'))->select();
        if(!empty($ann)){
            $ann_show="附件下载：";
            foreach ($ann as $a) {
			$b = __ROOT__.'/Admin/'.$a['ann_url'];
			//dump($b);die();
                //$ann_show .='<a href="__URL__/download/annid/'.$a['ann_id'].'" target="_blank">'.$a['ann_title'].'</a><br />';
				$ann_show .='<a href="'.$b.'" target="_blank">'.$a['ann_title'].'</a><br />';
            }
        }else{
            $ann_show="";
        }
        $this->assign('ann_show',$ann_show);
        $this->assign('type',$type['typedetail']);
        $this->assign('type_list',$type_list);
        $this->assign('content',$content);
        $this->display();
    }
	
    public function download(){
        if(isset($_GET['annid'])){
            $ann=M('annex')->where(array('ann_id'=>$_GET['annid'],'ann_lock'=>'no'))->find();
            if(!empty($ann)){
                $file=__ROOT__.'/Admin/'.$ann['ann_url'];
                $length = filesize($file);
                $type = substr(strrchr($ann['ann_title'], '.'), 1);
                $showname =  ltrim(strrchr($file,'/'),'/');
                header("Content-Description: File Transfer");
                header('Content-type: ' . $type);
                header('Content-Length:' . $length);
                 if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
                     header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
                 } else {
				 dump($showname);
				 die();
                     header('Content-Disposition: attachment; filename="' . $showname . '"');
                 }
                 readfile($file);
                 exit;
            }else{
                exit('不存在此附件');
            }
                
        }
    }

}