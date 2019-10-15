<?php

defined('ABSPATH') or die('Keep Silent');

$attributes = vc_map_get_attributes($this->getShortcode(), $atts);

ob_start();

$button_top_margin = $button_bottom_margin = "";

//// margin
//if ($attributes['button_top_margin']) :
//    $button_top_margin = 'margin-top:' . $attributes['button_top_margin'] . ';';
//endif;
//
//if ($attributes['button_bottom_margin']) :
//    $button_bottom_margin = 'margin-bottom:' . $attributes['button_bottom_margin'] . ';';
//endif;

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($attributes['css'], ' '), $this->settings['base'], $atts);


// button one
$link = vc_build_link($attributes['button_link']);
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = trim($link['target']);

?>

    <div class="hippo-btn-wrapper <?php echo esc_attr($attributes['button_alignment']. ' ' .$attributes['el_class']. ' ' . $css_class); ?>">
        <a class="btn <?php echo esc_attr($attributes['button_style']. ' ' . $attributes['button_size']) ?>"
           href="<?php echo esc_url($a_href); ?>" target="<?php echo esc_attr($a_target); ?>" title="<?php echo esc_attr($a_title); ?>">
            <?php echo esc_html($attributes['button_text']); ?>
        </a>
    </div> <!-- .hippo-cta-wrapper -->
<?php
echo $this->endBlockComment($this->getShortcode());
echo ob_get_clean();