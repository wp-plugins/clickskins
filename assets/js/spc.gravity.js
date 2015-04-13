(function($)
{
	'use strict';

	$.fn.spcGravity = function(options)
	{
			
			
			var defaults = {
					apples: [], 
					totalApples: 10, 
					appleLink: false,
					g: 20,
					frequency: 1,
					textMode: false,
					zIndex: 999999, 
					opacity: 1,
					color: '#F8991D', 
					width: '100px', 
					height: '100px',
					maxSize  : 50, 
					minSize:50, 
					wind: false,
					active_area: 'Complete Page' 
					
				},
			
			classDope = randStringGen(4),
			apple,
			$apple,
			$head = $('head'),	
			$container,
			position,
			left,
			style='',
			size,
			windCss = false,
			delay,
			initialDelays,
			speed,
			appleWind,
			i;		
	
			options = $.extend({}, defaults, options);	

			if(options.apples.length === 0) {return this};	

			var random = function random(min, max){
				
				min = (typeof min === 'number') ? min : 0;
				max = (typeof max === 'number') ? max : Number.MAX_VALUE;
                return Math.round(min + Math.random()*(max-min)); 
            }	
			
			return this.each
			(function() 
				 {

					$container = $(this), position = 'fixed'; 
					if($.inArray($container[0].nodeName.toLowerCase(), ['html', 'body']) === -1){
						$container.css({position: 'relative', overflow: 'hidden'}), position = 'absolute';
					}
					
					
					
					
					speed = parseInt(options.g) + parseInt(options.frequency);
					delay = 0; //initial delay
					
					if(options.wind)
					{
						if(options.wind == 'left'){ appleWind='windLeft';   windCss = getWindCss(options);}	
						else if(options.wind == 'right'){ appleWind='windRight'; windCss = getWindCss(options);}
						else if(options.wind == 'reverse'){ appleWind='windReverse';   windCss = getWindCss(options); }
						else if(options.wind == 'rleft'){ appleWind='windReverseLeft';   windCss = getWindCss(options); }
						else if(options.wind == 'rright'){ appleWind='windReverseRight';   windCss = getWindCss(options); }
						
					}else{
						
						windCss = getWindCss(options);
						appleWind = 'noWind';	
					}

					apple = options.apples[0];					
					
					if(options.wind == 'reverse' || options.wind == 'rleft' || options.wind == 'rright' ){
							
							style += 'bottom: 0px; ' ;
					}else{
							style += 'top: 0px; ' ;
					}
					
					style += 'position:'+position+'; ';
					style += 'z-index:'+Number(options.zIndex)+'; ';
					//style += 'left:'+left+'%; ';
					style += 'opacity:'+options.opacity+'; ';
					style += 'color:'+options.color+'; ';
					
					style +='animation-name:'+ appleWind+'; ';
					style +='animation-duration:'+ speed+'s; ';
					style +='animation-timing-function: linear; ';
					style +='animation-delay: 0s; ';
					style +='animation-iteration-count: infinite; ';							
					style +='animation-play-state: running; ';
					
					style +='-webkit-animation-name:'+ appleWind+'; ';
					style +='-webkit-animation-duration:'+ speed+'s; ';
					style +='-webkit-animation-timing-function: linear; ';
					style +='-webkit-animation-delay: 0s; ';
					style +='-webkit-animation-iteration-count: infinite; ';							
					style +='-webkit-animation-play-state: running; ';
					
					style +='-moz-animation-name:'+ appleWind+'; ';
					style +='-moz-animation-duration:'+ speed+'s; ';
					style +='-moz-animation-timing-function: linear; ';
					style +='-moz-animation-delay: 0s; ';
					style +='-moz-animation-iteration-count: infinite; ';							
					style +='-moz-animation-play-state: running; ';
					
					style +='-ms-animation-name:'+ appleWind+'; ';
					style +='-ms-animation-duration:'+ speed+'s; ';
					style +='-ms-animation-timing-function: linear; ';
					style +='-ms-animation-delay: 0s; ';
					style +='-ms-animation-iteration-count: infinite; ';							
					style +='-ms-animation-play-state: running; ';
					
					style +='-o-animation-name:'+ appleWind+'; ';
					style +='-o-animation-duration:'+ speed+'s; ';
					style +='-o-animation-timing-function: linear; ';
					style +='-o-animation-delay: 0s; ';
					style +='-o-animation-iteration-count: infinite; ';							
					style +='-o-animation-play-state: running; ';
					
					
					
					
	
					if(windCss){
						$head.append('<style type="text/css">\n' + windCss + '\n</style>');
					}
					
					var browser_width = jQuery(window).width();
					
					for($container = $(this), i=1; i<=options.totalApples; i++ )
					{
						
						if(options.active_area =='Narrow Left'){
							left = 3;
						}else if(options.active_area =='Narrow Right'){
							left = (browser_width-parseInt(options.width));
						}else{
							left = random(0, (browser_width-parseInt(options.width)));
						}
						
						if( left <= 0 ){
							left = 3;	
						}
						
						style += 'left:'+left+'px; ';
						
						//res
						var skin_width =  parseInt(options.width);
						var skin_height = parseInt(options.height);
																								
						if( skin_width >= browser_width )
						{
							//style += 'width:90%; ';
							//skin_height = 'auto';
						}
						
						skin_width = skin_width+'px';
						if(skin_height==NaN)
						{
							skin_height = 'auto';
						}else{
							skin_height = skin_height+'px';
						}
						
						
						if(options.textMode == true )
						{

							if(options.appleLink)
							{
								$apple = '<div class="spc-gravity gtext"  style="'+ style +'"><span style="font-size:'+options.width+'; color:'+options.color+';" class="gt'+classDope+'"><a target="_blank" style="font-size:'+skin_width+'; color:'+options.color+';" href="'+ options.appleLink +'">'+ apple +'</a></span></div>';
							}else{
								$apple = '<div class="spc-gravity gtext"  style="'+ style +'"><span style="font-size:'+skin_width+'; color:'+options.color+';" class="gt'+classDope+'">'+ apple +'</span></div>';
							}
						 
						}else{

							if(options.appleLink)
							{
								$apple = '<div class="spc-gravity gimage"  style="'+ style +'"><span class="gi'+classDope+'" ><a target="_blank" href="'+ options.appleLink +'"><img style="opacity:'+options.opacity+';width:'+ skin_width +';height:'+ skin_height + ';"  src="' + apple + '" class="click-media" /></a></span></div>';
							}else{
								$apple = '<div class="spc-gravity gimage"  style="'+ style +'"><span class="gi'+classDope+'"><img  style="opacity:'+options.opacity+';width:'+ skin_width +';height:'+ skin_height + ';"  src="' + apple + '" class="click-media"/></span></div>';
							}
						}
						
						
						//$apple = '<div class="spc-gravity gtext" style="'+ style +'">'+ apple +'</div>';
						
						$container.append($apple);

					}
						
						


			});

	}
	
	
	function getWindCss(options)
	{

		var windCss = '';
		var direction = options.wind;
		var opacity = options.opacity;
		//alert(jQuery(window).height());;
		var doc_height = jQuery(window).height();
		doc_height = doc_height + (doc_height/options.g)*options.frequency
		
		
		
		if(direction == 'left' )
		{			
			windCss = '@keyframes windLeft {0% {opacity:0;} 0.5% {opacity:'+opacity+';} 100% {opacity:1; transform:translate3D(-500px,'+doc_height+'px, 0) rotate(0deg);}}';				
			windCss += '@-webkit-keyframes windLeft {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -webkit-transform:translate3D(-500px,'+doc_height+'px, 0)  rotate(0deg);}}';				
			windCss += '@-moz-keyframes windLeft {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -moz-transform:translate3D(-500px,'+doc_height+'px, 0) rotate(0deg);}}';				
			windCss += '@-ms-keyframes windLeft {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -ms-transform:translate3D(-500px,'+doc_height+'px, 0) rotate(0deg);}}';
			
		}
		else if(direction == 'right' )
		{			
			windCss = '@keyframes windRight {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; transform:translate3D(600px,'+doc_height+'px, 0) ;}}';			
			windCss += '@-webkit-keyframes windRight {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -webkit-transform:translate3D(600px,'+doc_height+'px, 0) ;}}';			
			windCss += '@-moz-keyframes windRight {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -moz-transform:translate3D(600px,'+doc_height+'px, 0) ;}}';			
			windCss += '@-ms-keyframes windRight {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -ms-transform:translate3D(600px,'+doc_height+'px, 0) ;}}';
		}
		else if(direction == 'reverse' )
		{
			windCss = '@keyframes windReverse {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; transform:translate3D(10px,-'+doc_height+'px, 0) ;}}';			
			windCss += '@-webkit-keyframes windReverse {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -webkit-transform:translate3D(10px,-'+doc_height+'px, 0) ;}}';			
			windCss += '@-moz-keyframes windReverse {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -moz-transform:translate3D(10px,-'+doc_height+'px, 0) ;}}';			
			windCss += '@-ms-keyframes windReverse {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -ms-transform:translate3D(10px,-'+doc_height+'px, 0) ;}}';
		}
		else if(direction == 'rleft' )
		{
			windCss = '@keyframes windReverseLeft {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; transform:translate3D(-500px,-'+doc_height+'px, 0) ;}}';			
			windCss += '@-webkit-keyframes windReverseLeft {0% {opacity:0;} 0.5% {opacity:'+opacity+';} 100% {opacity:1; -webkit-transform:translate3D(-500px,-'+doc_height+'px, 0) ;}}';			
			windCss += '@-moz-keyframes windReverseLeft {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -moz-transform:translate3D(-500px,-'+doc_height+'px, 0) ;}}';			
			windCss += '@-ms-keyframes windReverseLeft {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -ms-transform:translate3D(-500px,-'+doc_height+'px, 0) ;}}';
		}
		else if(direction == 'rright' )
		{
			windCss = '@keyframes windReverseRight {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; transform:translate3D(500px,-'+doc_height+'px, 0) ;}}';			
			windCss += '@-webkit-keyframes windReverseRight {0% {opacity:0;} 0.5% {opacity:'+opacity+';} 100% {opacity:1; -webkit-transform:translate3D(500px,-'+doc_height+'px, 0) ;}}';			
			windCss += '@-moz-keyframes windReverseRight {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -moz-transform:translate3D(500px,-'+doc_height+'px, 0) ;}}';			
			windCss += '@-ms-keyframes windReverseRight {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -ms-transform:translate3D(500px,-'+doc_height+'px, 0) ;}}';
		}
		else{
			
			windCss = '@keyframes noWind {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; transform:translate3D(10px,'+doc_height+'px, 0) rotate(0deg);}}';				
			windCss += '@-webkit-keyframes noWind {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -webkit-transform:translate3D(10px,'+doc_height+'px, 0) rotate(0deg);}}';				
			windCss += '@-moz-keyframes noWind {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -moz-transform:translate3D(10px,'+doc_height+'px, 0) rotate(0deg);}}';				
			windCss += '@-ms-keyframes noWind {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -ms-transform:translate3D(10px,'+doc_height+'px, 0) rotate(0deg);}}';
			windCss += '@-o-keyframes noWind {0% {opacity:0;} 0.5% {opacity:'+ opacity +';} 100% {opacity:1; -ms-transform:translate3D(10px,'+doc_height+'px, 0) rotate(0deg);}}';
				
		}


		
		return windCss;
		
	}
	
	function randStringGen(len)
	{
		var text = "";
	
		var charset = "abcdefghijklmnopqrstuvwxyz0123456789";
	
		for( var i=0; i < len; i++ )
			text += charset.charAt(Math.floor(Math.random() * charset.length));
	
		return text;
	}
	
})(jQuery); 