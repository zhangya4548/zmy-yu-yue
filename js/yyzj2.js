document.writeln('<script type="text/javascript" src="/js/jquery.min.js"></script>')
document.writeln("<style>");
document.writeln('*{padding:0;margin:0;}ul,li{list-style:none;}.yytime{min-width:320px;max-width:720px;width:96%;margin:0 auto;font-size:0.5rem;margin-bottom:1em;}.yytime h1{text-align:center;color:#74b0ee;font-size:0.7rem;width:100%;font-weight:bold;margin:1em 0}.yytable{overflow:hidden;}.yytable li{box-sizing:border-box;}.yyzj_left{float:left;overflow:hidden;width:50%;text-align:center;}.yyzj_left ul{float:left}.yyzj_left li{line-height:42px;height:42px;border-top:1px solid #C2E4FF;border-right:1px solid #CAE8FF;border-bottom:1px solid #ADD9FF;border-left:1px solid #A1D2FF;}.yyzj_left li:nth-child(1){border-top:none;border-right:1px solid #0C82C4;border-left:1px solid #024698;border-bottom:none;}.yyzj_left li:nth-child(2){border-top:none;}.yyzj_left li:last-child{border-bottom:none;}@media screen and (min-width:720px){.yyzj_left li{line-height:42px!important;}}.yyzj_left .li1{height:71px;line-height:71px!important;font-weight:bold;background-color:#0565B3;color:#fff;}.yyzj_left .yyzj_name{width:30%;}.yyzj_left .yyzj_post{width:45%}.yyzj_left .yyzj_name li{line-height:42px;border-left:none;}@media screen and (min-width:345px){.yyzj_left .yyzj_post li:nth-child(2){line-height:42px}.yyzj_left .yyzj_post li:nth-child(3){line-height:42px}.yyzj_left .yyzj_post li:nth-child(4){line-height:42px;}.yyzj_left .yyzj_post li:nth-child(5){line-height:42px;}}.yytime ul{overflow:hidden}.yyzj_center{overflow:hidden;width:100%}.yyzj_center li{float:left;text-align:center;height:50px;width:14.28%;overflow:hidden;cursor:pointer;}#monitor{background-color:#fff;}#monitor li{line-height:25px;color:#666;border-bottom:none;border-left:1px solid #666;border-bottom:1px solid #666;}.yytime .mon{overflow:hidden;border:1px solid #666;border-left:none;border-bottom:none;}.yytime h2{font-size:0.5rem;text-align:center;color:#000;font-weight:bold;height:28px;line-height:28px;}.yyzj_price{width:25%;}.yyzj_price li{border-right:1px solid #A1D2FF;}.zj_show_on{background-color:#FEA154;color:#fff!important;}.zjjs{margin-top:15px;}.zjjs li img{width:15%;float:left;}.zjjs .zjpbjs{float:left;width:80%;margin-left:5%;margin-top:10px;}.zjjs .zjpbjs h3{color:#000;font-size:1.2em;}.zjjs .zjpbjs p{margin-top:10px;font-size:1em;}.zjpblb{background-color:#F6F6F6;overflow:hidden;margin:5px 0;padding:5px 0;}')

document.writeln("<\/style>");

document.write('<div class="yytime">');
document.write('<h1>专家近期门诊排班表</h1>');
document.write('<div class="yytable">');
document.write('<div class="yyzj_center">');
document.write('<div class="mon">');
document.write('<ul id="monitor">');
document.write('<li id="zjT1" class="zj_show_on" onMouseOver="PanShow(\'zj\',\'zj_show\',1,35)"></li>');
document.write('</div>');
document.write('</div>');
document.write('<ul class="zjjs">');
document.write('<li id="zj1" style="">');
document.write('<div class="zjpblb"><img src="/img/001.jpg"/><div class="zjpbjs"><h3>聂斌</h3><p>擅长：灵活运用中医辩证施治技术，四诊合参，擅长运用针灸、针刀技术治疗各种常见骨伤科疾病。...</p></div></div>');
document.write('<div class="zjpblb"><img src="/img/002.jpg"/><div class="zjpbjs"><h3>刘昭</h3><p>擅长：断指、断肢再植，四肢创伤性骨折、创面皮瓣修复、骨软组织缺损移植修复、重建，慢性创面修复，细胞再生技术。...</p></div></div>');
document.write('<div class="zjpblb"><img src="/img/003.jpg"/><div class="zjpbjs"><h3>王昌兴</h3><p>擅长：复杂骨关节创伤的诊治，如严重的三度开放性骨折，以及复杂骨盆(包括髋臼)骨折的治疗，四肢严重损伤的修复与重建术以及严重复合伤的抢救。...</p></div></div>');
document.write('<div class="zjpblb"><img src="/img/004.jpg"/><div class="zjpbjs"><h3>汤志刚</h3><p>擅长：复杂骨折、关节病、关节创伤的中西医治疗及运动创伤与关节镜的微创治疗;运用中医手法整复，中药内服治疗四肢骨折、关节脱位及手术治疗复杂骨折(包括髋臼骨折、骨盆骨折、脊柱骨折和各种关节内骨折);小针刀松解关节疾病;各种运动创伤。...</p></div></div>');
document.write('<div class="zjpblb"><img src="/img/005.jpg"/><div class="zjpbjs"><h3>姜滔</h3><p>擅长：肩、膝关节疾病诊断和治疗，关节镜下微创治疗膝关节滑膜炎，半月板损伤，膝多发韧带损伤，髌骨习惯性脱位，肩周炎，巨大肩袖损伤，肩关节习惯性脱位，以及关节周围各种骨折微创治疗术。...</p></div></div>');
document.write('</li>');

document.write('</ul>'); 
document.write('</div>'); 
document.write('</div>');

 $(document).ready( function(){  
	  var html = $(".zjjs").children("li:eq(0)").html();
	  for(var i = 2;i<=35;i++){
		  $("#monitor").append("<li id="+"zjT"+i+" class=\"zj_show_off\" onMouseOver=\"PanShow(\'zj\',\'zj_show\',"+i+",35)\"></li>");
		  $(".zjjs").append("<li id="+"zj"+i+" style='display:none'></li>");
	  }
	  $(".zjjs").children("li").html(html);
      var cells = document.getElementById('monitor').getElementsByTagName('li');
      var clen = cells.length;
      var currentFirstDate;
      var formatDate = function(date){       
        var year = date.getFullYear()+'年';
        var month = (date.getMonth()+1)+'/';
        var day = date.getDate();
        var week = ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'][date.getDay()]; 
        return week+"<br/>"+month+day;
		
      };
	  
	  
      var addDate= function(date,n){    
        date.setDate(date.getDate()+n);    
        return date;
      };
      var setDate = function(date){
		   var hour = date.getHours();
        for(var i = 0;i<clen;i++){ 
			
          cells[i].innerHTML = formatDate(i==0 ? date : addDate(date,1));
		  /* if(hour>15&&i==0){
				$("#zj1").children("li:eq("+i+")").text("约满");
				$("#zj2").children("li:eq("+i+")").text("约满");
				$("#zj3").children("li:eq("+i+")").text("约满");
				$("#zj4").children("li:eq("+i+")").text("约满");
			}*/
		  var c = "li:eq("+i+")";
		  var s =cells[i].innerHTML;
		  
		   var a = s.indexOf("星期一");
			if(a>=0){
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(0)").css("display","none");
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(1)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(2)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(3)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(4)").css("display","none");
			}
			var a = s.indexOf("星期二");
			if(a>=0){
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(0)").css("display","none");
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(1)").css("display","none");
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(2)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(3)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(4)").css("display","none");
			}
		  var a = s.indexOf("星期三");
			if(a>=0){
				
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(0)").css("display","none");
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(1)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(2)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(3)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(4)").css("display","none");
			}
			var a = s.indexOf("星期四");
			if(a>=0){
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(0)").css("display","none");
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(1)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(2)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(3)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(4)").css("display","none");
			}
			var a = s.indexOf("星期五");
			if(a>=0){
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(0)").css("display","none");
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(1)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(2)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(3)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(4)").css("display","none");
			}
			var a = s.indexOf("星期六");
			if(a>=0){
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(0)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(1)").css("display","none");
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(2)").css("display","none");
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(3)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(4)").css("display","none");
			}
			var a = s.indexOf("星期日");
			if(a>=0){
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(0)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(1)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(2)").css("display","none");
				$(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(3)").css("display","none");
				// $(".zjjs").children("li:eq("+i+")").children(".zjpblb:eq(4)").css("display","none");
			}
			
        }
		
		 
      };       
       
      setDate(new Date());
    });
  
  (function (){


	var rootHtml = $(":root");


	var rootResize = function (){


		var fontSize =$(window).width()<640?$(window).width()/16:40;


		rootHtml.css("font-size",fontSize);	


	}


	rootResize();


	$(window).resize(function (){


		rootResize();


	});


})();
