"user strict";

$(document).ready(function () {
	//menu header bar
	$(".header-bar").on("click", function (e) {
		$(".main-menu, .header-bar").toggleClass("active");
	});
	$(".main-menu li a").on("click", function (e) {
		var element = $(this).parent("li");
		if (element.hasClass("open")) {
			element.removeClass("open");
			element.find("li").removeClass("open");
			element.find("ul").slideUp(300, "swing");
		} else {
			element.addClass("open");
			element.children("ul").slideDown(300, "swing");
			element.siblings("li").children("ul").slideUp(300, "swing");
			element.siblings("li").removeClass("open");
			element.siblings("li").find("li").removeClass("open");
			element.siblings("li").find("ul").slideUp(300, "swing");
		}
	});
	//menu header bar
	//menu top fixed bar
	var fixed_top = $(".header-section");
	$(window).on("scroll", function () {
		if ($(this).scrollTop() > 220) {
			fixed_top.addClass("menu-fixed animated fadeInDown");
			fixed_top.removeClass("slideInUp");
			$("body").addClass("body-padding");
		} else {
			fixed_top.removeClass("menu-fixed fadeInDown");
			fixed_top.addClass("slideInUp");
			$("body").removeClass("body-padding");
		}
	});
	//menu top fixed bar

	/*-- Odometer Counting Start--*/
	$(".odometer-item").each(function () {
		$(this).isInViewport(function (status) {
			if (status === "entered") {
				for (
					var i = 0;
					i < document.querySelectorAll(".odometer").length;
					i++
				) {
					var el = document.querySelectorAll(".odometer")[i];
					el.innerHTML = el.getAttribute("data-odometer-final");
				}
			}
		});
	});
	/*-- Odometer Counting End--*/

	// wow animation
		new WOW().init();
	// wow animation

	$(".banner__section").owlCarousel({
		loop: true,
		margin: 5,
		smartSpeed: 900,
		autoplayTimeout: 10,
		autoplay: false,
		nav: false,
		dots: true,
		responsiveClass: true,
		navText: [
			'<i class="fas fa-angle-left"></i>',
			'<i class="fas fa-angle-right"></i>',
		],
		responsive: {
			0: {
				items: 1,
			},
			500: {
				items: 1,
			},
			767: {
				items: 1,
			},
			991: {
				items: 1,
			},
			1199: {
				items: 1,
			},
			1399: {
				items: 1,
			},
		},
	});
	$(".user__wrap").owlCarousel({
		loop: true,
		margin: 15,
		smartSpeed: 900,
		autoplayTimeout: 500,
		autoplay: true,
		nav: false,
		dots: true,
		responsiveClass: true,
		navText: [
			'<i class="fas fa-angle-left"></i>',
			'<i class="fas fa-angle-right"></i>',
		],
		responsive: {
			0: {
				items: 1,
			},
			500: {
				items: 1,
			},
			767: {
				items: 2,
			},
			991: {
				items: 2,
			},
			1199: {
				items: 2,
			},
			1399: {
				items: 2,
			},
		},
	});
	$(".server__right__wrap").owlCarousel({
		loop: true,
		margin: 15,
		smartSpeed: 900,
		autoplayTimeout: 500,
		autoplay: true,
		nav: false,
		dots: false,
		responsiveClass: true,
		navText: [
			'<i class="fas fa-angle-left"></i>',
			'<i class="fas fa-angle-right"></i>',
		],
		responsive: {
			0: {
				items: 1,
			},
			500: {
				items: 1,
			},
			767: {
				items: 1,
			},
			991: {
				items: 2,
			},
			1199: {
				items: 2,
			},
			1399: {
				items: 2,
			},
		},
	});

	//Home Index
	$(".h__section").owlCarousel({
		loop: true,
		margin: 5,
		smartSpeed: 900,
		autoplayTimeout: 10,
		autoplay: false,
		nav: false,
		dots: true,
		responsiveClass: true,
		navText: [
			'<i class="fas fa-angle-left"></i>',
			'<i class="fas fa-angle-right"></i>',
		],
		responsive: {
			0: {
				items: 1,
			},
			500: {
				items: 1,
			},
			767: {
				items: 1,
			},
			991: {
				items: 1,
			},
			1199: {
				items: 1,
			},
			1399: {
				items: 1,
			},
		},
	});
	$(".home__slide__wrap").owlCarousel({
		loop: true,
		margin: 24,
		smartSpeed: 900,
		autoplayTimeout: 10,
		autoplay: false,
		nav: false,
		dots: true,
		responsiveClass: true,
		navText: [
			'<i class="fas fa-angle-left"></i>',
			'<i class="fas fa-angle-right"></i>',
		],
		responsive: {
			0: {
				items: 1,
			},
			500: {
				items: 1,
			},
			767: {
				items: 2,
			},
			991: {
				items: 2,
			},
			1199: {
				items: 3,
			},
			1399: {
				items: 4,
			},
		},
	});
	
	///============= Scroll To Top =============\\\

	let calcScrollValue = () => {
		let scrollProgress = document.getElementById("progress");
		let progressValue = document.getElementById("valu");
		let pos = document.documentElement.scrollTop;
		let calcHeight =
		document.documentElement.scrollHeight - 
		document.documentElement.clientHeight;
		let scrollValue = Math.round((pos * 250) / calcHeight);
		
		if (pos > 250){
			scrollProgress.style.display = "grid";
		} else{
			scrollProgress.style.display = "none";
		}
		scrollProgress.addEventListener("click", () => {
			document.documentElement.scrollTop = 0;
		}); 
	};
	window.onscroll = calcScrollValue;
	window.onload = calcScrollValue;
	/*-- Scroll Top Bottom End--*/

	//Nice select
	$('select').niceSelect();
	
	 $('.video-btn, .popup-vimeo').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
	
	//contact form js
	$(function () {
		// Get the form.
		var form = $("#form");
		// Get the messages div.
		var formMessages = $(".form-message");
		// Set up an event listener for the contact form.
		$(form).submit(function (e) {
			// Stop the browser from submitting the form.
			e.preventDefault();
			// Serialize the form data.
			var formData = $(form).serialize();
			// Submit the form using AJAX.
			$.ajax({
				type: "POST",
				url: $(form).attr("action"),
				data: formData,
			})
				.done(function (response) {
					// Make sure that the formMessages div has the 'success' class.
					$(formMessages).removeClass("error");
					$(formMessages).addClass("success");
					// Set the message text.
					$(formMessages).text(response);
					// Clear the form.
					$("#form input, #form textarea").val("");
				})
				.fail(function (data) {
					// Make sure that the formMessages div has the 'error' class.
					$(formMessages).removeClass("success");
					$(formMessages).addClass("error");
					// Set the message text.
					if (data.responseText !== "") {
						$(formMessages).text(data.responseText);
					} else {
						$(formMessages).text(
							"Oops! An error occured and your message could not be sent."
						);
					}
				});
		});
	});
	
});



