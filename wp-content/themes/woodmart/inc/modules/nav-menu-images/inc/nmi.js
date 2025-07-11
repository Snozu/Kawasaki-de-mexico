/**
 * Display thumb when set as featured.
 *
 * Overwritess built in function.
 */
function WPSetThumbnailID(id) {
	tb_remove();
	jQuery.post(ajaxurl, {
			action      : 'nmi_added_thumbnail',
			thumbnail_id: id,
			post_id     : window.clicked_item_id,
			security    : woodmartConfig.mega_menu_added_thumbnail_nonce
		}, function(response) {
			jQuery('li#menu-item-' + window.clicked_item_id + ' .nmi-current-image').html(response);
			tb_remove();
		}
	);
}

function WPSetThumbnailHTML(html) {
}
(function($) {
	$(document).on('menu-item-added', function() {
		initCustomMenuFields();
	});

	jQuery(document).ready(function() {
		initCustomMenuFields();
	});

	function initCustomMenuFields() {
		// Get all menu items
		var items = $('ul#menu-to-edit li.menu-item');

		// Go through all items and display link & thumb
		for (var i = 0; i < items.length; i++) {
			var id = $(items[i]).children('#nmi_item_id').val();
			var sibling = $('#edit-menu-item-attr-title-' + id).parent().parent();
			var customFields = $('li#menu-item-' + id + ' .nmi-item-custom-fields');

			if (customFields) {
				sibling.after(customFields);
			}
		}

		// Save item ID on click on a link
		$('.nmi-upload-link').click(function() {
			window.clicked_item_id = $(this).parent().parent().children('#nmi_item_id').val();
		});

		// Display alert when not added as featured
		window.send_to_editor = function(html) {
			alert(nmi_vars.alert);
			tb_remove();
		};

		$('.nmi-item-custom-fields').find('select').on('change', function() {
			var $this = $(this);
			var selectValue = $this.val();

			if ( 'nmi-design' === $this.data('field') ) {
				$this.parents('.nmi-item-custom-fields').removeClass('wd-design-default wd-design-full-width wd-design-full-height wd-design-sized wd-design-aside').addClass('wd-design-' + selectValue );
			}
		})

		// Menu block edit link
		$('.nmi-block select').on('change', function() {
			$('.edit-block-link').attr('href', $(this).find('option:selected').data('edit-link')).show();
		})
	}
})(jQuery);
