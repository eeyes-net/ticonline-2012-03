window.onload = function(){
	    $('#down').hover(function(){
		$('ul.menu1').css('display','block');   //鼠标移上去显示隐藏
	},function(){
		$('ul.menu1').css('display','none')
	});
	
	$('#down1').hover(function(){
		$('ul.more1').css('display','block');
	},function(){
		$('ul.more1').css('display','none')
	});
	
	//点击左移
	$(".slider-list li:first-child").addClass("active");
	$(".slider-control .r").click(function(){
		right();
	})
	$(".slider-control .l").click(function(){
		left();
	})     
 //鼠标移上去变为背景变为k状态
	$(".slider-control .l").hover(
       function(){ $(this).addClass("k1").removeClass("l") },
       function(){ $(this).removeClass("k1").addClass("l") }                   
)
	
		$(".slider-control .r").hover(
       function(){ $(this).addClass("k2").removeClass("r") },
       function(){ $(this).removeClass("k2").addClass("r") }
)	
	//订票处变色程序
	$(".j1").hover(
       function(){ $(".j1").addClass("mokuai1").removeClass("mokuai");
			$(".j1 .huodong").addClass("huodong1").removeClass("huodong");
			$(".j1 .circled").addClass("circled1").removeClass("circled");
			$(".j1 .shijian").addClass("shijian1").removeClass("shijian");
			$(".j1 .didian").addClass("didian1").removeClass("didian");
																		
																		
																		
																		},
       function(){ $(".j1").removeClass("mokuai1").addClass("mokuai");
	   $(".j1 .huodong1").addClass("huodong").removeClass("huodong1");
	   $(".j1 .circled1").addClass("circled").removeClass("circled1");
	   $(".j1 .shijian1").addClass("shijian").removeClass("shijian1");
	   $(".j1 .didian1").addClass("didian").removeClass("didian1");
	   }                   
	   )
	   	$(".j2").hover(
       function(){ $(".j2").addClass("mokuai1").removeClass("mokuai");
			$(".j2 .huodong").addClass("huodong1").removeClass("huodong");
			$(".j2 .circled").addClass("circled1").removeClass("circled");
			$(".j2 .shijian").addClass("shijian1").removeClass("shijian");
			$(".j2 .didian").addClass("didian1").removeClass("didian");
																		
																		
																		
																		},
       function(){ $(".j2").removeClass("mokuai1").addClass("mokuai");
	   $(".j2 .huodong1").addClass("huodong").removeClass("huodong1");
	   $(".j2 .circled1").addClass("circled").removeClass("circled1");
	   $(".j2 .shijian1").addClass("shijian").removeClass("shijian1");
	   $(".j2 .didian1").addClass("didian").removeClass("didian1");
	   }                   
	   )
	   	$(".j3").hover(
       function(){ $(".j3").addClass("mokuai1").removeClass("mokuai");
			$(".j3 .huodong").addClass("huodong1").removeClass("huodong");
			$(".j3 .circled").addClass("circled1").removeClass("circled");
			$(".j3 .shijian").addClass("shijian1").removeClass("shijian");
			$(".j3 .didian").addClass("didian1").removeClass("didian");
																		
																		
																		
																		},
       function(){ $(".j3").removeClass("mokuai1").addClass("mokuai");
	   $(".j3 .huodong1").addClass("huodong").removeClass("huodong1");
	   $(".j3 .circled1").addClass("circled").removeClass("circled1");
	   $(".j3 .shijian1").addClass("shijian").removeClass("shijian1");
	   $(".j3 .didian1").addClass("didian").removeClass("didian1");
	   }                   
	   )	
	   	$(".j4").hover(
       function(){ $(".j4").addClass("mokuai1").removeClass("mokuai");
			$(".j4 .huodong").addClass("huodong1").removeClass("huodong");
			$(".j4 .circled").addClass("circled1").removeClass("circled");
			$(".j4 .shijian").addClass("shijian1").removeClass("shijian");
			$(".j4 .didian").addClass("didian1").removeClass("didian");
																		
																		
																		
																		},
       function(){ $(".j4").removeClass("mokuai1").addClass("mokuai");
	   $(".j4 .huodong1").addClass("huodong").removeClass("huodong1");
	   $(".j4 .circled1").addClass("circled").removeClass("circled1");
	   $(".j4 .shijian1").addClass("shijian").removeClass("shijian1");
	   $(".j4 .didian1").addClass("didian").removeClass("didian1");
	   }                   
	   )
	
	//顶部四大活动变色
	$(".m1").hover(
       function(){ $(".m1").addClass("ds2").removeClass("ds1");															
																		
																		},
       function(){ $(".m1").removeClass("ds2").addClass("ds1");
	   }                   
	   )
	$(".m2").hover(
       function(){ $(".m2").addClass("ds2").removeClass("ds1");															
																		
																		},
       function(){ $(".m2").removeClass("ds2").addClass("ds1");
	   }                   
	   )
	$(".m3").hover(
       function(){ $(".m3").addClass("ds2").removeClass("ds1");															
																		
																		},
       function(){ $(".m3").removeClass("ds2").addClass("ds1");
	   }                   
	   )	
	$(".m4").hover(
       function(){ $(".m4").addClass("ds2").removeClass("ds1");															
																		
																		},
       function(){ $(".m4").removeClass("ds2").addClass("ds1");
	   }                   
	   )	
	$(".m5").hover(
       function(){ $(".m5").addClass("dl1").removeClass("dl");															
																		
																		},
       function(){ $(".m5").removeClass("dl1").addClass("dl");
	   }                   
	   )		

	
	
	
	//↓ 为下一页上一页的代码
	
	$(".next1").on("click",".showNextCode1",function(){
		$(".lastdiv1").show(500);
		$(this).removeClass("hideCode").addClass("showHideCode");
		$(".nextdiv1").hide(500)
		$(this).removeClass("showHideCode").addClass("hideCode");

	});
	$(".last1").on("click",".showLastCode1",function(){
		$(".nextdiv1").show(500);
		$(this).removeClass("hideCode").addClass("showHideCode");
		$(".lastdiv1").hide(500)
		$(this).removeClass("showHideCode").addClass("hideCode");

	});

	$(".next2").on("click",".showNextCode2",function(){
		$(".lastdiv2").show(500);
		$(this).removeClass("hideCode").addClass("showHideCode");
		$(".nextdiv2").hide(500)
		$(this).removeClass("showHideCode").addClass("hideCode");

	});
	$(".last2").on("click",".showLastCode2",function(){
		$(".nextdiv2").show(500);
		$(this).removeClass("hideCode").addClass("showHideCode");
		$(".lastdiv2").hide(500)
		$(this).removeClass("showHideCode").addClass("hideCode");

	});
		//点击后弹出拟态框的代码
		//上传的拟态框
	var oTop = document.getElementById('zhedang');//黑色背景代码
	var oSet1 = document.getElementById('set1');   //按钮激活代码
	var oCha1 = document.getElementById('cha1');    //关闭代码
	var oSetBox1 = document.getElementById('shangchuan');//拟态框主体
				oSet1.onclick = function(){
				oTop.style.display = 'block';
				oSetBox1.style.display = 'block';
			}
			oCha1.onclick = function(){
				oTop.style.display = 'none';
				oSetBox1.style.display = 'none';
			}
	
	
	
	
	
	
	
}
function right(){
	if($(".active").index()!=$(".slider-list li:last-child").index()){
		$(".active").animate({
			opacity:"0"
		},1000).removeClass("active").next().animate({
			opacity:"1"
		},1000).addClass("active");
	}else{
		$(".active").animate({
			opacity:"0"
		},1000).removeClass("active");
		$(".slider-list li:first-child").animate({
			opacity:"1"
		},1000).addClass("active");
	}
}
function left(){
	if($(".active").index()!=0){
		$(".active").animate({
			opacity:"0"
		},1000).removeClass("active").prev().animate({
			opacity:"1"
		},1000).addClass("active");
	}else{
		$(".active").animate({
			opacity:"0"
		},1000).removeClass("active");
			$(".slider-list li:last-child").animate({
				opacity:"1"
		},1000).addClass("active");
	}
}  
 

 function showHideCode(){ 

             $("#showdiv").toggle(); 

          } 