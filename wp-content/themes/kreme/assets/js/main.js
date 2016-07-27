(function($) {
	"use strict";
	
	$( window ).load(function() {
		
		
		
		// Filter Img & replace to placehold.it
		$('body').imagesLoaded(function() {
			
			var $url =  window.location.href;
			
			$.ajax({
				url: $url,
				cache: false,
			}).done(function( html ) {
				
				var $html = html;
				
				$('body').find('img').each(function() {
					var $this 	= $(this),
						$width 	= $this.width(),
						$height	= $this.height(),
						$src	= "http://placehold.it/" + $width + "x" + $height + "/333";
					
					$html = $html.replace($this.attr("src"), $src); 
					
				});
				//console.log($html);
				
				var image = new Image();
				$( "*" ).each(function(e) {
					var $this = $(this),
						$bg = $this.css('background-image'),
						$style = $this.attr('style');
					
					if ( $bg != 'none' && typeof $style !== "undefined" && $style != 'none' && $style.length > 0 ) {
						image.src = $bg.replace(/url\((['"])?(.*?)\1\)/gi, '$2').split(',')[0];
						
						//console.log(image.src);
						var $width = image.width,
							$height = image.height,
							$src = "http://placehold.it/" + $width + "x" + $height + "/333",
							$url = "url(" + $src + ")",
							$__style = $style.replace(/url\((['"])?(.*?)\1\)/gi, $url).split(',')[0];
							
						$html = $html.replace($style, $__style); 
					
					}
					
				});
				
				console.log($html);
				
			});
		}); 
		
		
		$('body').find('.section').each( function() {
			var $section = $(this);
			new Waypoint({
				element: $section[0],
				handler: function(direction) {
					
					var $element = $(this.element);
					
					$element.find('.animated').each(function() {
						var $animate = $(this).attr('data-animate');
						if ( typeof $animate !== "undefined" ){
							$(this).addClass($animate);
						};
			    		
			    	});
				},
				offset: '35%',
			});
		});
		
	});
	
	
	$(document).ready(function() {
		
		
		// Header Sticky
		var $header = $('.header');
		if ( $header.length > 0 && !$header.hasClass('header-style-v2') && $header.find('.header-top').length < 1 ) {
			new Waypoint.Sticky({
			  element: $header[0],
			  wrapper: '<div class="header-sticky" />',
			  stuckClass: 'header-stuck',
			  offset: '-0.1px'
			});
		}
		
		
		
		// Slider Slider
		var $slider = $('#slider .slider-wrapper');
		if ( $slider.length > 0 ) {
			$slider.imagesLoaded(function() {
				$slider.find('.nivoSlider').nivoSlider({
					pauseTime: 5000,
					directionNav: false,
				    controlNav: false,
				    randomStart: false, 
				    beforeChange: function(){
				    	//$slider.find('.nivo-caption').find('.animated').each(function() {
				    		//$(this).addClass('fadeOut');
				    	//});
				    },    
				    afterChange: function(){
				    	//$slider.find('.nivo-caption').find('.animated').each(function() {
				    		//$(this).addClass($(this).attr('data-animate'));
				    	//});
				    },        
				    slideshowEnd: function(){
				    },     
				    lastSlide: function(){
				    },         
				    afterLoad: function(){
				    	//$slider.find('.nivo-caption').find('.animated').each(function() {
				    		//$(this).addClass($(this).attr('data-animate'));
				    	//});
				    },         
				});
			});
		}
		
		/* Instagram Feed */
		var $instafeed = $('#instafeed');
		
		if ( $instafeed.length > 0 ) {
			
			 var userFeed = new Instafeed({
		        get: 'user',
		        userId: '1781628684',
		        accessToken: '1781628684.4b03285.12991eb23cc6413b85243368d8c8b2f8',
		        template: '<div class="instagram_thumbnail"><a href="{{link}}"><img src="{{image}}" /></a></div>',
		        limit: 9
		    });
		    userFeed.run();
		}
		
		// Flickity slider
		//Testimonial v1
		if ( $('.testimonials-slider .slider-flickity').length > 0 ) {
			$('.testimonials-slider .slider-flickity').imagesLoaded(function() {
				$('.testimonials-slider .slider-flickity').flickity({
					wrapAround: true,
					imagesLoaded: true,
					prevNextButtons: false,
					pageDots: true,
					cellAlign: 'left',
					arrowShape: { 
						  x0: 30,
						  x1: 60, y1: 30,
						  x2: 70, y2: 30,
						  x3: 40
						}
				});
			});
		}
		//Clients Logo
		if ( $('.clients-logo-slider .slider-flickity').length > 0 ) {
			$('.clients-logo-slider .slider-flickity').imagesLoaded(function() {
				$('.clients-logo-slider .slider-flickity').flickity({
					wrapAround: false,
					contain: true,
					freeScroll: false,
					imagesLoaded: true,
					prevNextButtons: true,
					pageDots: false,
					cellAlign: 'left',
					arrowShape: { 
						  x0: 25,
						  x1: 50, y1: 25,
						  x2: 60, y2: 20,
						  x3: 40
						}
				});
			});
		}
		//Clients Logo
		if ( $('.blog-slider .slider-flickity').length > 0 ) {
			$('.blog-slider .slider-flickity').imagesLoaded(function() {
				$('.blog-slider .slider-flickity').flickity({
					wrapAround: false,
					contain: true,
					freeScroll: false,
					imagesLoaded: true,
					prevNextButtons: false,
					pageDots: false,
					cellAlign: 'left',
					arrowShape: { 
						  x0: 25,
						  x1: 50, y1: 25,
						  x2: 60, y2: 20,
						  x3: 40
						}
				});
			});
		}
		//cats-list
		if ( $('.cats-list-slider .slider-flickity').length > 0 ) {
			$('.cats-list-slider .slider-flickity').imagesLoaded(function() {
				$('.cats-list-slider .slider-flickity').flickity({
					wrapAround: true,
					contain: true,
					freeScroll: false,
					imagesLoaded: true,
					prevNextButtons: false,
					pageDots: false,
					cellAlign: 'center',
					arrowShape: { 
						  x0: 25,
						  x1: 50, y1: 25,
						  x2: 60, y2: 20,
						  x3: 40
						}
				});
			});
		}
		
		
		//Countdown Time
		$('[data-countdown]').each(function() {
			var $this = $(this), finalDate = $(this).data('countdown');
			
			$this.countdown(finalDate, function(event) {
				
				$this.html(event.strftime('<div class="countdown-items">'
						+ '<div class="countdown-item"><span class="f-color">%D</span> days</div>'
						+ '<div class="countdown-item"><span class="f-color">%H</span> Hours</div>'
						+ '<div class="countdown-item"><span class="f-color">%M</span> Minutes</div>'
						+ '<div class="countdown-item"><span class="f-color">%S</span> Seconds</div>'
						+ '</div>'));
					
			});
		});
		
		
	});
	
	
    
})(jQuery);


var mtheme_maps = 
				[
				 	{ 
				 		LatLng: "-37.724667, 144.878328",
				 	}
				];
	
	function initialize( $canvas, $options ) {
		
		var grayStyles = [
		                  {
		                      "featureType": "administrative",
		                      "elementType": "labels.text.fill",
		                      "stylers": [
		                          {
		                              "color": "#444444"
		                          }
		                      ]
		                  },
		                  {
		                      "featureType": "landscape",
		                      "elementType": "geometry.fill",
		                      "stylers": [
		                          {
		                              "visibility": "on"
		                          },
		                          {
		                              "color": "#e3e3e3"
		                          }
		                      ]
		                  },
		                  {
		                      "featureType": "poi",
		                      "elementType": "all",
		                      "stylers": [
		                          {
		                              "visibility": "off"
		                          }
		                      ]
		                  },
		                  {
		                      "featureType": "poi",
		                      "elementType": "geometry",
		                      "stylers": [
		                          {
		                              "visibility": "on"
		                          },
		                          {
		                              "color": "#c6c6c6"
		                          }
		                      ]
		                  },
		                  {
		                      "featureType": "road",
		                      "elementType": "all",
		                      "stylers": [
		                          {
		                              "saturation": -100
		                          },
		                          {
		                              "lightness": 45
		                          }
		                      ]
		                  },
		                  {
		                      "featureType": "road.highway",
		                      "elementType": "all",
		                      "stylers": [
		                          {
		                              "visibility": "simplified"
		                          }
		                      ]
		                  },
		                  {
		                      "featureType": "road.arterial",
		                      "elementType": "labels.icon",
		                      "stylers": [
		                          {
		                              "visibility": "off"
		                          }
		                      ]
		                  },
		                  {
		                      "featureType": "road.local",
		                      "elementType": "geometry.fill",
		                      "stylers": [
		                          {
		                              "visibility": "on"
		                          },
		                          {
		                              "color": "#cecece"
		                          }
		                      ]
		                  },
		                  {
		                      "featureType": "transit",
		                      "elementType": "all",
		                      "stylers": [
		                          {
		                              "visibility": "off"
		                          }
		                      ]
		                  },
		                  {
		                      "featureType": "water",
		                      "elementType": "all",
		                      "stylers": [
		                          {
		                              "color": "#c6c6c6"
		                          },
		                          {
		                              "visibility": "on"
		                          }
		                      ]
		                  }
		              ];
		
		
		// Multi Maps
		var mapOptions,
			map,
			$LatLng,
			i,
			marker = [],
			infowindow = [];
		
		$LatLng = $options[0].LatLng.split(", "); 
		
		mapOptions = {
				center : new google.maps.LatLng($LatLng[0], $LatLng[1]),
				zoom : 15,
				styles : grayStyles,
				
				panControl: false,
				zoomControl: true,
				mapTypeControl: false,
				streetViewControl: false,
				scrollwheel: false, 
				mapTypeId: google.maps.MapTypeId.ROADMAP,
			};
			
		map = new google.maps.Map($canvas,
				mapOptions);
		
		for ( i = 0; i < $options.length; i++ ) {
			
			var $_LatLng = $options[i].LatLng.split(", "); 
			
			marker[i] = new google.maps.Marker({
				map : map,
				position : new google.maps.LatLng($_LatLng[0], $_LatLng[1]),
				icon: '../assets/imgs/icon/map.png',
				key: i,
			});
		
			if ( typeof $options[i].desc_contact !== "undefined" && $options[i].desc_contact.length > 0 ) {
				infowindow[i] = new google.maps.InfoWindow();
				infowindow[i].setContent($options[i].desc_contact); 
				
				//infowindow[i].open(map, marker[i]);
				google.maps.event.addListener(marker[i], 'click', function() {
					infowindow[this.key].open(map, marker[this.key]);
				}); 
			}
		}
	}


var $map_canvas = document.getElementById("map-canvas");

if ( typeof mtheme_maps !== "undefined" && mtheme_maps.length > 0 && $map_canvas != null) {
	google.maps.event.addDomListener(window, 'load', initialize($map_canvas, mtheme_maps ));
}
