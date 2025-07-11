<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'textAlign',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'textAlignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'textAlignMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-thankyou-order-received',
	array(
		array(
			'attr_name' => 'successTextColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'successTextColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-thankyou-order-failed',
	array(
		array(
			'attr_name' => 'failedTextColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'failedTextColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);


$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .woocommerce-thankyou-order-received', $attrs, 'successTextTp' ) );

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .woocommerce-thankyou-order-failed', $attrs, 'failedTextTp' ) );

$block_css->merge_with(
	wd_get_block_advanced_css(
		array(
			'selector'       => $block_selector,
			'selector_hover' => $block_selector_hover,
		),
		$attrs
	)
);

return $block_css->get_css_for_devices();
