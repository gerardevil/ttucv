var restarea=6;var maxspeed=7;var maxwidth=1000;var startpos=0;var endofgallerymsg='<span style="font-size: 11px;">End of Gallery</span>';function enlargeimage(path,optWidth,optHeight){var actualWidth=typeof optWidth!="undefined"?optWidth:"600px"
var actualHeight=typeof optHeight!="undefined"?optHeight:"64x"
var winattributes="width="+actualWidth+",height="+actualHeight+",resizable=yes"
window.open(path,"",winattributes)}
var iedom=document.all||document.getElementById,scrollspeed=0,movestate='',actualwidth='',cross_scroll,ns_scroll,statusdiv,loadedyes=0,lefttime,righttime;function ietruebody(){return(document.compatMode&&document.compatMode!="BackCompat")?document.documentElement:document.body;}
function creatediv(){statusdiv=document.createElement("div")
statusdiv.setAttribute("id","statusdiv")
document.body.appendChild(statusdiv)
statusdiv=document.getElementById("statusdiv")
statusdiv.innerHTML=endofgallerymsg}
function positiondiv(){var mainobjoffset=getposOffset(crossmain,"left"),menuheight=parseInt(crossmain.offsetHeight),mainobjoffsetH=getposOffset(crossmain,"top");statusdiv.style.left=mainobjoffset+(menuwidth/2)-(statusdiv.offsetWidth/2)+"px";statusdiv.style.top=menuheight+mainobjoffsetH+"px";}
function showhidediv(what){if(endofgallerymsg!=""){positiondiv();statusdiv.style.visibility=what;}}
function getposOffset(what,offsettype){var totaloffset=(offsettype=="left")?what.offsetLeft:what.offsetTop;var parentEl=what.offsetParent;while(parentEl!=null){totaloffset=(offsettype=="left")?totaloffset+parentEl.offsetLeft:totaloffset+parentEl.offsetTop;parentEl=parentEl.offsetParent;}
return totaloffset;}
function moveleft(){if(loadedyes){movestate="left";if(iedom&&parseInt(cross_scroll.style.left)>(menuwidth-actualwidth)){cross_scroll.style.left=parseInt(cross_scroll.style.left)-scrollspeed+"px";showhidediv("hidden");}
else
showhidediv("visible");}
lefttime=setTimeout("moveleft()",10);}
function moveright(){if(loadedyes){movestate="right";if(iedom&&parseInt(cross_scroll.style.left)<0){cross_scroll.style.left=parseInt(cross_scroll.style.left)+scrollspeed+"px";showhidediv("hidden");}
else
showhidediv("visible");}
righttime=setTimeout("moveright()",10);}
function motionengine(e){var mainobjoffset=getposOffset(crossmain,"left"),dsocx=(window.pageXOffset)?pageXOffset:ietruebody().scrollLeft,dsocy=(window.pageYOffset)?pageYOffset:ietruebody().scrollTop,curposy=window.event?event.clientX:e.clientX?e.clientX:"";curposy-=mainobjoffset-dsocx;var leftbound=(menuwidth-restarea)/2;var rightbound=(menuwidth+restarea)/2;if(curposy>rightbound){scrollspeed=(curposy-rightbound)/((menuwidth-restarea)/2)*maxspeed;clearTimeout(righttime);if(movestate!="left")moveleft();}
else if(curposy<leftbound){scrollspeed=(leftbound-curposy)/((menuwidth-restarea)/2)*maxspeed;clearTimeout(lefttime);if(movestate!="right")moveright();}
else
scrollspeed=0;}
function contains_ns6(a,b){if(b!==null)
while(b.parentNode)
if((b=b.parentNode)==a)
return true;return false;}
function stopmotion(e){if(!window.opera||(window.opera&&e.relatedTarget!==null))
if((window.event&&!crossmain.contains(event.toElement))||(e&&e.currentTarget&&e.currentTarget!=e.relatedTarget&&!contains_ns6(e.currentTarget,e.relatedTarget))){clearTimeout(lefttime);clearTimeout(righttime);movestate="";}}
function fillup(){if(iedom){crossmain=document.getElementById?document.getElementById("motioncontainer"):document.all.motioncontainer;if(typeof crossmain.style.maxWidth!=='undefined')
crossmain.style.maxWidth=maxwidth+'px';menuwidth=crossmain.offsetWidth;cross_scroll=document.getElementById?document.getElementById("motiongallery"):document.all.motiongallery;actualwidth=document.getElementById?document.getElementById("trueContainer").offsetWidth:document.all['trueContainer'].offsetWidth;if(startpos)
cross_scroll.style.left=(menuwidth-actualwidth)/startpos+'px';crossmain.onmousemove=function(e){motionengine(e);}
crossmain.onmouseout=function(e){stopmotion(e);showhidediv("hidden");}}
loadedyes=1
if(endofgallerymsg!=""){creatediv();positiondiv();}
if(document.body.filters)
onresize()}
window.onload=fillup;onresize=function(){if(typeof motioncontainer!=='undefined'&&motioncontainer.filters){motioncontainer.style.width="0";motioncontainer.style.width="";motioncontainer.style.width=Math.min(motioncontainer.offsetWidth,maxwidth)+'px';}
menuwidth=crossmain.offsetWidth;cross_scroll.style.left=startpos?(menuwidth-actualwidth)/startpos+'px':0;}