/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdPortfolioPjaxComplete', function () {
		woodmartThemeModule.portfolioMasonryFilters();
	});

	$.each([
		'frontend/element_ready/wd_portfolio.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.portfolioMasonryFilters();
		});
	});

	woodmartThemeModule.portfolioMasonryFilters = function() {
		var $filer = $('.wd-nav-portfolio');
		$filer.on('click', 'li', function(e) {
			e.preventDefault();
			var $this = $(this);
			var filterValue = $this.attr('data-filter');

			setTimeout(function() {
				woodmartThemeModule.$document.trigger('wood-images-loaded');
			}, 300);

			$filer.find('.wd-active').removeClass('wd-active');
			$this.addClass('wd-active');

			var $masonryContainer = $this.parents('.portfolio-filter').siblings('.wd-masonry.wd-projects');

			if (!$masonryContainer.length) {
			    $masonryContainer = $('.wd-portfolio-archive .wd-masonry.wd-projects');
			}
			
			if ($masonryContainer.length) {
			    $masonryContainer.isotope({ filter: filterValue });
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.portfolioMasonryFilters();
	});
})(jQuery);
