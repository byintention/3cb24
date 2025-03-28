// Plain JS first, then jQuery stuff
	
	/*! fluidvids.js v2.4.1 | (c) 2014 @toddmotto | https://github.com/toddmotto/fluidvids */
	!function(e,t){"function"==typeof define&&define.amd?define(t):"object"==typeof exports?module.exports=t:e.fluidvids=t()}(this,function(){"use strict";function e(e){return new RegExp("^(https?:)?//(?:"+d.players.join("|")+").*$","i").test(e)}function t(e,t){return parseInt(e,10)/parseInt(t,10)*100+"%"}function i(i){if((e(i.src)||e(i.data))&&!i.getAttribute("data-fluidvids")){var n=document.createElement("div");i.parentNode.insertBefore(n,i),i.className+=(i.className?" ":"")+"fluidvids-item",i.setAttribute("data-fluidvids","loaded"),n.className+="fluidvids",n.style.paddingTop=t(i.height,i.width),n.appendChild(i)}}function n(){var e=document.createElement("div");e.innerHTML="<p>x</p><style>"+o+"</style>",r.appendChild(e.childNodes[1])}var d={selector:["iframe","object"],players:["www.youtube.com","player.vimeo.com"]},o=[".fluidvids {","width: 100%; max-width: 100%; position: relative;","}",".fluidvids-item {","position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;","}"].join(""),r=document.head||document.getElementsByTagName("head")[0];return d.render=function(){for(var e=document.querySelectorAll(d.selector.join()),t=e.length;t--;)i(e[t])},d.init=function(e){for(var t in e)d[t]=e[t];d.render(),n()},d});
	
	fluidvids.init({
		selector: ['iframe', 'object'], // runs querySelectorAll()
		players: ['www.youtube.com', 'player.vimeo.com'] // players to support
	});
	
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
		function classOnScroll() {
			//caches a jQuery object containing the header element
			var header = $("#header");
				var scroll = $(window).scrollTop();
				if (scroll >= 1) {
					header.removeClass('clearHeader').addClass("scrollHeader");
				} else {
					header.removeClass("scrollHeader").addClass('clearHeader');
				}
		}

		// Run on first site run
		classOnScroll();

		// Run on scroll and resize
		$(window).on('scroll resize',classOnScroll);

		// Add div for dropdown arrow to modified select boxes
		$("#sidebar select").wrap("<div class=\"select-input\"></div>");
		$("form select").wrap("<div class=\"select-input\"></div>");

	});

})(jQuery); // Fully reference $ after this point.