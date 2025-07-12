function gamesNav_int(adimgthumb,adimgbig,adurl){

var d = document,
	$ = function(o) {
			return d.getElementById(o)
		},
	cDiv = d.createElement("div"),
	rd = Math.random(),
	css_link = "http://act.uu.cc/gamesnav/";
	l = function(u) {
			var s = d.createElement("link");
			s.href = u;
			s.rel = "stylesheet";
			s.type = "text/css"
			d.getElementsByTagName("head")[0].appendChild(s);
			return s
		}
	int = function() {
			l(css_link + "gamesNav.css?ran=" + rd, "link");
			cDiv.className = "gamesNav_box";
			cDiv.id = "gamesNav_box";
			cDiv.style.cssText = "position:absolute;top:-500px;";
			cDiv.innerHTML = '<ul class="gamesNav_inner gamesNav_lsn"><li class="gamesNav_logo gamesNav_fl"><a href="http://www.idreamsky.com/" class="gamesNav_blnk gamesNav_hdn" title="乐逗游戏" target="_blank">乐逗游戏</a></li><li id="gamesNav_g" class="gamesNav_ad gamesNav_fl"></li><li class="gamesNav_fr gamesNav_links"><a href="javascript:alert('+"'商城建设中，敬请期待！'"+')" target="_blank">乐逗游戏商城</a></li><li class="gamesNav_total gamesNav_ml10 gamesNav_fr"><h3 class="gamesNav_title" id="gamesNav_t">乐逗游戏排行榜<i class="gamesNav_icon_arrow"></i></h3><div class="gamesNav_pop" id="gamesNav_p"></div></li></ul><div id="gamesNav_d" class="gamesNav_big"></div>';
			d.body.appendChild(cDiv);
			
			var gg = $("gamesNav_g"),
				gd = $("gamesNav_d"),
				isHtmlInsert = false,
				topadImgThumb = adimgthumb,
				topadImg = adimgbig,
				topadUrl = adurl;
			gg.innerHTML = '<div id="gamesNav_go"><span></span><img class="gamesNav_nb" src="' + topadImgThumb + '" alt=""/></div>';
			gg.onmouseover = gd.onmouseover = function() {
				gd.style.display = "block";
				$("gamesNav_go").style.display = "none";
				if (!isHtmlInsert) {
					gd.innerHTML = '<a href="' + topadUrl + '" target="_blank"><img class="gamesNav_nb" src="' + topadImg + '" alt=""/></a>'
				}
				isHtmlInsert = true
			};
			gg.onmouseout = gd.onmouseout = function() {
				gd.style.display = "none";
				$("gamesNav_go").style.display = "block"
			}
			
			var eventUtil = {
				addListener: function(element, type, hander) {
					if (element.addEventListener) {
						element.addEventListener(type, hander, false)
					} else if (element.attachEvent) {
						element.attachEvent('on' + type, hander)
					} else {
						element['on' + type] = hander
					}
				},
				getEvent: function(event) {
					return event || window.event
				},
				getTarget: function(event) {
					return event.target || event.srcElement
				},
				preventDefault: function(event) {
					if (event.preventDefault) {
						event.preventDefault()
					} else {
						event.returnValue = false
					}
				},
				removeListener: function(element, type, hander) {
					if (element.removeEventListener) {
						element.removeEventListener(type, hander, false)
					} else if (element.deattachEvent) {
						element.detachEvent(type, hander)
					} else {
						element['on' + type] = null
					}
				},
				stopPropagation: function(event) {
					if (event.stopPropagation) {
						event.stopPropagation()
					} else {
						event.cancelBubble = true
					}
				}
			};
			p = $("gamesNav_p");
			t = $("gamesNav_t");
			eventUtil.addListener(t, "mouseover", function(event) {
				t.className = "gamesNav_title gamesNav_h55 gamesNav_title_hover";
				p.innerHTML = '<iframe id="gameRank" name="gameRank" allowTransparency="true" style="background:transparent;" src="http://act.uu.cc/gamesnav/game_rank.php?rd=' + rd + '" width="980" height="220" frameBorder="0" scrolling="no"></iframe></div>';
				p.style.display = "block";
				eventUtil.stopPropagation(event)
			});
			eventUtil.addListener(p, "mouseover", function(event) {
				t.className = "gamesNav_title gamesNav_h55 gamesNav_title_hover";
				p.style.display = "block";
				eventUtil.stopPropagation(event)
			});
			eventUtil.addListener(t, "mouseout", function(event) {
				p.style.display = "none";
				t.className = "gamesNav_title gamesNav_h55";
				eventUtil.stopPropagation(event)
			});
			eventUtil.addListener(p, "mouseout", function(event) {
				p.style.display = "none";
				t.className = "gamesNav_title gamesNav_h55";
				eventUtil.stopPropagation(event)
			})
		}()
	};
function gamesNav_chk() {
	setTimeout(function() {
		if (document.getElementById("gamesNav_g")) {
			if (window.detachEvent) {
				window.detachEvent("onload", gamesNav_chk)
			} else {
				window.removeEventListener("load", gamesNav_chk, false)
			}
		} else {
			$.ajax({
			     type: 'POST',
			     url: 'http://act.uu.cc/activity/gamesnav/ad.php' ,
			    //data: data ,
			    success: function(resp){
			    	gamesNav_int(resp.data.adimgthumb,resp.data.adimgbig,resp.data.adurl)
			    } ,

			    dataType: 'json'
			});	
		}
	}, 500)
};
if (window.attachEvent) {
	window.attachEvent("onload", gamesNav_chk)
} else {
	window.addEventListener("load", gamesNav_chk, false)
};