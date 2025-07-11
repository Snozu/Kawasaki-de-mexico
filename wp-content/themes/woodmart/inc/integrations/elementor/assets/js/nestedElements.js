jQuery( window ).on('elementor/nested-element-type-loaded', async () => {
	class NestedCarousel extends elementor.modules.elements.types.NestedElementBase {
		getType() {
			return 'wd_nested_carousel';
		}
	}

	class wdToggle extends elementor.modules.elements.types.NestedElementBase {
		getType() {
			return 'wd_toggle';
		}
	}

	class Module {
		constructor() {
			elementor.elementsManager.registerElementType( new NestedCarousel() );
			elementor.elementsManager.registerElementType( new wdToggle() );
		}
	}

	new Module();
});

jQuery( window ).on('elementor/frontend/init', function() {
	if (!elementorFrontend.isEditMode()) {
		return;
	}

	elementorFrontend.hooks.addAction('frontend/element_ready/container', function($wrapper) {
		if ( $wrapper.parent().hasClass('wd-carousel-wrap') ) {
			$wrapper.addClass('wd-carousel-item');
		}
	});
});
