$(document).ready(function(){

  $('.slider').bxSlider({
	mode: 'fade',
    slideWidth: 880, 
    slideMargin: 10,
    auto:true
  });

   jQuery(".slideTxtBox").slide({mainCell:".images ul",autoPage:true,effect:"leftLoop",autoPlay:false,vis:3,trigger:"click",
    startFun:function(i,c){
    },
    endFun:function(i,c){
        var count;
        count =0;
        // $("#textarea").val( $("#textarea").val()+ "第"+(i+1)+"个效果结束，开始执行endFun函数。当前分页状态："+(i+1)+"/"+c+"\r\n")
         if(count == 0){
            if ((i+1) <= (c-2)){
                $(".uls li:eq("+(i+1)+") img").attr("class", "small"); 
                $(".uls li:eq("+(i+2)+") img").attr("class", "normal"); 
                $(".uls li:eq("+(i+3)+") img").attr("class", "small"); 

             //   $(".uls li:eq("+(c+1)+")) img").attr("class", "small");

             }else if((c-(i+1)) == 1){
                //alert(2);
                $(".uls li:eq("+(c-1)+") img").attr("class", "small"); 
                $(".uls li:eq("+(c)+") img").attr("class", "normal");  
                $(".uls li:eq("+(c+1)+") img").attr("class", "small"); 
                $(".uls li:eq(1) img").attr("class", "small"); 
            }else{
               // alert(3);
                $(".clone img").attr("class", "small"); 
                $(".uls li:eq("+c+") img").attr("class", "small"); 
                $(".uls li:eq("+(c+1)+") img").attr("class", "normal");  

                // $(".uls li:eq("+(c+2)+")) img").attr("class", "small"); 
                // $(".uls li:eq("+(c+3)+")) img").attr("class", "small"); 
                // $(".uls li:eq("+(c+4)+")) img").attr("class", "small");
                // $(".uls li:eq("+(c+5)+")) img").attr("class", "small");
            }         
            count = count+ 1;

            $("#textarea").val(i);
         }           
                
    }
});
});