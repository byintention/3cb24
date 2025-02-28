// Plain JS first, then jQuery stuff
	
	// Opening answers on faq panel
	document.addEventListener("DOMContentLoaded", function() {
		var anchors = document.getElementsByClassName('faq-question');
		var len = anchors.length;
		//console.log(anchors);
		for (var i = 0; i < anchors.length; i++) {
			anchors[i].addEventListener('click', function(event) {
				//var parent = this.parentElement;
				this.parentElement.classList.toggle('active');
				//var answer = this.nextElementSibling;
				this.nextElementSibling.classList.toggle('visible');
			});
		}
		
		// Add body class when page loaded
		document.body.classList.toggle('loaded');
	
	});
	
	
	 
	
// jQuery stuff	

(function($) {
	$(document).ready(function() {
		
		// Mobile nav
		$('.menu-trigger').click(function() {
			//console.log('open');
			$('#nav2').fadeToggle(300);
			$('body').toggleClass('mobilenavopen');
			$(this).toggleClass('navOpen');
		});
	
		// Dropdown triggers
		$('#nav2 li.menu-item-has-children').prepend( '<a class="sub_nav"><div class="arrow_down"></div></a>' );
	
		$('.sub_nav').click(function() {
			$(this).toggleClass( 'open' );
			$(this).siblings( 'ul' ).toggleClass( 'show' );
		});

		// End mobile nav

	
		// Dropdown navigation for desktop size
		var curz = 99;
		var screen = $(window);
		if ( screen.width() > 1200 ) {
			$("#nav2 li.menu-item-has-childrenx").hover(function() {
				var timeout = $(this).data("timeout");
				if (timeout) clearTimeout(timeout);
				$(this).children("ul").slideDown(0).css({ "z-index":curz++ });
			}, function() {
			   $(this).data("timeout", setTimeout($.proxy(function() {
			   $(this).find("ul").slideUp(0);
			 }, this), 0));
			});
		}
		
		// Add scroll class to header 
		$(function() {
			//caches a jQuery object containing the header element
			var header = $("#header");
			$(window).scroll(function() {
				var scroll = $(window).scrollTop();
				if (scroll >= 1) {
					header.removeClass('clearHeader').addClass("scrollHeader");
				} else {
					header.removeClass("scrollHeader").addClass('clearHeader');
				}
			});
		});

		// Add div for dropdown arrow to modified select boxes
		$("#sidebar select").wrap("<div class=\"select-input\"></div>");
		$("form select").wrap("<div class=\"select-input\"></div>");
		
	});

	
})(jQuery); // Fully reference $ after this point.