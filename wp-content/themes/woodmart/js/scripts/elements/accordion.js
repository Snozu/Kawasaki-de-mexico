(function($) {
	$.each([
		'frontend/element_ready/wd_accordion.default',
		'frontend/element_ready/wd_single_product_tabs.default',
		'frontend/element_ready/wd_single_product_reviews.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function($wrapper) {
			woodmartThemeModule.accordion();

			$('.wc-tabs-wrapper, .woocommerce-tabs').trigger('init');
			$wrapper.find('#rating').parent().find('> .stars').remove();
			$wrapper.find('#rating').trigger('init');
		});
	});

	var triggerReviewOpener = function() {
		$('.tabs-layout-accordion .wd-accordion-title.tab-title-reviews:not(.active)').click();
	}

	woodmartThemeModule.accordion = function() {
		var hash = window.location.hash;
		var url = window.location.href;

		// Single product.
		$('.woocommerce-review-link')
			.off('click', triggerReviewOpener)
			.on('click', triggerReviewOpener);

		// Element.
		$('.wd-accordion').each(function() {
			var $wrapper = $(this);
			var $tabTitles = $wrapper.find('> .wd-accordion-item > .wd-accordion-title');
			var $tabContents = $wrapper.find('> .wd-accordion-item > .wd-accordion-content');
			var activeClass = 'wd-active';
			var state = $wrapper.data('state');
			var time = 300;

			if ($wrapper.hasClass('wd-inited')) {
				return;
			}

			var isTabActive = function(tabIndex) {
				return $tabTitles.filter('[data-accordion-index="' + tabIndex + '"]').hasClass(activeClass);
			};

			var activateTab = function(tabIndex) {
				var $requestedTitle = $tabTitles.filter('[data-accordion-index="' + tabIndex + '"]');
				var $requestedContent = $tabContents.filter('[data-accordion-index="' + tabIndex + '"]');

				$requestedTitle.addClass(activeClass);
				$requestedContent.stop(true, true).slideDown(time).addClass(activeClass);

				if ('first' === state && !$wrapper.hasClass('wd-inited')) {
					if (! $requestedContent.length) {
						$requestedContent = $tabContents.first();
					}

					$requestedContent.stop(true, true).show().css('display', 'block');
				}

				$wrapper.addClass('wd-inited');

				woodmartThemeModule.$document.trigger('resize.vcRowBehaviour');
				woodmartThemeModule.$document.trigger('wood-images-loaded');
			};

			var deactivateActiveTab = function() {
				var $activeTitle = $tabTitles.filter('.' + activeClass);
				var $activeContent = $tabContents.filter('.' + activeClass);

				$activeTitle.removeClass(activeClass);
				$activeContent.stop(true, true).slideUp(time).removeClass(activeClass);
			};

			var getFirstTabIndex = function() {
				return $tabTitles.first().data('accordion-index');
			};

			if ('first' === state) {
				activateTab(getFirstTabIndex());
			}

			$tabTitles.off('click').on('click', function() {
				var $this = $(this);
				var tabIndex = $(this).data('accordion-index');
				var isActiveTab = isTabActive(tabIndex);

				var currentIndex = $this.parent().index();
				var oldIndex = $this.parent().siblings().find('.wd-active').parent('.wd-tab-wrapper').index();

				if ($this.hasClass('wd-active') || currentIndex === -1) {
					oldIndex = currentIndex;
				}

				if (isActiveTab || $this.hasClass(activeClass)) {
					deactivateActiveTab();
				} else {
					deactivateActiveTab();
					activateTab(tabIndex);

					if ( ! $tabTitles.filter('[data-accordion-index="' + tabIndex + '"]').length ) {
						$this.addClass(activeClass);
						$this.siblings('.wd-accordion-content').stop(true, true).slideDown(time).addClass(activeClass)
					}
				}

				if ($this.parents('.tabs-layout-accordion').length || $this.parents('.wd-single-tabs').length) {
					setTimeout(function() {
						if (woodmartThemeModule.$window.width() < 1024 && currentIndex > oldIndex) {
							var $header = $('.whb-sticky-header');
							var headerHeight = $header.length > 0 ? $header.outerHeight() : 0;
							$('html, body').animate({
								scrollTop: $this.offset().top - $this.outerHeight() - headerHeight - 50
							}, 500);
						}
					}, time);
				}
			});

			if (hash.toLowerCase().indexOf('comment-') >= 0 || hash === '#reviews' || hash === '#tab-reviews' || url.indexOf('comment-page-') > 0 || url.indexOf('cpage=') > 0) {
				$wrapper.find('.tab-title-reviews').trigger('click');
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.accordion();
	});
})(jQuery);