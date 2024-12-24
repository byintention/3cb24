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
	
	// BTT
  var timeOut;
	function scrollToTop() {
		if (document.body.scrollTop!=0 || document.documentElement.scrollTop!=0){
			window.scrollBy(0,-50);
			timeOut=setTimeout('scrollToTop()',10);
		}
		else clearTimeout(timeOut);
	}
	 
	
// jQuery stuff	

(function($) {
    $(document).ready(function() {
		
		
	var Toast = {
	
	  init: function(options) {
		this.setOptions(options, $.toast.options)
		this.build()
	  },
	
	  setOptions: function(options, extended_options) {
		  this.options = $.extend( {}, extended_options, options )
	  },
	
	  build: function() {
		this.setup()
		this.setPosition()
		this.renderHTML()
		this.animate()
	  },
	
	  setup: function() {
	
		var wrapper = $('.toaster-wrapper')
	
		this.content = $(`<div class="toast-content">${this.options.content}</div>`)
		this.itemEl = $('<div class="toast"></div>')
	
	
		if (!wrapper.length) {
	
		  wrapper = $('<div class="toaster-wrapper"></div>')
	
		  $('body').append(wrapper)
	
		}
	
		if (this.options.stacking) {
		  wrapper.find(`.toast.${this.options.hideClass}`).remove()
		} else {
		  wrapper.find('.toast').remove()
		}
	
		this.itemEl.append(this.content)
		wrapper.prepend(this.itemEl)
	
		this.wrapper = wrapper
	  },
	
	  setPosition: function () {
		this.wrapper.removeClass().addClass(`toaster-wrapper ${this.options.position}`)
	  },
	
	  renderHTML: function() {
		window.setTimeout(() =>{
		  // wait for toast item to load in DOM before
		  // adding showClass
		  this.itemEl.addClass(this.options.showClass)
		}, 1)
	  },
	
	  animate: function() {
	
		if (this.options.hideAfter) {
		  window.setTimeout(() => {
	
			this.itemEl.removeClass(this.options.showClass)
			this.itemEl.addClass(this.options.hideClass)
	
		  }, this.options.hideAfter)
		}
	
	  },
	
	  reset: function() {
		this.wrapper.empty()
	  }
	
	}
	
	$.toast = function(options) {
	  var toast = Object.create(Toast)
	  toast.init(options)
	
	  return {
		reset: function() {
		  toast.reset()
		}
	  }
	}
	
	// default options for the Toaster library
	$.toast.options = {
	  content: '',
	  position: 'bottom-right',
	  hideClass: 'toast-hide',
	  showClass: 'toast-show',
	  hideAfter: 3000,
	  stacking: true,
	}
	
		
	  
	  /*
	  // Open off-site links in new tab
	  $('a').each(function() {
		  var a = new RegExp('/' + window.location.host + '/');
		  if(!a.test(this.href)) {
				$(this).click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					window.open(this.href, '_blank');
				});
		  }
		});
	  */
	  
	  	
	  
	  // Mobile nav

	    $('.menu-trigger').click(function() {
			//console.log('open');
			$('#nav2').fadeToggle(300);
			$('body').toggleClass('mobilenavopen');
			$(this).toggleClass('navOpen');   
		});
		
		$('.navclose').click(function() {
			//console.log('close');
			$('#nav2').fadeOut(300);
			$('body').toggleClass('mobilenavopen'); 
		});
	    
	    // Dropdown triggers
      $('#nav2 li.menu-parent-item').prepend( '<a class="sub_nav"><div class="arrow_down"></div></a>' );
      
      $('.sub_nav').click(function() {
        $(this).toggleClass('open');
        $(this).siblings('ul').toggleClass('show');   
      });
	    
      // End mobile nav

	  
	  // Dropdown navigation for desktop size
		var curz = 99;
		var screen = $(window);
		if (screen.width() > 1200) {
			$("#nav2 li.menu-item-has-children").hover(function() {
			    var timeout = $(this).data("timeout");
			    if (timeout) clearTimeout(timeout);
			$(this).children("ul").slideDown(0).css({ "z-index":curz++ });
			 }, function() {
			   $(this).data("timeout", setTimeout($.proxy(function() {
			   $(this).find("ul").slideUp(0);
			 }, this), 0));
			});
		}
		
		// 3CB slot tool 
		//var userName = $('.username').text();
		//console.log(userName);
		//$('.slotIcon').click(function() {
			
		 // console.log(userName);
		  
		//});   
		
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
		 
		 
	});  
	
	// Add div for dropdown arrow to modified select boxes
	$(window).on('load', function(){
		$(".variations select").wrap("<div class=\"select-input\"></div>");
		$(".wpcf7 select").wrap("<div class=\"select-input\"></div>");
		$("#sidebar select").wrap("<div class=\"select-input\"></div>");
		$(".woocommerce-ordering select").wrap("<div class=\"select-input\"></div>");
		
		$(".wc-pao-addon-select").wrap("<div class=\"select-input\"></div>");
		
		
		$(".wpcf7 input[type='checkbox']").after("<span class=\"checkmark\"></span>");
		
		
		
		
		
		
		
	});
	
	

	
	

	
})(jQuery); // Fully reference $ after this point.