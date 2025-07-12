//Ctrl+Enter 发布
function ctrlEnter(event, btnId, onlyEnter) {
	if(isUndefined(onlyEnter)) onlyEnter = 0;
	if((event.ctrlKey || onlyEnter) && event.keyCode == 13) {
		$(btnId).click();
		return false;
	}
	return true;
}
function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

//评论相关
/*
MGPProj.Comment=
{
	htmlNoPass:'&nbsp;&nbsp;<span class="t_o">您的最新评论正在审核中，请耐心等待</span>',
	htmlAnsWrap:'<dd class="citation_wrapper"></dd>',
	htmlAnsInner:'<div class="citation1">'
        + '<div class="citation_title"><h6><span class="lou">1</span></h6>  <span class="cGeo">45451玩家</span>&nbsp; <span class="t_b nick"></span>&nbsp;<span class="cuin"></span></div>'
        + '<p class="txt_comm"></p>'
     	+ '</div>',
    htmlAnsOuter:'<div class="citation2">'
    	+ '<div class="citation_title"><h6> <span class="lou">1</span></h6>   <span class="cGeo">45451玩家</span>&nbsp; <span class="t_b nick"></span>&nbsp;<span class="cuin"></span></div>'
    	+ '<p class="txt_comm"></p>'
    	+ '</div>',
	htmlReplayTemp:'<div class="add_reply"><div class="add_reply_inner">'
		+ '<form id="replyForm" name="replyForm" action="/index.php?ac=comment&inajax=1" method="post"s>'
		+ '<textarea name="message" id="answerText" cols="" rows="" class="t_g answer_text" ></textarea>'
		+ '<input type="hidden" name="appid" value=""><input type="hidden" value="'+formhash+'" name="formhash"><input type="hidden" value="true" name="commentsubmit"><input type="hidden" name="commentid" value=""><input type="hidden" name="idtype" value="replyid"></form>'
		+ '<div class="add_reply_bq"><p class="fr">'
		+ '<input class="btn_psot" id="btn_post_update_id" type=button value="" style="margin-right:5px;" onclick="javascript:submitComment(1);" ></p>'
		+ '<div class="face fr" style="margin-top:5px;"><div class="face_con"><ul id="replay_emotion_ul_1"><li class="face100"><a href="javascript:;"></a></li><li class="face101"><a href="javascript:;"></a></li><li class="face102"><a href="javascript:;"></a></li><li class="face103"><a href="javascript:;"></a></li><li class="face104"><a href="javascript:;"></a></li><li class="face105"><a href="javascript:;"></a></li><li class="face106"><a href="javascript:;"></a></li><li class="face107"><a href="javascript:;"></a></li><li class="face108"><a href="javascript:;"></a></li><li class="face109"><a href="javascript:;"></a></li><li class="face110"><a href="javascript:;"></a></li><li class="face111"><a href="javascript:;"></a></li><li class="face112"><a href="javascript:;"></a></li></ul></div>'
		+ '<div class="emotion" style="display:none;" id="answer_emotion_div"><ul id="replay_emotion_ul_2"></ul></div>'
		+ '</div></div></div>'
}
*/

htmlNoPass='&nbsp;&nbsp;<span class="t_o">您的最新评论正在审核中，请耐心等待</span>';

htmlAnsWrap='<dd class="citation_wrapper"></dd>';
htmlAnsInner='<div class="citation1">'
        + '<div class="citation_title"><h6><span class="lou">1</span></h6>  <span class="cGeo">45451玩家</span>&nbsp; <span class="t_b nick"></span>&nbsp;<span class="cuin"></span></div>'
        + '<p class="txt_comm"></p>'
     	+ '</div>';
htmlAnsOuter='<div class="citation2">'
    	+ '<div class="citation_title"><h6> <span class="lou">1</span></h6>   <span class="cGeo">45451玩家</span>&nbsp; <span class="t_b nick"></span>&nbsp;<span class="cuin"></span></div>'
    	+ '<p class="txt_comm"></p>'
    	+ '</div>';
htmlReplayTemp='<div class="add_reply"><div class="add_reply_inner">'
		+ '<form id="replyForm" name="replyForm" action="/index.php?ac=comment&type='+iType+'&inajax=1" method="post"s>'
		+ '<textarea name="message" id="answerText" cols="" rows="" class="t_g answer_text" ></textarea>'
		+ '<input type="hidden" name="appid" value=""><input type="hidden" value="'+formhash+'" name="formhash"><input type="hidden" value="true" name="commentsubmit"><input type="hidden" name="pid" value=""><input type="hidden" name="idtype" value="replyid"></form>'
		+ '<div class="add_reply_bq"><p class="fr">'
		+ '<input class="btn_psot" id="btn_post_update_id" type=button value="回复评论" style="margin-right:5px;" onclick="javascript:submitComment(1);" ></p>'
		+ '<div class="face fr" style="margin-top:5px;"><div class="face_con"><ul id="replay_emotion_ul_1"><li class="face100"><a href="javascript:;"></a></li><li class="face101"><a href="javascript:;"></a></li><li class="face102"><a href="javascript:;"></a></li><li class="face103"><a href="javascript:;"></a></li><li class="face104"><a href="javascript:;"></a></li><li class="face105"><a href="javascript:;"></a></li><li class="face106"><a href="javascript:;"></a></li><li class="face107"><a href="javascript:;"></a></li><li class="face108"><a href="javascript:;"></a></li><li class="face109"><a href="javascript:;"></a></li><li class="face110"><a href="javascript:;"></a></li><li class="face111"><a href="javascript:;"></a></li><li class="face112"><a href="javascript:;"></a></li></ul></div>'
		+ '<div class="emotion" style="display:none;" id="answer_emotion_div"><ul id="replay_emotion_ul_2"></ul></div>'
		+ '</div></div></div>';
		
function CommentInit()
{
	
		//评论相关
		$('.answerA').live('click', function()
		{
			if ($(this).hasClass("on"))
			{
				$('.add_reply').remove();
				$(this).removeClass("on");
				$(this).parent().parent().removeClass("expand");
				return;
			}
			$('.answerA').removeClass("on");
			$('.add_reply').remove();
			$(this).addClass("on");
			$(this).parent().parent().addClass("expand");
			var iCommentId = $(this).parent().parent().attr('name');
			$(this).parent().parent().after(
				$(htmlReplayTemp).find("input[name='appid']").val(iGameId).end()
					.find("input[name='pid']").val(iCommentId).end()
					);
					
			$('#replay_emotion_ul_1 li:lt(12)').click(function()
			{
			    $('#answerText').focus();
				var emId = this.className.substring(4);
				if($('#answerText').val() == '我也要来说两句……')
				{
					$('#answerText').val('');			   
				}
				var sFace = '[em:' + emId + ':]';
				var myObj = document.getElementById('answerText');
				if (document.selection)
				{ // IE…
					var Sel = document.selection.createRange(); 
					Sel.text = sFace;
					Sel.moveStart('character', -myObj.value.length);
				}
				else
				{
					var sTemp = $('#answerText').val();
					var length = myObj.selectionStart + sFace.length;
					$('#answerText').val(sTemp.substring(0,myObj.selectionStart) + sFace + sTemp.substring(myObj.selectionEnd));
					myObj.setSelectionRange(length,length);
				}				
				
			});
			$('#replay_emotion_ul_1 li:eq(12)').click(function()
			{
				if ($(this).hasClass("isclicked"))
				{
					if ($('#answer_emotion_div').css('display') == 'none')
					{
						$('#answer_emotion_div').css('display', 'block');
					}
					else
					{
						$('#answer_emotion_div').css('display', 'none');
					}		
					return;
				}
				
				$(this).attr('rel', '1');
				$(this).addClass("isclicked");
				$('#post_emotion_ul_2 li').clone().appendTo('#replay_emotion_ul_2');
				$('#answer_emotion_div').css('display', 'block');
				$('#replay_emotion_ul_2 li').click(function()
				{
					$('#answerText').focus();
					var emId = this.className.substring(2);
					if($('#answerText').val() == '我也要来说两句……')
					{
					   $('#answerText').val('');			   
					}
					var sFace = '[em:' + emId + ':]';
					
					var myObj = document.getElementById('answerText');
					if (document.selection)
					{ // IE…
						var Sel = document.selection.createRange(); 
						Sel.text = sFace;
						Sel.moveStart('character', -myObj.value.length);
						
					}
					else
					{
						var sTemp = $('#answerText').val();
						var length = myObj.selectionStart + sFace.length;
						$('#answerText').val(sTemp.substring(0,myObj.selectionStart) + sFace + sTemp.substring(myObj.selectionEnd));
						myObj.setSelectionRange(length,length);
					}			
					$('#answer_emotion_div').css('display', 'none');
					
				});
			});		
			$('.answer_text').focus();
			$('#replyForm').ajaxForm(function(data) {   
                  var str=$("root",data).text();        
                  $('#c_'+iCommentId).html(str);
                             
                 
       
         }); 
		});
		
		$('.delComA').live('click', function()
		{
			var iCommentId = $(this).parent().parent().attr('name');
			var iUserUin = $(this).parent().parent().attr('rel');
			var iIsTop = $(this).parent().parent().attr('rev');
			//删除评论 hmf
			var reqUrl = '/index.php?ac=comment&type='+iType+'&inajax=1&op=delete&appid=' + iGameId 
				+ '&commentid=' + iCommentId + '&topflag=' + iIsTop + '&topicuin=' + iUserUin + '&r=' + Math.random();
			
			    $.ajax({
		        type: "get",
		        url: reqUrl,
		        beforeSend: function(XMLHttpRequest){
			       $('#ajaxwaitid').html("loading....");
		        },
		        success: function(data, textStatus){			    
			         $('#c_'+iCommentId).hide();
			         
		        },
		        complete: function(XMLHttpRequest, textStatus){
			        $('#ajaxwaitid').hide();
		        }
		        });
		});	
		
		$('#quickcommentform').ajaxForm(function(data) { 
			   var str=$("root",data).text();
			   if($("#count").text()=="0"){
				   $("#commentDl").html("");
				   $("#count").text("1");
			   }else{
					 $("#count").text(parseInt($("#count").text())+1);  
			   }
			   $(".errorinfo").remove();
               $("#commentDl").append(str);
               $("#commentText").val("");
               $("#showtips").html("发表评论成功");       
         }); 
		
		//表情
		$('#post_emotion_ul_1 li:lt(12)').click(function()
		{
			var emId = this.className.substring(4);
			
			$('#commentText').focus();
			if($('#commentText').val() == '我也要来说两句……')
			{
			   $('#commentText').val('');			   
			}
			var sFace = '[em:' + emId + ':]';
			
			var myObj = document.getElementById('commentText');
			if (document.selection)
			{ // IE…
				var Sel = document.selection.createRange(); 
				Sel.text = sFace;
				Sel.moveStart('character', -myObj.value.length);
			}
			else
			{
				var sTemp = $('#commentText').val();
				var length = myObj.selectionStart + sFace.length;
				$('#commentText').val(sTemp.substring(0,myObj.selectionStart) + sFace + sTemp.substring(myObj.selectionEnd));
				myObj.setSelectionRange(length,length);
			}
			$('#emotion_detail_div').css('display', 'none');
			//$('#commentText').focus();
			
		});
		
		$('#post_emotion_ul_1 li:eq(12)').click(function()
		{
			if ($('#emotion_detail_div').css('display') == 'none')
			{
				$('#emotion_detail_div').css('display', 'block');
			}
			else
			{
				$('#emotion_detail_div').css('display', 'none');
			}
			
		});
		$('#post_emotion_ul_2 li').click(function()
		{		    
			var emId = this.className.substring(2);
			$('#commentText').focus();
			if($('#commentText').val() == '我也要来说两句……')
			{
			   $('#commentText').val('');			   
			}
			var sFace = '[em:' + emId + ':]';
			
			var myObj = document.getElementById('commentText');
			if (document.selection)
			{ // IE…
				var Sel = document.selection.createRange(); 
				Sel.text = sFace;
				Sel.moveStart('character', -myObj.value.length);
			}
			else
			{
				var sTemp = $('#commentText').val();
				var length = myObj.selectionStart + sFace.length;
				$('#commentText').val(sTemp.substring(0,myObj.selectionStart) + sFace + sTemp.substring(myObj.selectionEnd));
				myObj.setSelectionRange(length,length);
			}
			$('#emotion_detail_div').css('display', 'none');
			
		});

}

function submitComment(opFlag)
{	
	if (opFlag == 1)
	{
	    if ($('#answerText').val().length < 5)
		{
			alert('您发表的评论不足5个字，请填写评论内容');
			return;
		}
		if ($('#answerText').val().length > 500)
		{
			alert('您发表的评论超过500字，请修改或分成两条发表');
			return;
		}
		
        $('#replyForm').submit();

    }
}