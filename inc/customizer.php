<?php
/**
 * elektrika220-380 Theme Customizer
 *
 * @package elektrika220-380
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function elektrika220_380_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->add_section(
		'section_one', array(
			'title' => 'Настройки сайта',
			'description' => '',
			'priority' => 11,
		)
	);
	$wp_customize->add_setting('logo_header'); 	
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_header', array(
		'label'    => 'Логотип дла шапки',
		'section'  => 'section_one',
		'settings' => 'logo_header',
	)));
	$wp_customize->add_setting('logo_footer'); 	
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_footer', array(
		'label'    => 'Логотип для футера',
		'section'  => 'section_one',
		'settings' => 'logo_footer',
	)));	
	$wp_customize->add_setting('phone', 
		array('default' => '')
	);
	$wp_customize->add_control('phone', array(
			'label' => 'Телефон',
			'section' => 'section_one',
			'type' => 'text',
		)
	);
	$wp_customize->add_setting('work_hours', 
		array('default' => '')
	);
	$wp_customize->add_control('work_hours', array(
			'label' => 'Часы работы',
			'section' => 'section_one',
			'type' => 'text',
		)
	);	
	$wp_customize->add_setting('header_banner_text', 
		array('default' => '')
	);
	$wp_customize->add_control('header_banner_text', array(
			'label' => 'Текст баннера в шапке',
			'section' => 'section_one',
			'type' => 'textarea',
		)
	);	
	$wp_customize->add_setting('email', 
		array('default' => '')
	);
	$wp_customize->add_control('email', array(
			'label' => 'email',
			'section' => 'section_one',
			'type' => 'text',
		)
	);
	$wp_customize->add_setting('skype', 
		array('default' => '')
	);
	$wp_customize->add_control('skype', array(
			'label' => 'skype',
			'section' => 'section_one',
			'type' => 'text',
		)
	);	
	$wp_customize->add_setting('twitter', 
		array('default' => '')
	);
	$wp_customize->add_control('twitter', array(
			'label' => 'Мы в Twitter',
			'section' => 'section_one',
			'type' => 'text',
		)
	);
	$wp_customize->add_setting('vk', 
		array('default' => '')
	);
	$wp_customize->add_control('vk', array(
			'label' => 'Мы в Вконтакте',
			'section' => 'section_one',
			'type' => 'text',
		)
	);
	$wp_customize->add_setting('facebook', 
		array('default' => '')
	);
	$wp_customize->add_control('facebook', array(
			'label' => 'Мы в Facebook',
			'section' => 'section_one',
			'type' => 'text',
		)
	);
	$wp_customize->add_setting('livejournal', 
		array('default' => '')
	);
	$wp_customize->add_control('livejournal', array(
			'label' => 'livejournal',
			'section' => 'section_one',
			'type' => 'text',
		)
	);
	$wp_customize->add_setting('RSS', 
		array('default' => '')
	);
	$wp_customize->add_control('RSS', array(
			'label' => 'RSS',
			'section' => 'section_one',
			'type' => 'text',
		)
	);	
	$wp_customize->add_setting('mail', 
		array('default' => '')
	);
	$wp_customize->add_control('mail', array(
			'label' => 'Mail',
			'section' => 'section_one',
			'type' => 'text',
		)
	);
	$wp_customize->add_setting('OK', 
		array('default' => '')
	);
	$wp_customize->add_control('OK', array(
			'label' => 'Одноклассники',
			'section' => 'section_one',
			'type' => 'text',
		)
	);		
}
add_action( 'customize_register', 'elektrika220_380_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function elektrika220_380_customize_preview_js() {
	wp_enqueue_script( 'elektrika220_380_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'elektrika220_380_customize_preview_js' );
