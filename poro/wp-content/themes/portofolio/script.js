$(function(){
	var $figs = $('#diapo>img');
	$figs.not(":first").hide();
	setInterval(switchImg,5000);
	
	function switchImg()
	{
		
		var $nextImage = $figs.filter(":visible").next();
		
		if($nextImage.size() == 0)
			$nextImage = $figs.first();
		
		$figs.filter(":visible").fadeOut("fast",function(){
			$nextImage.fadeIn("fast");
		});
	}
})