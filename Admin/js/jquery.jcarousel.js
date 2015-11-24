/**
 *  jQuery jcarousel Plugin
 *  @requires jQuery v1.4.2
 *  http://www.designsor.com/jcarousel/
 *  auther:Xiaojue
 *  Version: 1.0
 *  Version: 2.0 //增加一些报错机制，滚动效果改为平滑的头尾相接
 */
(function($){
	//jcarousel的初始化设置  
	 $.fn.jcarousel = function(options){
		  var defaults = {
		   width:600, //宽
       	   height:200,	//高	
		   photo:[{"url":'http://inncache.soso.com/pc/images/manage.jpg',"href":'#',"target":'_blank',"title":"qq"},{"url":'http://inncache.soso.com/pc/images/xf.jpg',"href":"#","target":"_blank","title":"qq"},{'url':'http://inncache.soso.com/pc/images/manage.jpg',"href":'#none',"title":'jcarousel'},{"url":'http://inncache.soso.com/pc/images/xf.jpg',"href":'#none',"title":'jcarousel'},{'url':'http://inncache.soso.com/pc/images/TT.jpg',"href":'#none',"title":'jcarousel'}], //参数
		   jclass:"jcarousel", //默认样式
		   speed:300, //速度
		   timeout:3000 //间隔
	};
    var options = $.extend(defaults, options);

	return this.each(function(index) {
							 
	 	var $this = $(this);
		if(options.photo.length==0){return;}
		    $this.css({"width":options.width,"height":options.height});
		var myvars={}
		myvars.flg=0; //浮标
		myvars.t;
		//创建轮播层
		var creatcarousel=function(){
			var jcarousel=$('<div class='+options.jclass+'>'); //最外层容器
			var picsloer=$('<div class="slor">');
			var jul=$('<ul>');
			jul.appendTo(jcarousel);
			picsloer.css({"position":"relative"}).appendTo(jcarousel);
			
			jcarousel.css({"overflow":"hidden",
						  "width":options.width,
						  "height":options.height,
						  "position":"relative"
						  }).appendTo($this);
			
			$.each(options.photo,function(i,n){
			$('<img>',{"src":options.photo[i]['url'],"width":options.width,"height":options.height,"title":options.photo[i]['title']})
			.css({"position":"absolute",
				 "top":0,
				 "left":i*options.width
				 })
			.appendTo(picsloer);
			
			$('<li>',{text:(i+1)}).appendTo(jul);
			
			});
			
			
			picsloer.children('img').each(function(i){$(this).wrap('<a href="'+options.photo[i]['href']+'"></a>')})
			
			
			$('<img>',{"src":options.photo[0]['url'],"width":options.width,"height":options.height,"title":options.photo[0]['title'],"class":"clone"})
			.css({"position":"absolute",
				 "top":0,
				 "left":options.width
				 })
			.appendTo(jcarousel);
			
			
			$this.find("li").css({"cursor":"pointer"}).hover(function(){
							myvars.flg=$(this).index();										  
							$(this).addClass("lihover").siblings().removeClass("lihover");
							$this.find('.slor').stop(false);
							$this.find('.slor').animate({left:-(myvars.flg*options.width)},options.speed);
							myvars.flg=myvars.flg+1;
							},function(){});												 
		}
	  creatcarousel();
	  //自动定时滚动
	  var starmove=function(){
		  		if(options.photo.length!=1){
				if(myvars.flg==1){$this.find('.slor').css("left","0px");$this.find('.clone').css({"left":options.width});$this.find('.slor').animate({left:-(myvars.flg*options.width)},options.speed);}
				
				$this.find("li").removeClass('lihover').end().find("li:eq("+myvars.flg+")").addClass('lihover');
				
				
				$this.find('.slor').animate({left:-(myvars.flg*options.width)},options.speed);
				
				if(myvars.flg==options.photo.length){
				$this.find("li").removeClass('lihover').end().find("li:eq(0)").addClass('lihover');
				
				$this.find('.clone').animate({left:"0px"},options.speed);
				
				}
				
				
				
				if(myvars.flg==options.photo.length){myvars.flg=0;}
				
				myvars.flg=myvars.flg+1;
				
				myvars.t=setTimeout(starmove,options.timeout);
				
				}
	  }
	  starmove();
	  //控制
	  $this.hover(function(){
			clearTimeout(myvars.t);
						},function(){
			myvars.t=setTimeout(starmove,options.timeout)
						});
	  //clone
	  $this.find('.clone').hover(function(){
			$this.find('.clone').css({"left":options.width});
			$this.find('.slor').css({"left":"0px"});
										  },function(){})
	 return this;
	 });
}})(jQuery);