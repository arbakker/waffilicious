<?php

/**
 * Adds the Customize page to the WordPress admin area
 */
function example_customizer_menu() {
    add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
}
add_action( 'admin_menu', 'example_customizer_menu' );
/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
function waf_frontpage_tile1( $wp_customize ) {

    $wp_customize->add_section(
        'waf_frontpagepage_section',
        array(
            'title' => 'Front page tile 1',
            'description' => 'Set the lower left front page tile to a page of your choice.',
            'priority' => 35,
        )
    );
    $wp_customize->add_setting('waf_frontpagepage', array(
        'default'        => 'default',
        'type'           => 'option',
    ));

    $wp_customize->add_control('pageControl_1', array(
        'label'      => __('Choose page to feature', 'waffilicious'),
        'section'    => 'waf_frontpagepage_section',
        'type'    => 'dropdown-pages',
        'settings'   => 'waf_frontpagepage',
    ));

}

function waf_frontpage_tile2($wp_customize){
  $wp_customize->add_section(
      'waf_frontpagepage2_section',
      array(
          'title' => 'Front page tile 2',
          'description' => 'Set the lower right front page tile to a page of your choice.',
          'priority' => 45,
      )
  );
  $wp_customize->add_setting('waf_frontpagepage2', array(
      'default'        => 'default',
      'type'           => 'option',
  ));

  $wp_customize->add_control('pageControl_2', array(
      'label'      => __('Choose page to feature', 'waffilicious'),
      'section'    => 'waf_frontpagepage2_section',
      'type'    => 'dropdown-pages',
      'settings'   => 'waf_frontpagepage2',
  ));

}




add_action( 'customize_register', 'waf_frontpage_tile1' );
add_action( 'customize_register', 'waf_frontpage_tile2' );



?>
