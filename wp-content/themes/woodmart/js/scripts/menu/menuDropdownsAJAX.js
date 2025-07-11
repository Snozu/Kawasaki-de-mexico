/* global woodmart_settings */
(function($) {
	woodmartThemeModule.menuDropdownsAJAX = function() {
		window.addEventListener('wdEventStarted', function() {
			$('.menu').has('.dropdown-load-ajax').each(function() {
				var $menu = $(this);

				if ($menu.hasClass('dropdowns-loading') || $menu.hasClass('dropdowns-loaded')) {
					return;
				}

				if (woodmartThemeModule.windowWidth <= 1024) {
					setTimeout(function() {
						loadDropdowns($menu);
					}, 500);
				} else {
					loadDropdowns($menu);
				}
			});
		});

		function loadDropdowns($menu) {
			$menu.addClass('dropdowns-loading');

			var storageKey = woodmart_settings.menu_storage_key + '_' + $menu.attr('id');
			var storedData = false;

			var $items = $menu.find('.dropdown-load-ajax'),
			    ids    = [];

			$items.each(function() {
				var $placeholder = $(this).find('.dropdown-html-placeholder');
				if ($placeholder.length > 0) {
					ids.push($placeholder.data('id'));
				}
			});

			if (woodmart_settings.ajax_dropdowns_save && woodmartThemeModule.supports_html5_storage) {
				var unparsedData = localStorage.getItem(storageKey);

				try {
					storedData = JSON.parse(unparsedData);
				}
				catch (e) {
					console.log('cant parse Json', e);
				}
			}
			if (storedData) {
				renderResults(storedData);
			} else {
				if (ids.length === 0) {
					$menu.addClass('dropdowns-loaded');
					$menu.removeClass('dropdowns-loading');
					return;
				}

				$.ajax({
					url     : woodmart_settings.ajaxurl,
					data    : {
						action: 'woodmart_load_html_dropdowns',
						ids   : ids
					},
					dataType: 'json',
					method  : 'POST',
					success : function(response) {
						if (response.status === 'success') {
							renderResults(response.data);
							if (woodmart_settings.ajax_dropdowns_save && woodmartThemeModule.supports_html5_storage) {
								try {
									localStorage.setItem(storageKey, JSON.stringify(response.data));
								} catch (e) {}
							}
						} else {
							console.log('loading html dropdowns returns wrong data - ', response.message);
						}
					},
					error   : function() {
						console.log('loading html dropdowns ajax error');
					}
				});
			}

			function renderResults(data) {
				Object.keys(data).forEach(function(id) {
					woodmartThemeModule.removeDuplicatedStylesFromHTML(data[id], function(html) {
						$menu.find('[data-id="' + id + '"]').replaceWith(html);

						$menu.addClass('dropdowns-loaded');
						setTimeout(function() {
							$menu.removeClass('dropdowns-loading');
						}, 1000);
					});
				});

				setTimeout(function() {
					woodmartThemeModule.$document.trigger('wdLoadDropdownsSuccess');
				}, 500);
			}
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.menuDropdownsAJAX();
	});
})(jQuery);
