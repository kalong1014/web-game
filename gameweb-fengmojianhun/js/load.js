$(document).ready(function(){
	$.fn.scroll_({arrows:false,mouseWheelSpeed: 30,verticalGutter:15});
	$(".Tab").floatlines()
	setTimeout(function(){
		$('#news .Tab').Tab({lilab:"li",labselect:".change",Tabname:".Tab_nr",labaction:"click",animatename:"scroll_x",animateTime:300,mode:"none"})
		$('#RechargeBox .Tab').Tab({lilab:"li",labselect:".change",Tabname:".Tab_nr",labaction:"click",animatename:"scroll_x",animateTime:300,mode:"none"})
		
	},130)
	$("#ZhiYe").banner_animate_play();
	$("#ZhuangBeiGunDong").jcarousellite_gundong({btn:1,list:".PicList li","visible":1,"auto":5000,"speed":600});
	$("#ZhuangBeiGunDong2").jcarousellite_gundong({btn:1,list:".PicList li","visible":1,"auto":5000,"speed":600});
	$.fn.videowindow({btnobj:".btn_video"});

	
		/*播放视频*/		 
		$("#btn_play").one("click",function(){
			var videourl=$(this).attr("data-file")	
			var autoplay=$(this).attr("data-autoplay")	
			var playobj=$(this).attr("data-playobj")
			if ($(playobj).length==0) return false;
			
			if (videourl)
			{
				
			var w=$(playobj).outerWidth()
			var h=$(playobj).outerHeight()
				
			var writehtml='<object class id="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="../download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0/#version=7,0,19,0/#version=7,0,19,0/#version=7,0,19,0/" width="'+w+'" height="'+h+'">'
				writehtml+='<param name="movie" value="flash/Flvplayer.swf">'
				writehtml+='<param name="quality" value="high">'
				writehtml+='<param value="transparent" name="wmode">'
				writehtml+='<param name="allowFullScreen" value="true">'
				writehtml+='<param name="FlashVars" value="vcastr_file='+videourl+'&BufferTime=3&IsAutoPlay='+autoplay+'">'
				writehtml+='<embed src="flash/Flvplayer.swf" wmode="Opaque" allowfullscreen="true" flashvars="vcastr_file='+videourl+'&IsAutoPlay='+autoplay+'" quality="high" pluginspage="../www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'+w+'" height="'+h+'"></embed>'
				writehtml+='</object>'
				
				$(this).stop(true,false).animate({opacity: 0}, 500,function(){$(playobj).html(writehtml)})
			}
			
			
		})	
	
	
		if ($("#playbanner").length>0)
		{
			$("#playbanner").ZHYslider({
					fullscreen	:false,
					arrow		:false,		
					speed: 1200, 
					space: 6000,
					auto: true, //自动滚动
					affect:'scrollx',
					ctag: '.Slide_'
			})
				
		}	
	
		if ($("#playbanner2").length>0)
		{
			$("#playbanner2").ZHYslider({
					fullscreen	:false,
					arrow		:false,		
					speed: 1200, 
					space: 6000,
					auto: true, //自动滚动
					affect:'scrollx',
					ctag: '.Slide_2'
			})
				
		}	
		
		
	$.fn.wowanimate_list();
	$.fn.hovers();
})

$.fn.wowanimate_list=function(){
	
	if (typeof(WOW)=='undefined') {return;}
	if ((/msie [6|7|8|9]/i.test(navigator.userAgent))){return;}

	var m1	=	$("#m1");
	if (m1.length>0)
	{
		m1.css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":0.5+"s","data-wow-delay":300+"ms"})
	}
	
	var download	=	$("#download");
	if (download.length>0)
	{
		download.css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":0.5+"s","data-wow-delay":500+"ms"})
		
	}
	
	
	var news	=	$("#news");
	if (news.length>0)
	{
		news.css("visibility","hidden").addClass("wow fadeInLeft").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":700+"ms"})
		
	}
	
	
	var playbanner	=	$("#playbanner");
	if (playbanner.length>0)
	{
		playbanner.css("visibility","hidden").addClass("wow fadeInRight").attr({"data-wow-offset":0,"data-wow-duration":1.2+"s","data-wow-delay":900+"ms"})
		
	}
	
	
	var Game_show	=	$("#Game_show");
	if (Game_show.length>0)
	{
		Game_show.find("h3").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":400+"ms"})
		Game_show.find("#Renbg1").css("visibility","hidden").addClass("wow fadeInRight").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":200+"ms"})
		Game_show.find(".PicList").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":200+"ms"})
		Game_show.find(".PicList2").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":200+"ms"})
		Game_show.find(".PicList3").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":200+"ms"})

	}
	
	var GameLive	=	$("#GameLive2");
	if (GameLive.length>0)
	{
		GameLive.find("h3").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":400+"ms"})
		GameLive.find("#Renbg2").css("visibility","hidden").addClass("wow fadeInLeft").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":200+"ms"})
		GameLive.find(".PicList2").css("visibility","hidden").addClass("wow fadeInRight").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":200+"ms"})
	}
	
	var GameLive	=	$("#GameLive3");
	if (GameLive.length>0)
	{
		GameLive.find("h3").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":400+"ms"})
		GameLive.find("#Renbg3").css("visibility","hidden").addClass("wow fadeInRight").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":200+"ms"})
		GameLive.find(".PicList3").css("visibility","hidden").addClass("wow fadeInLeft").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":200+"ms"})
	}


	
	var Game_info	=	$("#Game_info");
	if (Game_info.length>0)
	{
		Game_info.find("h3").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":400+"ms"})
	}
	
	var Intr	=	$("#Intr");
	if (Intr.length>0)
	{
		Intr.css("visibility","hidden").addClass("wow fadeInLeft").attr({"data-wow-offset":0,"data-wow-duration":1.2+"s","data-wow-delay":900+"ms"})
	}
	
	var Recharge	=	$("#Recharge");
	if (Recharge.length>0)
	{
		Recharge.css("visibility","hidden").addClass("wow fadeInRight").attr({"data-wow-offset":0,"data-wow-duration":1.2+"s","data-wow-delay":900+"ms"})
	}

	var Game_show	=	$("#Game_show");
	if (Game_show.length>0)
	{
		Game_show.find("h3").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":400+"ms"})
		Game_show.find(".PicList3").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":1.5+"s","data-wow-delay":500+"ms"})
	}
		

	
	
	var ZhiYe	=	$("#ZhiYe");
	if (ZhiYe.length>0)
	{
		ZhiYe.css("visibility","hidden").addClass("wow fadeInLeft").attr({"data-wow-offset":0,"data-wow-duration":1.2+"s","data-wow-delay":900+"ms"})
	}
	
	
	var ZhuangBei	=	$("#ZhuangBei");
	if (ZhuangBei.length>0)
	{
		ZhuangBei.css("visibility","hidden").addClass("wow fadeInRight").attr({"data-wow-offset":0,"data-wow-duration":1.2+"s","data-wow-delay":900+"ms"})
	}
	
	
	var kefu	=	$("#kefu");
	if (kefu.length>0)
	{
		kefu.find("._backtop").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":0.5+"s","data-wow-delay":100+"ms"})
		kefu.find(".pic_yy").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":0.7+"s","data-wow-delay":300+"ms"})
		kefu.find("._yyname").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":0.9+"s","data-wow-delay":600+"ms"})
		kefu.find(".kefulist").each(function(index, element) {
				$(this).css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":(index+1)*0.2+"s","data-wow-delay":200*(index+1)+"ms"})
        });
		
		kefu.find(".tips").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":1.2+"s","data-wow-delay":1000+"ms"})
	}
	
	
	var footer	=	$("#footer");
	if (footer.length>0)
	{
		
	}
	
	
	
	var Service_jieshao	=	$("#Service_jieshao");
	if (Service_jieshao.length>0)
	{
		Service_jieshao.find(".website").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":0.5+"s","data-wow-delay":0+"ms"})
		Service_jieshao.find(".pic").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":0.5+"s","data-wow-delay":100+"ms"})
		Service_jieshao.find("h2").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":0.5+"s","data-wow-delay":400+"ms"})
		Service_jieshao.find("h3").css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":0.5+"s","data-wow-delay":200+"ms"})
		Service_jieshao.find("p").each(function(index, element) {
				$(this).css("visibility","hidden").addClass("wow fadeInUp").attr({"data-wow-offset":0,"data-wow-duration":(index+1)*0.2+"s","data-wow-delay":200*(index+1)+"ms"})
        });
		
		
	}

		if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))){
			if (typeof(WOW)!='undefined')
			{new WOW().init();}
		};	
	
}
//banner轮播
$.fn.banner_animate_play=function(){
	var self=$(this);
	if (self.length==0)	{return;}
	var bg_html			=	'<ul class="DB_bgSet">{DB_bgSet}</ul>',
		pic_html		=	'<ul class="DB_imgSet">{DB_imgSet}</ul>',
	 	pic_html_li		=	'',
	 	bg_html_li		=	'',
		 li				=	'',
		 otherhtml		=	'';
		 
	self.find(".Slide_").each(function(index, element) {
        pic_html_li+='<li>'+$(this).html()+'</li>'
        bg_html_li+='<li style="'+$(this).attr("style")+'"></li>'
		li+='<li><i class="iconzy_ iconzy_1x'+(index+1)+'"></i></li>'
    });
	
	bg_html=bg_html.replace('{DB_bgSet}',bg_html_li)
	pic_html=pic_html.replace('{DB_imgSet}',pic_html_li)
	
	otherhtml+='<div class="DB_menuWrap">'
			+'	<ul class="DB_menuSet">'+li+'</ul>'
			+'	<div class="DB_next"></div>'
			+'	<div class="DB_prev"></div>'
			+'</div>'
			
	self.find("#banner_nr").html(bg_html+pic_html+otherhtml);
	self.find("#banner_nr").DB_tabMotionBanner({
		key:'b28551',
		autoRollingTime:6000,                            
		bgSpeed:400,
		motion:{
			DB_1_1:{left:-150,opacity:0,speed:800,delay:1200},
			DB_1_2:{left:150,opacity:0,speed:300,delay:600},
			DB_1_3:{left:200,opacity:0,speed:300,delay:700},
			DB_1_4:{left:300,opacity:0,speed:300,delay:1000},
			
			DB_2_1:{top:-150,opacity:0,speed:800,delay:1200},
			DB_2_2:{top:150,opacity:0,speed:600,delay:600},
			DB_2_3:{top:200,opacity:0,speed:600,delay:700},
			DB_2_4:{top:300,opacity:0,speed:600,delay:1000},

			DB_3_1:{left:150,opacity:0,speed:800,delay:1200},
			DB_3_2:{left:-150,opacity:0,speed:600,delay:600},
			DB_3_3:{left:-200,opacity:0,speed:600,delay:700},
			DB_3_4:{left:-300,opacity:0,speed:600,delay:1000},

			end:null
		}
	});
	
}


//视频弹窗
$.fn.videowindow=function(config){
	
	var videowindow		=	$("#videowindow"),
		videowindow_zz	=	$("#videowindow_zz")
		windowHtml		=	'<div id="videowindow"><span class="btn_closewindow"><em>关闭窗口</em></span></div><div id="videowindow_zz"></div>',
		btn_close		=	videowindow.find(".btn_closewindow"),
		btn_			=	$(config.btnobj),
		videosrc		=	btn_.data("videosrc"),
		videoAutoPlay	=	btn_.data("autoplay"),
		video_w			=	0,
		video_h			=	0,
		kaiguan			=	0,
		writehtml		=	'';
		
		if (videosrc=="" ||  typeof(videosrc)=="undefined") {return;}
		if (videoAutoPlay!==1 || typeof(videoAutoPlay)=="undefined"){videoAutoPlay=0;}

		var clearwindow	=	function(){
			$("#videowindow").empty().remove();
			$("#videowindow_zz").empty().remove();
			videowindow		=	$("#videowindow");
			videowindow_zz	=	$("#videowindow_zz");
		};
	
		var createwindow	=function(){
			kaiguan	=	1;
			if (videowindow.length==0 || videowindow_zz.length==0){
				clearwindow();
				$("body").append(windowHtml);
				videowindow		=	$("#videowindow");
				videowindow_zz	=	$("#videowindow_zz");
				btn_close		=	videowindow.find(".btn_closewindow");
			}
			
				openwindow();
			
			
		};

		if (videowindow.length==0 || videowindow_zz.length==0){
			clearwindow();
			createwindow();
		}
		var openwindow	=	function(){
			videowindow.fadeIn();
			videowindow_zz.fadeIn();
		};	

		video_w	=	videowindow.outerWidth()-20;
		video_h	=	videowindow.outerHeight()-20;
		writehtml='<object class id="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="../download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0/#version=7,0,19,0/#version=7,0,19,0/#version=7,0,19,0/" width="'+video_w+'" height="'+video_h+'">'
			+'<param name="movie" value="flash/Flvplayer.swf">'
			+'<param name="quality" value="high">'
			+'<param value="transparent" name="wmode">'
			+'<param name="allowFullScreen" value="true">'
			+'<param name="FlashVars" value="vcastr_file='+videosrc+'&BufferTime=3&IsAutoPlay='+videoAutoPlay+'">'
			+'<embed src="flash/Flvplayer.swf" wmode="Opaque" allowfullscreen="true" flashvars="vcastr_file='+videosrc+'&IsAutoPlay='+videoAutoPlay+'" quality="high" pluginspage="../www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'+video_w+'" height="'+video_h+'"></embed>'
			+'</object>'

	
		//关闭
		$("body").on("click",".btn_closewindow",function(){
			videowindow_zz.fadeOut(200);
			videowindow.fadeOut(200);
			setTimeout(function(){clearwindow();},200)
			
		});
		//打开
		btn_.bind("click",function(){
			if (kaiguan==1) {return;}
			createwindow();
			videowindow.append(writehtml);
			setTimeout(function(){kaiguan=0;},200)
		});
	
	
	
};

//浮动线条
	$.fn.floatlines=function(){
		var obj			=	$(this),
			times		=	300,
			delaytime	=	null;
		if (obj.length===0){return;}
			obj.css("position","relative");
			
			
		obj.each(function(index, element) {
			var tab_obj		=	$(this),
			 	li			=	tab_obj.find("li.change");
				
			if (li.length>0)
			{
				tab_obj.find("li:last-child").after("<span class='lines'></span>");
				
				var width	=	li.outerWidth(),
					lileft	=	li.position().left+parseInt(li.css("margin-left")),
					lineobj	=	tab_obj.find(".lines");
					
					lineobj.css({"width":width,"left":lileft});
				
					tab_obj.find("li")
					.bind("mouseenter",function(){
						
							clearTimeout(delaytime)
							var myself		=	$(this),
								thiswidth	=	myself.outerWidth(),
								left		=	myself.position().left+parseInt(myself.css("margin-left"));
								lineobj.stop(true,false).animate({"width":thiswidth,"left":left},times);
					})
					.bind("mouseleave",function(){
						var myself		=	$(this);
							delaytime=setTimeout(function(){
									if (!myself.is(".change"))
									{
									var changeobj	=	myself.siblings(".change"),
										 left		=	changeobj.css("position","static").position().left+parseInt(changeobj.css("margin-left")),
										 width		=	changeobj.outerWidth();
										 lineobj.stop(true,false).animate({"width":width,"left":left},times);
									}
									
							
							},200)
					})
					
				
			}
		});	
	}



//滚动
		$.fn.jcarousellite_gundong=function(options ){
			var self=$(this);
			if (self.length==0) return false;
			var items=options.list,config;
			if (self.find(items).length<=options.visible) 
			{
				var width=self.find(options.list).parent().outerWidth()
				self.css({"margin":"0 auto","width":width})
			return false;	
			}
			else
			{
				var liobj=self.find(options.list)
				var width=liobj.outerWidth()
				var margin=parseInt(liobj.css("margin-left"))+parseInt(liobj.css("margin-right"));
				width+=margin
				self.css({"margin":"0 auto","width":width*options.visible})
			}
			self.css("overflow","visible");
			
			if (self.find(items).is("div"))
			{
				self.find(items).wrap("<li></li>");
				self.find(items).parent().wrapAll("<ul class='templist'></ul>");		
				items=".templist li"
			}
			self.find(items).parent().wrapAll('<div class="jCarouselLite"></div>').parent().wrapAll('<div class="gundong"></div>');
			
			
			if (options.btn!=0)
			{
				self.find(".gundong").append('<span class="clear"></span><a href="javascript:;"  class="move_right"><span></span></a><a href="javascript:;" class="move_left disabled" ><span></span></a>')
			}
			
			self.find(".gundong").each(function(index){
				
				config={
							btnPrev: $(this).find(".move_left:eq("+index+")"),
							btnNext: $(this).find(".move_right:eq("+index+")"),
							visible:1,
							auto: 2500 ,
							speed: 300
						}	
				if (options.btn==0)		
				{
					$.extend(config, {btnPrev:null,btnNext:null});							
				}
				$.extend(config, options);
				$(this).find(".jCarouselLite:eq("+index+")").jCarouselLite(config);	
			})
		}





//悬停效果
$.fn.hovers=function(){
	
		$(".btn_backtop,._backtop").bind("click",function(){
			$("html,body").animate({scrollTop:0},1000);
			return false;
		});
		
	
	
	
		$("#menu li").hover_animate(
				{
				  aniobj:
				  [
					  [
						  "em",					//应用对象
						  "{'position':'relative'}",//初始CSS
						  "{'top':'20px'}",		//mouseenter动画CSS
						  "{'top':0}",			//mouseleave动画css
						  "300",					//mouseenter 时间
						  "300"						//mouseleave 时间
					  ],
					  [
						  "span",					//应用对象
						  "{'position':'relative'}",//初始CSS
						  "{'top':'-30px'}",		//mouseenter动画CSS
						  "{'top':0}",			//mouseleave动画css
						  "300",					//mouseenter 时间
						  "300"						//mouseleave 时间
					  ]
				  ]
				}
				
			)		

	
}

//加载滚动条
$.fn.scroll_=function(config){
	var scrollobj=$("[data-scroll]")
	if (scrollobj.length==0) return false;
	scrollobj.each(function(index, element) {
			var self=$(this)
			if (self.length==0)  return false;
			
			var h=parseInt(self.attr("data-scroll-height")),
				w=parseInt(self.attr("data-scroll-width")),
				color=self.attr("data-scroll-color");
				self.css({"width":"100%"});
				self.wrap('<div class="container1" style="width:'+w+'px"></div>').wrap('<div class="div_scroll"></div>');
				self.parents('.div_scroll').css({height:h}).scroll_absolute(config)	
				self.find("img").load(function(){self.parents('.div_scroll').scroll_absolute(config);})
			
			if (typeof(color)!="undefined")
			{setTimeout(function(){self.parents(".container1").find(".scroll_drag").css({"background":color})},500);}
	});
}

//选项卡切换
		$.fn.Tab=function(config){
			var self=$(this);
			var select_=0;
			var classname=config.labselect.replace(".","")
			if (self.length==0) return false;
			if (self.find(config.lilab).length==0) return false;
			
			
			self.each(function(index, element) {
							
				self=$(this);
						
						if (self.find(config.labselect).length==0) 
						{self.find(config.lilab+":eq(0)").addClass(classname);}
						self.find(config.lilab).each(function(index, element) {
							if (!$(this).is(config.labselect))
							{
								self.siblings(config.Tabname+":eq("+index+")").hide();
							}
						});
						
						self.find(config.lilab).bind(config.labaction+".action",function(){
							
							var index=$(this).index();
							if(self.siblings(config.Tabname+":visible").is(":animated")){ 
							return false;
							
							}

							
							if ($(this).is(config.labselect)) return false;
							var index2=$(this).siblings(config.labselect).index()
							$(this).addClass(classname).siblings().removeClass(classname);
							
							config.animate(index,index2,config.animatename)
							return config.labaction=="click"?   false :  true;
						})
						
						config.animate=function(index,index2,active){
							
							switch (active)
							{
								case "fade":
									self.siblings(config.Tabname+":visible").hide();
									self.siblings(config.Tabname+":eq("+index+")").fadeIn(config.animateTime);
								break;
								case "scroll_x":
									self.parent().css({"position":"relative","overflow":"hidden"});
									var selfs=self.siblings(config.Tabname+":visible")
									var dr="100%",dr2="100%"
									if (index2>index)
									{
										dr="100%";
										dr2="-100%"
									}
									else
									{
										dr="-100%";
										dr2="100%"
									}
									var top=selfs.position().top
									
									
									if (config.mode=="delay")		
									{
									//当前渐隐
									selfs
									.css({"position":"relative","width":"100%"})
									.stop(true,false)
									.animate({"left":dr,"opacity":0},config.animateTime,
												function(){
													 $(this).css({"position":"static","left":"auto","opacity":1,"display":"none"}
												)}
											)
									setTimeout(function(){
												self.siblings(config.Tabname+":eq("+index+")").css({"position":"relative","left":dr2,"display":"block","opacity":0})
												.stop(true,false)
												.animate({"left":0,"opacity":1},config.animateTime
												,function(){
														$(this).css({"top":0,"position":"static"})	
														
												})
									},config.animateTime)		
								
									}
									
									else
									{
										
											selfs
											.css({"position":"absolute","width":"100%","left":selfs.position().left,"top":selfs.position().top})
											.stop(true,false)
											.animate({"left":dr,"opacity":0},config.animateTime,
												function(){
													 $(this).css({"position":"relative","top":"auto","left":"auto","opacity":1,"display":"none"}
												)}
											)
									
									
												self.siblings(config.Tabname+":eq("+index+")").css({"position":"relative","left":dr2,"display":"block","opacity":0})
												.stop(true,false)
												.animate({"left":0,"opacity":1},config.animateTime
												,function(){
														$(this).css({"top":0,"position":"relative"})	
														
												})
									}
								break;
								
								
								case "none":
									self.siblings(config.Tabname+":visible").hide();
									self.siblings(config.Tabname+":eq("+index+")").show();
								break;	
								
							}
							
							
						}


            });

		}




$.fn.hover_animate=function(obj){var time_delay=null,runlist=[],runlist_end=[],create_var=[],set_var=[],self=$(this);if(self.length===0||obj.aniobj.length===0){return}if(obj.set_class===""||typeof(obj.set_class)==="undefined"){$.extend(obj,{set_class:"hover"})}if(typeof(obj.delaytime)!=="number"||typeof(obj.delaytime)==="undefined"){$.extend(obj,{delaytime:100})}var fn={csschange:function(val){val=$.trim(val);if(val===""){return""}if(val.indexOf("{")<0||val.indexOf("}")<0){val=$.trim(val);var last_fh=val.lastIndexOf(";");if(last_fh+1===val.length){val=val.substring(0,last_fh);val="{'"+val.replace(/\:/g,"':'").replace(/\;/g,"','")+"'}"}else{val="{'"+val.replace(/\:/g,"':'").replace(/\;/g,"','")+"'}"}}return $.trim(val)}};$.each(obj.aniobj,function(index,val){if(val.length<6){return}var setobj=val[0],setobj_=setobj.replace(/\.|\ |\>/g,""),animate_css=fn.csschange(val[1]),animate_start=fn.csschange(val[2]),animate_end=fn.csschange(val[3]),animate_easing=val[4],animate_easing2=val[5],animate_delay=val[6],animate_delay2=val[7],run="",run_end="";if(typeof(animate_delay)==="undefined"){animate_delay=0}if(typeof(animate_delay2)==="undefined"){animate_delay2=0}if(animate_css!==""){animate_css_=".css("+animate_css+")"}else{animate_css_=""}if(setobj===""){return}create_var.push("var _"+setobj_+"");if(setobj==="self"){set_var.push("_"+setobj_+"=[self]")}else{set_var.push("_"+setobj_+'=[self].find("'+setobj+'")')}if(animate_start!==""){run="_"+setobj_+animate_css_+".stop(true,false).delay("+animate_delay+").animate("+animate_start+","+animate_easing+")"}else{run="_"+setobj_+animate_css}if(animate_css_!==""||animate_start!==""){runlist.push(run)}if(animate_end!==""){run_end="_"+setobj_+".stop(true,false).delay("+animate_delay2+").animate("+animate_end+","+animate_easing2+")";runlist_end.push(run_end)}});var selfobj=null;self.off(".s");$.each(create_var,function(index,val){eval(val)});self.on("mouseenter.s",function(){selfobj=$(this);$.each(set_var,function(index,val){eval(val.replace("[self]","selfobj"))});clearTimeout(time_delay);time_delay=setTimeout(function(){if(!selfobj.is(":animated")){selfobj.addClass(obj.set_class);$.each(runlist,function(index,val){eval(val)})}},obj.delaytime)}).on("mouseleave.s",function(){clearTimeout(time_delay);if(selfobj.is("."+obj.set_class)){$.each(runlist_end,function(index,val){eval(val)});selfobj.removeClass(obj.set_class)}})};


jQuery.easing['jswing']=jQuery.easing['swing'];jQuery.extend(jQuery.easing,{def:'easeOutQuad',swing:function(x,t,b,c,d){return jQuery.easing[jQuery.easing.def](x,t,b,c,d);},easeInQuad:function(x,t,b,c,d){return c*(t/=d)*t+b;},easeOutQuad:function(x,t,b,c,d){return-c*(t/=d)*(t-2)+b;},easeInOutQuad:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t+b;return-c/2*((--t)*(t-2)-1)+b;},easeInCubic:function(x,t,b,c,d){return c*(t/=d)*t*t+b;},easeOutCubic:function(x,t,b,c,d){return c*((t=t/d-1)*t*t+1)+b;},easeInOutCubic:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t+b;return c/2*((t-=2)*t*t+2)+b;},easeInQuart:function(x,t,b,c,d){return c*(t/=d)*t*t*t+b;},easeOutQuart:function(x,t,b,c,d){return-c*((t=t/d-1)*t*t*t-1)+b;},easeInOutQuart:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t*t+b;return-c/2*((t-=2)*t*t*t-2)+b;},easeInQuint:function(x,t,b,c,d){return c*(t/=d)*t*t*t*t+b;},easeOutQuint:function(x,t,b,c,d){return c*((t=t/d-1)*t*t*t*t+1)+b;},easeInOutQuint:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t*t*t+b;return c/2*((t-=2)*t*t*t*t+2)+b;},easeInSine:function(x,t,b,c,d){return-c*Math.cos(t/d*(Math.PI/2))+c+b;},easeOutSine:function(x,t,b,c,d){return c*Math.sin(t/d*(Math.PI/2))+b;},easeInOutSine:function(x,t,b,c,d){return-c/2*(Math.cos(Math.PI*t/d)-1)+b;},easeInExpo:function(x,t,b,c,d){return(t==0)?b:c*Math.pow(2,10*(t/d-1))+b;},easeOutExpo:function(x,t,b,c,d){return(t==d)?b+c:c*(-Math.pow(2,-10*t/d)+1)+b;},easeInOutExpo:function(x,t,b,c,d){if(t==0)return b;if(t==d)return b+c;if((t/=d/2)<1)return c/2*Math.pow(2,10*(t-1))+b;return c/2*(-Math.pow(2,-10*--t)+2)+b;},easeInCirc:function(x,t,b,c,d){return-c*(Math.sqrt(1-(t/=d)*t)-1)+b;},easeOutCirc:function(x,t,b,c,d){return c*Math.sqrt(1-(t=t/d-1)*t)+b;},easeInOutCirc:function(x,t,b,c,d){if((t/=d/2)<1)return-c/2*(Math.sqrt(1-t*t)-1)+b;return c/2*(Math.sqrt(1-(t-=2)*t)+1)+b;},easeInElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);return-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;},easeOutElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b;},easeInOutElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d/2)==2)return b+c;if(!p)p=d*(.3*1.5);if(a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b;},easeInBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;return c*(t/=d)*t*((s+1)*t-s)+b;},easeOutBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b;},easeInOutBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b;},easeInBounce:function(x,t,b,c,d){return c-jQuery.easing.easeOutBounce(x,d-t,0,c,d)+b;},easeOutBounce:function(x,t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b;}else if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b;}else if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b;}else{return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b;}},easeInOutBounce:function(x,t,b,c,d){if(t<d/2)return jQuery.easing.easeInBounce(x,t*2,0,c,d)*.5+b;return jQuery.easing.easeOutBounce(x,t*2-d,0,c,d)*.5+c*.5+b;}});