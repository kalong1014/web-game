// JavaScript Document
//app具体信息切换
function tabChange(obj,id)
{
 var arrayli = obj.parentNode.getElementsByTagName("li"); //获取li数组
 var arraydl = document.getElementById(id).getElementsByTagName("dl"); //获取dl数组
 for(i=0;i<arraydl.length;i++)
 {
  if(obj==arrayli[i])
  {
   arrayli[i].className = "cli";
   arraydl[i].className = "";
  }
  else
  {
   arrayli[i].className = "";
   arraydl[i].className = "hidden";
  }
 }
}




/*----搜索加资讯搜索-----*/
$(document).ready(function(){
  $('.search_nav').mouseover(function(){
     $('.search_nav').css('height','80px');
  });
  $('.search_nav2').mouseover(function(){
     $('.search_nav2').css('height','80px');
  });
  $('.search_nav').mouseout(function(){
     $('.search_nav').css('height','40px');
     $('.search_nav2').css('height','40px');
  });
  $('.search_nav2').mouseout(function(){
     $('.search_nav2').css('height','40px');
  });
}); 

/*----微信和wap版-----*/
$(document).ready(function(){
  $('.top_gn_swzy').mouseover(function(){
     $('.b_gntu').show();
  });
  $('.top_gn_swzy').mouseout(function(){
     $('.b_gntu').hide();
  });
  $('.top_gn_jrsc').mouseover(function(){
     $('.b_gntu2').show();
     $('.b_gntu3').show();
  });
  $('.top_gn_jrsc').mouseout(function(){
     $('.b_gntu2').hide();
     $('.b_gntu3').hide();
  });
}); 



/*----tuad提示标题-----*/
$(document).ready(function(){
  $('.tuad li').mouseover(function(){
     $(this).find(".tuad_tit").show();
  });
  $('.tuad li').mouseout(function(){
     $(this).find(".tuad_tit").hide();
  });
}); 



/*--下载下拉---*/
$(document).ready(function(){
  $('.button_an').click(function(){
	 $(this).hide();
     $('.button_an2').show();
     $('.app_content_xiazai_box_an').show();
  });
  $('.button_ios').click(function(){
	 $(this).hide();
     $('.button_ios2').show();
     $('.app_content_xiazai_box_ios').show();
  });
  $('.button_an2').click(function(){
	 $(this).hide();
     $('.button_an').show();
     $('.app_content_xiazai_box_an').hide();
  });
  $('.button_ios2').click(function(){
	 $(this).hide();
     $('.button_ios').show();
     $('.app_content_xiazai_box_ios').hide();
  });
}); 


/*--纠错--*/
$(document).ready(function(){
  $(".banquants .jiucuo").click(function(){
    $(".jiucuobox").css("display","block");
  });
  $(".jiucuo_guanbi").click(function(){
    $(".jiucuobox").css("display","none");
  });
  $(".jiucuo_qx").click(function(){
    $(".jiucuobox").css("display","none");
  });
});






