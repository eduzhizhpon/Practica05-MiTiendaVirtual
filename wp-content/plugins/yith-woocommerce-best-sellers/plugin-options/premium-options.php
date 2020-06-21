<?php

// Exit if accessed directly
! defined( 'YITH_WCBSL' )  && exit();

return array(
	'premium' => array(
		'landing' => array(
			'type' => 'custom_tab',
			'action' => 'yith_wcbsl_premium_tab',
			'hide_sidebar' => true,
		)
	)
);