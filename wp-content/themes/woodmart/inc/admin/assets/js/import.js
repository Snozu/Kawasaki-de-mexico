/* global woodmartConfig */
(function($) {
	'use strict';

	var $importWrapper = $('.xts-import');
	var $boxContent = $('.xts-box-content');
	var $noticesAreaRemove = $('.xts-popup').find('.xts-import-remove-notices');
	var $wizardWrapper = $('.xts-wizard-dummy');
	var $filesystemModal = $('.xts-request-credentials .request-filesystem-credentials-dialog');
	var $importStatus = $('.xts-import-status');
	var $setupWizard = $('.xts-setup-wizard');

	// Lazy loading.
	$boxContent.on('scroll', function() {
		$(document).trigger('wood-images-loaded');
	});

	// Request credentials.
	function checkRequestCredentials() {
		return new Promise((resolve, reject) => {
			$filesystemModal.on( 'submit', 'form', function( event ) {
				event.preventDefault();

				woodmart_settings.filesystemCredentials = {}

				// Persist the credentials input by the user for the duration of the page load.
				woodmart_settings.filesystemCredentials.hostname       = $( '#hostname' ).val();
				woodmart_settings.filesystemCredentials.username       = $( '#username' ).val();
				woodmart_settings.filesystemCredentials.password       = $( '#password' ).val();
				woodmart_settings.filesystemCredentials.connection_type = $( 'input[name="connection_type"]:checked' ).val();
				woodmart_settings.filesystemCredentials.public_key      = $( '#public_key' ).val();
				woodmart_settings.filesystemCredentials.private_key     = $( '#private_key' ).val();
				woodmart_settings.filesystemCredentials._fs_nonce            = $( '#_fs_nonce' ).val();
				woodmart_settings.filesystemCredentials.available          = true;

				if ( woodmart_settings.filesystemCredentials.hostname && woodmart_settings.filesystemCredentials.username && woodmart_settings.filesystemCredentials.password ) {
					$filesystemModal.hide();

					resolve(true)
				}
			} );

			$filesystemModal.find('.request-filesystem-credentials-action-buttons button.cancel-button').on('click', function() {
				$filesystemModal.hide();

				resolve(false)
			});
		});
	}

	// Import.
	$('.xts-import-item').each(function() {
		var $this = $(this);
		var $importBtn = $this.find('.xts-import-item-btn');
		var $progressBar = $this.find('.xts-import-progress-bar');
		var $progressBarPercent = $this.find('.xts-import-progress-bar-percent');
		var $wrapper = $('.xts-import-items');

		var noticeTimeout;
		var interval;

		$importBtn.on('click', async function(e) {
			e.preventDefault();

			var currentBase = $importWrapper.data('current-base');
			var clickBase = $this.data('base');
			var clickVersion = $this.data('version');
			var clickType = $this.data('type');
			var version;
			var type;
			var action = $(this).hasClass('xts-color-alt') ? 'activate' : 'import';
			var confirmRemove = 'none';

			if ($this.hasClass('xts-need-rs')) {
				var needRs = confirm('The Slider Revolution plugin is not activated. Activate the plugin first or you can skip this and import the version without a slider.');

				if (!needRs) {
					return;
				}
			}

			if (clickBase && clickBase !== currentBase && $importWrapper.hasClass('xts-base-imported')) {
				confirmRemove = confirm('WARNING! To import this demo version you need to remove all the previously imported content with all pages, products, and images. Do you want to remove the content and import this version?');
			}

			if (!confirmRemove) {
				return;
			} else if ('none' !== confirmRemove) {
				$importWrapper.removeClass('xts-base-imported');
			}

			if ($filesystemModal.length && ('undefined' === typeof woodmart_settings.filesystemCredentials || !woodmart_settings.filesystemCredentials.available) ) {
				$filesystemModal.show()

				var $check = await checkRequestCredentials();

				if ( ! $check ) {
					return;
				}
			}

			$this.addClass('xts-loading-item');
			$wrapper.addClass('xts-loading');

			clearNotices();

			if (!$importWrapper.hasClass('xts-base-imported') && 'version' === clickType) {
				startProgressBar('base');
				version = clickBase;
				type = 'base';
			} else {
				startProgressBar('version');
				version = clickVersion;
				type = clickType;
			}

			if (confirmRemove && 'none' !== confirmRemove) {
				await removeBeforeImport();
				runImport();
			} else if ('none' === confirmRemove) {
				runImport();
			}

			function runImport() {
				var requests = [
					'xml',
					'images1',
					'images2',
					'images3',
					'images4',
					'other'
				];

				runRequest();

				function runRequest() {
					var baseVersionAll = woodmartConfig.import_base_versions_name.split(',');

					if (requests.length) {
						var process = requests.shift();
						var dataRequest = {
							action  : 'woodmart_import_action',
							version : version,
							type    : type,
							process : process,
							security: woodmartConfig.import_nonce
						}

						if ( 'undefined' !== typeof woodmart_settings.filesystemCredentials ) {
							dataRequest = { ...dataRequest, ...woodmart_settings.filesystemCredentials }
						}

						if ( $('.xts-import-notices .xts-notice.xts-error').length ) {
							return;
						}

						if (process.includes('images') && ! baseVersionAll.includes(version)) {
							runRequest();

							return;
						}

						updateProgressBar( type, process );

						$.ajax({
							url    : woodmartConfig.ajaxUrl,
							data   : dataRequest,
							timeout: 1000000,
							error  : function() {
								$this.removeClass('xts-loading-item');
								$wrapper.removeClass('xts-loading');

								endProgress();
								clearProgressBar();
								clearNotices();
								printNotice('error', 'The import could not be completed due to a low timeout limit on the server. You need to contact your hosting provider and ask them to increase it to 300 seconds.');
							},
							success: function(response) {
								if (! response.success && 'undefined' !== typeof response.data  && 'undefined' !== typeof response.data.errorMessage) {
									$this.removeClass('xts-loading-item');
									$wrapper.removeClass('xts-loading');

									endProgress();
									clearProgressBar();
									clearNotices();
									printNotice('error', response.data.errorMessage);

									woodmart_settings.filesystemCredentials.available = false;

									return;
								}

								if (process === 'other') {
									$this.find('.xts-view-item-btn').attr('href', response.preview_url);
									$('.xts-import-remove-form-wrap').html(response.remove_html);
								}
							}
						}).then(runRequest);
					} else {
						initRemove();
						afterRemove();

						if (baseVersionAll.includes(version)) {
							$importWrapper.data('current-base', version);
							$importWrapper.attr('data-current-base', version);

							version = clickVersion;
							type = clickType;
							runImport();

							$importWrapper.addClass('xts-base-imported');
							$wizardWrapper.addClass('imported-base');
						} else {
							updateProgress(100);
							clearNotices();

							if ('activate' === action) {
								printNotice('success', 'Demo version has been successfully activated!');
							} else {
								printNotice('success', 'Content has been successfully imported!');
							}

							$this.addClass('xts-imported');
							$this.addClass('xts-view-page');
							$this.siblings().removeClass('xts-view-page');
							$wrapper.removeClass('xts-loading');

							if ($setupWizard.length) {
								$setupWizard.removeClass('xts-loading')
								$setupWizard.addClass('xts-imported')
							}

							setTimeout(function() {
								endProgress();
								clearProgressBar();
								$this.removeClass('xts-loading-item');
							}, 1000);
						}

						$importWrapper.addClass('xts-has-data');
					}
				}
			}
		});

		function removeBeforeImport() {
			return new Promise(resolve => {
				$.ajax({
					url    : woodmartConfig.ajaxUrl,
					data   : {
						action  : 'woodmart_import_remove_action',
						security: woodmartConfig.import_remove_nonce,
						data    : [
							{
								'name' : 'page',
								'value': 'on'
							},
							{
								'name' : 'rev_sliders',
								'value': 'on'
							},
							{
								'name' : 'product',
								'value': 'on'
							},
							{
								'name' : 'mc4wp-form',
								'value': 'on'
							},
							{
								'name' : 'post',
								'value': 'on'
							},
							{
								'name' : 'woodmart_layout',
								'value': 'on'
							},
							{
								'name' : 'woodmart_slider',
								'value': 'on'
							},
							{
								'name' : 'portfolio',
								'value': 'on'
							},
							{
								'name' : 'presets',
								'value': 'on'
							},
							{
								'name' : 'cms_block',
								'value': 'on'
							},
							{
								'name' : 'headers',
								'value': 'on'
							},
							{
								'name' : 'attachment',
								'value': 'on'
							},
							{
								'name' : 'nav_menu',
								'value': 'on'
							},
							{
								'name' : 'wpcf7_contact_form',
								'value': 'on'
							}
						]
					},
					timeout: 1000000,
					error  : function() {
						clearNotices();
						printNotice('error', 'Something wrong with removing data. Please, try to remove data manually or contact our support center for further assistance.', 'remove');
					},
					success: function(response) {
						$('.xts-import-remove-form-wrap').html(response.content);
						initRemove();
						afterRemove();
					}
				}).then(function(response) {
					resolve(response);
				});
			});
		}

		function updateProgressBar( type, process ) {
			if ( 'base' === type ) {
				if ( 'xml' === process ) {
					updateProgress(15, 1);
				}
				if ( process.indexOf('images') + 1 ) {
					let step = parseInt(process.substr(6)) + 1;
					updateProgress((15 * step), step);
				}
				if ( 'other' === process ) {
					updateProgress(80, 6);
				}
			} else if ( 'xml' === process ) {
				updateProgress(90, 7);
			} else if ( 'other' === process ) {
				updateProgress(95, 8);
			}
		}

		function startProgressBar(type) {
			noticeTimeout = setTimeout(function() {
				printNotice('info', 'Please, wait. The theme needs a bit more time than expected to import all the attachments.');
			}, 150000);
		}

		function updateProgress(progress, step = 0) {
			var timeout = 400;

			if ($importStatus.length) {
				$importStatus.find('li').removeClass('xts-active');
				$importStatus.find('li').eq(step - 1).addClass('xts-active');
			}

			$(document).trigger('wd-import-progress', {progress: progress});

			function update(value) {
				$progressBar.attr('data-progress', value);
				$progressBar.css('width', value + '%');
				$progressBarPercent.text(value + '%');
			}

			if (progress === 100) {
				timeout = 20;
			}

			var from = $progressBar.attr('data-progress');

			clearInterval(interval);

			interval = setInterval(function() {
				from++;

				update(from);

				if (from >= progress) {
					clearInterval(interval);
				}
			}, timeout);
		}

		function endProgress() {
			clearTimeout(noticeTimeout);
			clearInterval(interval);
		}

		function clearProgressBar() {
			$progressBar.attr('data-progress', '0');
			$progressBar.css('width', '0%');
			$progressBarPercent.text('0%');
		}
	});

	// Search.
	$('.xts-import-search input').on('keyup', function() {
		var val = $(this).val().toLowerCase();

		$('.xts-import-item-wrap.xts-active.xts-cat-show').each(function() {
			var $this = $(this);
			var $data = $this.find('.xts-import-item-title').text().toLowerCase();

			if ($data.indexOf(val) > -1 || $this.find('.xts-import-item').data('tags').indexOf(val) > -1) {
				$this.removeClass('xts-search-hide').addClass('xts-search-show');
			} else {
				$this.addClass('xts-search-hide').removeClass('xts-search-show');
			}
		});

		$(document).trigger('wood-images-loaded');

		if (0 === $('.xts-search-show').length) {
			clearNotices();
			printNotice('info', 'No results were found.');
		} else {
			clearNotices();
		}
	});

	// Filters.
	$('.xts-import-cats-set .xts-set-item').on('click', function() {
		var $catItem = $(this);
		var type = $catItem.data('type');
		var $items = $('.xts-import-item-wrap');
		var $input = $('.xts-import-search input');

		$('.xts-import-cats-list ul[data-type="' + type + '"]').addClass('xts-active').siblings().removeClass('xts-active');

		$catItem.addClass('xts-active');
		$catItem.siblings().removeClass('xts-active');

		$(document).trigger('wood-images-loaded');

		// Reset.
		$input.val('');
		clearNotices();
		$items.removeClass('xts-search-hide xts-search-show');
		$('.xts-import-cats-list li[data-cat="*"]').trigger('click');

		$items.each(function() {
			var $item = $(this);
			var itemType = $item.find('.xts-import-item').data('type');

			if (type === itemType || (type === 'page' && itemType === 'element')) {
				$item.addClass('xts-active');
			} else {
				$item.removeClass('xts-active');
			}
		});
	});

	// Cats.
	$('.xts-import-cats-list li').on('click', function() {
		var $listItem = $(this);
		var category = $listItem.data('cat');
		var $items = $('.xts-import-item-wrap.xts-active');

		$listItem.addClass('xts-active');
		$listItem.siblings().removeClass('xts-active');
		$(document).trigger('wood-images-loaded');

		$items.each(function() {
			var $item = $(this);
			var itemCats = $item.find('.xts-import-item').data('cats');

			if (itemCats.indexOf(category) > -1 || category === '*') {
				$item.removeClass('xts-cat-hide').addClass('xts-cat-show');
			} else {
				$item.addClass('xts-cat-hide').removeClass('xts-cat-show');
			}
		});
	});

	// Remove.
	function initRemove() {
		$('.xts-import-remove input').off('change').on('change', function() {
			var flag = false;
			$('.xts-import-remove input').each(function() {
				if ($(this).prop('checked')) {
					flag = true;
				}
			});
			if (flag) {
				$('.xts-import-remove-btn').removeClass('xts-disabled');
			} else {
				$('.xts-import-remove-btn').addClass('xts-disabled');
			}
		});
		$('.xts-import-remove-select').off('click').on('click', function(e) {
			e.preventDefault();

			$('.xts-import-remove input').each(function() {
				var $input = $(this);
				if ('disabled' !== $input.attr('disabled')) {
					$input.prop('checked', true);
				}
			});
			$('.xts-import-remove-btn').removeClass('xts-disabled');
		});
		$('.xts-import-remove-deselect').off('click').on('click', function(e) {
			e.preventDefault();

			$('.xts-import-remove input').prop('checked', false);
			$('.xts-import-remove-btn').addClass('xts-disabled');
		});
		$('.xts-import-remove-opener').off('click').on('click', function(e) {
			e.preventDefault();

			$('.xts-import-remove').addClass('xts-opened');
			$('html').addClass('xts-popup-opened');
		});
		$('.xts-popup-close, .xts-popup-overlay').off('click').on('click', function(e) {
			e.preventDefault();

			$('.xts-import-remove').removeClass('xts-opened');
			$('html').removeClass('xts-popup-opened');
		});
		$('.xts-import-remove-btn').off('click').on('click', function(e) {
			e.preventDefault();
			var $holder = $('.xts-popup-holder');
			var data = $('.xts-import-remove-form').serializeArray();

			if (!data.length) {
				clearNotices();
				printNotice('info', 'Please, select what exactly do you want to remove from the content.', 'remove');
				return;
			}

			var choice = confirm('Are you sure you want to remove the content? All the changes you made in pages, products, posts, etc. will be lost.');

			if (!choice) {
				return;
			}

			clearNotices();
			$holder.addClass('xts-loading');

			$.ajax({
				url    : woodmartConfig.ajaxUrl,
				data   : {
					action  : 'woodmart_import_remove_action',
					security: woodmartConfig.import_remove_nonce,
					data    : data
				},
				timeout: 1000000,
				error  : function() {
					clearNotices();
					printNotice('error', 'Something wrong with removing data. Please, try to remove data manually or contact our support center for further assistance.', 'remove');
					$holder.removeClass('xts-loading');
				},
				success: function(response) {
					clearNotices();
					printNotice('success', 'Content has been successfully removed!', 'remove');
					$('.xts-import-remove-form-wrap').html(response.content);
					$holder.removeClass('xts-loading');
					initRemove();
					afterRemove();
				}
			});
		});
	}

	initRemove();

	function afterRemove() {
		var flag = false;

		$('.xts-import-remove input').each(function() {
			var $input = $(this);
			var name = $input.attr('name');

			if ('page' === name && 'disabled' === $input.attr('disabled')) {
				$('.xts-imported').removeClass('xts-imported');
				$('.xts-view-page').removeClass('xts-view-page');
			}

			if ('disabled' !== $input.attr('disabled')) {
				flag = true;
			}
		});

		if (!flag) {
			$('.xts-base-imported').removeClass('xts-base-imported');
			$('.xts-has-data').removeClass('xts-has-data');
		}
	}

	// Wizard.
	function wizardDone() {
		var $dummy = $setupWizard.find('.xts-wizard-dummy');

		if ($dummy.length === 0) {
			return;
		}

		$('.xts-next, .xts-skip').on('click', function(e) {
			e.preventDefault();

			$dummy.removeClass('xts-active');
			$('.xts-wizard-import-template').removeClass('xts-active');
			$('.xts-wizard-done').addClass('xts-active');
			$('.xts-wizard-nav li[data-slug="done"]').removeClass('xts-disabled').addClass('xts-active');
			$('.xts-wizard-nav li[data-slug="prebuilt-websites"]').removeClass('xts-active');
		});
	}

	wizardDone();

	// Helpers.
	function printNotice(type, text, location = 'import') {
		if ('remove' === location) {
			$noticesAreaRemove.append('<div class="xts-notice xts-' + type + '">' + text + '</div>');
		} else {
			$('.xts-import-notices').append('<div class="xts-notice xts-' + type + '">' + text + '</div>');
		}
	}

	function clearNotices() {
		$('.xts-import-notices').text('');
		$noticesAreaRemove.text('');
	}


})(jQuery);