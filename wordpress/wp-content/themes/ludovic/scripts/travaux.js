( function ( $ ) {
	"use strict";
	var $slider,
		iPosNow,
		iPosMin,
		iPosMax,
		iNumber,
		iWidth,
		iStep,
		$previous,
		$next;

	var positionDepart = function(){
		iPosNow = iPosMin = 0;//(window.outerWidth-iWidth)/2;
		//iPosMax = iPosMin - (1050*(iNumber-1));
		iStep = Math.floor(107+(5*(iNumber)));
		iPosMax = iPosMin - (iStep*(iNumber-1));
		$slider.css({width:((iNumber+1)*105)-5+'%'});
		$slider.find('li').css({width:Math.floor(100/(iNumber+1))+'%'});
		//iStep = iWidth +202;
		// 3 => 122
		// 4 => 127
		// 5 => 132

		// 210% -> 47% -> 16%
		// 315% -> 31% -> 8.5%
		// 420% -> 23.5% -> 4.5%
		// 525% -> 19% ->
		iStep = Math.floor(107+(5*(iNumber)));
		$next.hide();
		$previous.hide();
		afficheFleche();
   		//$slider.css({marginLeft:iPosMin});
	}; //positionDepart

	var changePosition = function(e){
		$next.hide();
		$previous.hide();
		if(e.currentTarget.id == "next"){
			iPosNow-=iStep;
		}
		if(e.currentTarget.id == "previous"){
			iPosNow+=iStep;
		}
		$slider.animate({marginLeft:iPosNow+'%'},800,'swing',function(){
			afficheFleche();
		});
	}; //changePosition

	var afficheFleche = function(e){
		if(iPosNow < iPosMin){
			$previous.show();
		}
		if(iPosNow > iPosMax)
		{
			$next.show();
		}
	}; //afficheFleche

   $(function(){
   		$slider = $('#slider ul');
   		$previous = $('#previous');
   		$next = $('#next');
   		iNumber = $slider.find('li').length;
   		iWidth = $slider.find('li').width();

   		positionDepart();

   		$previous.on('click',changePosition);
   		$next.on('click',changePosition);
   		/*$previous.on('click',function(){
   			$slider.animate({marginLeft:iPosNow-1050},800,function(){
   				console.log(iPosNow);
   				iPosNow-=1050;
   			});
   		});
   		$next.on('click',function(){
   			$slider.animate({marginLeft:iPosNow+1050},800,function(){
   				console.log(iPosNow);
   				iPosNow+=1050;
   			});
   		});*/

      /*setInterval(function(){  
         $("#slider ul").animate({marginLeft:-1050},800,function(){  
            $(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));  
         })  
      }, 3500); */
   });

}( jQuery ) );