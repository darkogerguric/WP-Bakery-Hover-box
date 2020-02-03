<?php
/*
Plugin Name: Simple Visual Composer Hover Box
Plugin URI:  https://plugins.darkog.pro/hover-box-demo/
Description: Hover Box for Visual composer
Version:     2.0
Author:      Darko Gerguric
Author URI:  https://darkog.pro
License:     GPL2
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );




class dgHoverBox {


// Element Init
function __construct() {
  add_action( 'init', array( $this, 'dg_hoverbox_mapping' ) );
  add_shortcode( 'dg_hoverbox', array( $this, 'dg_hoverbox_html' ) );
  // Register CSS and JS
  add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
}






// Element Mapping
public function dg_hoverbox_mapping() {

// Check if Visual Composer is installed
    if ( ! defined( 'WPB_VC_VERSION' ) ) {
        // Display notice that Visual Compser is required
        add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
        return;
    }


    // Map the block with vc_map()
    vc_map(
        array(
            'name' => __('Simple HoverBox', 'vc_extend'),
            'base' => 'dg_hoverbox',
            'description' => __('Simple HoverBox for WP Bakery Page Builder', 'vc_extend'),
            'category' => __('Simple Addons', 'js_composer'),
            'icon' => plugin_dir_url( __FILE__ ).'/img/hover.png',
            'params' => array(

                array(
                    'type' => 'attach_image',
                    'holder' => 'div',
                    'class' => 'img-class',
                    'heading' => __( 'Image', 'text-domain' ),
                    'param_name' => 'image',
                    'group' => __( 'Visible image and text', 'my-text-domain' ),

                    'description' => __( 'Image', 'text-domain' ),
                    'admin_label' => false,
                    'weight' => 0,

                ),

                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __( 'Visible Text', 'text-domain' ),
                    'param_name' => 'visible_text',
                    'value' => __( "Change text here", "my-text-domain" ),
                    'description' => __( 'Visible Text', 'text-domain' ),
                    'group' => __( 'Visible image and text', 'my-text-domain' ),


                ),


                /*   array(
                  'type' => 'css_editor',
                  'heading' => __( 'Css', 'my-text-domain' ),
                  'param_name' => 'css-image',
                  'group' => __( 'Visible image and text', 'my-text-domain' ),
                ), */

             

                
                 array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => __( "Visible Text color", "my-text-domain" ),
                    "param_name" => "vis_text_color",
                    "value" => '#FF0000', //Default Red color
                    "description" => __( "Choose text color", "my-text-domain" ),
                    'group' => __( 'Visible image and text', 'my-text-domain' ),
                 ),

                  array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => __( "Visible Text Background Color", "my-text-domain" ),
                    "param_name" => "vis_text_bg",
                    "value" => '#000000', //Default Red color
                    "description" => __( "Choose text background color", "my-text-domain" ),
                    'group' => __( 'Visible image and text', 'my-text-domain' ),
                 ),

                   array(
                           "type" => "textfield",

                           "class" => "",
                           "heading" => __( "Font size (px, em, etc)", "my-text-domain" ),
                           "param_name" => "vis_font-size",
                           "value" => __( "inherit", "my-text-domain" ),
                           "description" => __( "Set Font Size (example: 25px)", "my-text-domain" ),
                           'group' => __( 'Visible image and text', 'my-text-domain' ),
                        ),

                array(
                'type' => 'css_editor',
                'heading' => __( 'Css', 'my-text-domain' ),
                'param_name' => 'css',
                'group' => __( 'Visible image and text', 'my-text-domain' ),
              ),

              array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => __( "Overlay Background Color", "my-text-domain" ),
                    "param_name" => "ovrl_bg",
                    "value" => '#000000', //Default color
                    "description" => __( "Choose overlay background color", "my-text-domain" ),
                    'group' => __( 'Overlay', 'my-text-domain' ),
                 ),

            array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => __( "Overlay Text Color", "my-text-domain" ),
                    "param_name" => "ovrl_txt_clr",
                    "value" => '#000000', //Default  color
                    "description" => __( "Choose overlay text color", "my-text-domain" ),
                    'group' => __( 'Overlay', 'my-text-domain' ),
                 ),     

            array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => __( "Overlay Link Color", "my-text-domain" ),
                    "param_name" => "ovrl_lnk_clr",
                    "value" => '#000000', //Default  color
                    "description" => __( "Choose link text color", "my-text-domain" ),
                    'group' => __( 'Overlay', 'my-text-domain' ),
                 ),          

             array(
                           "type" => "textarea_html",
                           "holder" => "div",
                           "class" => "",
                           "heading" => __( "Overlay Text", "my-text-domain" ),
                           "param_name" => "content",
                           "description" => __( "Set Overlay Text", "my-text-domain" ),
                           "value" => __( "<p>I am test text block. Click edit button to change this text.</p>", "my-text-domain" ),
                           'group' => __( 'Overlay', 'my-text-domain' ),
                        ),


            ),
        )
    );

}


// Element HTML
public function dg_hoverbox_html( $atts , $content = NULL) {

    // Params extraction
    extract(
        shortcode_atts(
            array(
                'image'                 => '',
                'css'                   => '',
                'visible_text'          => '',
                'vis_text_color'        => '',
                'vis_font-size'         => '',
                'vis_text_bg'           => '',
                'radius'                => '',
                'font-size'             => '',
                'css-image'             => '',
                'ovrl_bg'               => '',
                'ovrl-text'             => '',
                'ovrl_txt_clr'          => '',
                'ovrl_lnk_clr'          => '',
                'foo'          => 'something'


            ),
            $atts
        )
    );
      //$atts['content'] = $content;
    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
     $image_url = wp_get_attachment_url($atts['image']);
     $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );

     $css_image_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css-image'], ' ' ), $this->settings['base'], $atts );
    // Fill $html var with data
    $output = '


    

         <div class="visible_image dh-container" style="background:url('.$image_url.'); background-repeat:no-repeat;background-position:center; background-size:cover;">
         
         <div class="visible_text " style="color:'.$atts['vis_text_color'].';background-color:'.$atts['vis_text_bg'].';font-size:'.$atts['vis_font-size'].';">'.$atts['visible_text'].'</div>
       

        <div class="dh-overlay '.$css_class.'" style="color:;font-size:'.$atts['font-size'].';background-color:'.$atts['ovrl_bg'].'"><div style="color:'. $atts['ovrl_txt_clr'] .';">'.$content.'</div>

        </div>

    <style>.dh-overlay a{ color:'.$atts['ovrl_lnk_clr'].'}</style>

    </div>
    

    ';

    //$output = "<div style='color:{$color};' data-foo='${visible_text}'>{$content}</div>";
    // $output='testing';
    return $output;

}


    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
     // wp_register_style( 'vc_extend_style', plugins_url('assets/style.css', __FILE__) );
      //wp_enqueue_style( 'vc_extend_style' );

      wp_enqueue_style( 'directions_style', plugins_url('assets/jquery.directional-hover.min.css', __FILE__) );
      wp_enqueue_style( 'vc_extend_style', plugins_url('assets/style.css', __FILE__) );

      // If you need any javascript files on front end, here is how you can load them.
      wp_enqueue_script( 'directions_js', plugins_url('assets/jquery.directional-hover.min.js', __FILE__), array('jquery') );
      wp_enqueue_script( 'vc_extend_js', plugins_url('assets/scripts.js', __FILE__), array('jquery') );
    }

/*
Show notice if your plugin is activated but Visual Composer is not
*/
public function showVcVersionNotice() {
    $plugin_data = get_plugin_data(__FILE__);
    echo '
    <div class="updated">
      <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
    </div>';
}




} // End Element Class


// Element Class Init
new dgHoverBox();