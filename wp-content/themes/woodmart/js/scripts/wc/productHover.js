/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit wdUpdateWishlist wdArrowsLoadProducts wdLoadMoreLoadProducts wdProductsTabsLoaded wdSearchFullScreenContentLoaded wdArrowsLoadProducts wdBackHistory wdRecentlyViewedProductLoaded', function() {
		woodmartThemeModule.productHover();
	});

	woodmartThemeModule.wcTabsHoverFix = function() {
		$('.wc-tabs > li').on('click', function() {
			woodmartThemeModule.productHover();
		});
	};

	woodmartThemeModule.$document.on('wdProductMoreDescriptionOpen', function(event, $product) {
		woodmartThemeModule.productHoverRecalc($product);
	});

	$.each([
		'frontend/element_ready/wd_products.default',
		'frontend/element_ready/wd_products_tabs.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.productHover();
		});
	});

	woodmartThemeModule.productHoverRecalc = function($el) {
		if ($el.hasClass('wd-fade-off')) {
			return;
		}

		var heightHideInfo = $el.find('.fade-in-block').outerHeight();

		$el.find('.content-product-imagin').css({
			marginBottom: -heightHideInfo
		});

		$el.addClass('hover-ready');
	};

	woodmartThemeModule.productHover = function() {
		var $hoverBase = $('.wd-hover-with-fade');
		var $carousel  = $hoverBase.closest('.wd-carousel');

		if (woodmartThemeModule.windowWidth <= 1024) {
			if ( $carousel.length > 0 && $hoverBase.hasClass('wd-hover-fw-button')) {
				$hoverBase.addClass('wd-fade-off');
			}

			$hoverBase.on('click', function(e) {
				var $this = $(this);
				var hoverClass = 'state-hover';
				if (!$this.hasClass(hoverClass) && !$this.hasClass('wd-fade-off') && woodmart_settings.base_hover_mobile_click === 'no') {
					e.preventDefault();
					$('.' + hoverClass).removeClass(hoverClass);
					$this.addClass(hoverClass);
				}
			});

			woodmartThemeModule.$document.on('click touchstart', function(e) {
				if ($(e.target).closest('.state-hover').length === 0) {
					$('.state-hover').removeClass('state-hover');
				}
			});
		}

		$hoverBase.on('mouseenter mousemove touchstart', function() {
			var $product = $(this);
			var $content = $product.find('.wd-more-desc');

			if ($content.hasClass('wd-height-calculated')) {
				return;
			}

			$product.imagesLoaded(function() {
				woodmartThemeModule.productHoverRecalc($product);
			});

			$content.addClass('wd-height-calculated');
		});

		function productHolderWidth($holder) {
			if ($holder.data('column_width')) {
				return;
			}

			var holderWidth = $holder.outerWidth();
			var columns = $holder.data('columns');
			var columnWidth = holderWidth / columns;

			$holder.data('column_width', columnWidth);
		}

		$('.wd-products').on('mouseenter mousemove touchstart', function() {
			productHolderWidth($(this));
		});

		$hoverBase.on('mouseenter mousemove touchstart', function() {
			if (!woodmart_settings.hover_width_small) {
				return;
			}

			var $this = $(this);

			if ($this.hasClass('wd-hover-fw-button')) {
				return;
			}

			productHolderWidth($this.parent('.wd-products'));

			var columnWidth = $this.parent('.wd-products').data('column_width');

			if (!columnWidth) {
				return;
			}

			if (255 > columnWidth || woodmartThemeModule.windowWidth <= 1024) {
				$this.find('.wd-add-btn').parent().addClass('wd-add-small-btn');
				$this.find('.wd-add-btn').removeClass('wd-add-btn-replace').addClass('wd-action-btn wd-style-icon wd-add-cart-icon');
			} else if (woodmartThemeModule.$body.hasClass('catalog-mode-on') || woodmartThemeModule.$body.hasClass('login-see-prices')) {
				$this.find('.wd-bottom-actions .wd-action-btn').removeClass('wd-style-icon').addClass('wd-style-text');
			}

			woodmartThemeModule.$document.trigger('wdProductBaseHoverIconsResize');
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.productHover();
		woodmartThemeModule.wcTabsHoverFix();
	});
})(jQuery);
