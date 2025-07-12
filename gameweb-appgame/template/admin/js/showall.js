// JavaScript Document
$(document).ready(function(){
  $(".zhankai_b").click(function(){
	  $(".zhankai_b").css("display","none")
	  $(".zhankai_b2").css("display","block")
});
  $(".zhankai_b").click(function(){
  $(".yy_xuantian").animate({height:'toggle', opacity:'toggle'}, "slow");
   },function(){
$(".yy_xuantian").animate({height:'toggle', opacity:'toggle'}, "slow");
   });
});

$(document).ready(function(){
  $(".zhankai_b2").click(function(){
	  $(".zhankai_b2").css("display","none")
	  $(".zhankai_b").css("display","block")
});
  $(".zhankai_b2").click(function(){
  $(".yy_xuantian").animate({height:'toggle', opacity:'toggle'}, "slow");
   },function(){
$(".yy_xuantian").animate({height:'toggle', opacity:'toggle'}, "slow");
   });
});