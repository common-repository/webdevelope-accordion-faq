! function ($) {
	"use strict";
	$(".wdfa-accordion-a").hide(), $(".wdfa-accordion-q").click(function () {
		var b = $(this).hasClass("wdfa-accordion-open"),
			c = $(".webdevelope_faq_accordion").find("i." + icons.faq_open);
		$(".wdfa-accordion-q").removeClass("wdfa-accordion-open"), $(".wdfa-accordion-a").slideUp(), c.removeClass(icons.faq_open).addClass(icons.faq_close), b ? ($(this).parents(".wdfa-accordion").first().find(".wdfa-accordion-a").slideUp(), $(this).removeClass("wdfa-accordion-open")) : ($(this).parents(".wdfa-accordion").first().find(".wdfa-accordion-a").slideDown(), $(this).addClass("wdfa-accordion-open"), $(this).find("i").removeClass(icons.faq_close).addClass(icons.faq_open))
	});
}(jQuery),
function ($) {
	"use strict";
	$(".wdfa-list-cat a, .wdfa-list-q a, .wdfa-back-top").each(function () {
		var b = "";
		$(this).click(function () {
			var href = $(this).attr("href"),
				offset = $(this).parents(".webdevelope_faq_list").find(href).offset();
			return b = offset.top, $("html,body").animate({
				scrollTop: b - 30
			}, 500), !1;
		});
	});
}(jQuery),
function ($) {
	"use strict";
	$(".wdfa-block-a").hide();
	$(".wdfa-block").click(function () {
		var b = $(this).hasClass("wdfa-block-open"),
			c = $(".webdevelope_faq_block").find("i." + icons.faq_open);
		$(".wdfa-block").removeClass("wdfa-block-open"), c.removeClass(icons.faq_open).addClass(icons.faq_close), $(".wdfa-block-a").slideUp(), b ? ($(this).find(".wdfa-block-a").first().slideUp(), $(this).removeClass("wdfa-block-open")) : ($(this).find(".wdfa-block-a").first().slideDown(), $(this).addClass("wdfa-block-open"), $(this).find("i").removeClass(icons.faq_close).addClass(icons.faq_open))
	});
}(jQuery),
function ($) {
	"use strict";

	function debounce(func, wait, immediate) {
		var timeout;
		return function () {
			var context = this, args = arguments;
			var later = function () {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};

	$(document).on('keyup', '.wdfa-search input', debounce(function (event) {
		var $parent = $(this).parents('.webdevelope_faq'),
			$cats = $parent.find('.wdfa-cat'),
			$faqs = $parent.find('.wdfa-faq'),
			value = this.value;

		if (value.length >= 2) {
			$faqs.add($cats).filter(function () {
				return $(this).text().toUpperCase().indexOf(value.toUpperCase()) < 0;
			}).hide();
			$faqs.add($cats).filter(function () {
				return $(this).text().toUpperCase().indexOf(value.toUpperCase()) >= 0;
			}).show();
		} else {
			$faqs.add($cats).show();
		}
	}, 300));
}(jQuery);