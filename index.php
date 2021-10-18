<?php
/**
 * @package Helix_Ultimate_Framework
 * @author JoomShaper <support@joomshaper.com>
 * Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined('_JEXEC') or die('Restricted Direct Access!');

use HelixUltimate\Framework\Core\HelixUltimate;
use HelixUltimate\Framework\Platform\Helper;
use HelixUltimate\Framework\System\JoomlaBridge;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$app = Factory::getApplication();
$this->setHtml5(true);

/**
 * Load the framework bootstrap file for enabling the HelixUltimate\Framework namespacing.
 *
 * @since	2.0.0
 */
$bootstrap_path = JPATH_PLUGINS . '/system/helixultimate/bootstrap.php';

if (file_exists($bootstrap_path))
{
	require_once $bootstrap_path;
}
else
{
	die('Install and activate <a target="_blank" rel="noopener noreferrer" href="https://www.joomshaper.com/helix">Helix Ultimate Framework</a>.');
}

/**
 * Get the theme instance from Helix framework.
 *
 * @var		$theme		The theme object from the class HelixUltimate.
 * @since	1.0.0
 */
$theme = new HelixUltimate;
$template = Helper::loadTemplateData();
$this->params = $template->params;

/** Load needed data for javascript */
Helper::flushSettingsDataToJs();

$tpl_assets = $this->params->get('tpl_assets');

// Coming Soon
if (!\is_null($this->params->get('comingsoon', null)))
{
	header("Location: " . Route::_(Uri::root(true) . "/index.php?templateStyle={$template->id}&tmpl=comingsoon", false));
    exit();
}

$custom_style = $this->params->get('custom_style');
$preset = $this->params->get('preset');

if($custom_style || !$preset)
{
    $scssVars = array(
        'preset' => 'default',
        'topbar_bg_color' => $this->params->get('topbar_bg_color'),
        'topbar_text_color' => $this->params->get('topbar_text_color'),
        'topbar_link_color' => $this->params->get('topbar_link_color'),
        'topbar_link_hover_color' => $this->params->get('topbar_link_hover_color'),        
        'text_color' => $this->params->get('text_color'),
        'bg_color' => $this->params->get('bg_color'),
        'link_color' => $this->params->get('link_color'),
        'second_link_color' => $this->params->get('second_link_color'),
        'link_hover_color' => $this->params->get('link_hover_color'),
        'header_top_bg_color' => $this->params->get('header_top_bg_color'), 
        'header_bg_color' => $this->params->get('header_bg_color'), 
        'header_bottom_bg_color' => $this->params->get('header_bottom_bg_color'), 
        'logo_text_color' => $this->params->get('logo_text_color'),
        'header_bg_mobile_color' => $this->params->get('header_bg_mobile_color'), 
        'logo_text_mobile_color' => $this->params->get('logo_text_mobile_color'),
        'toggle_mobile_color' => $this->params->get('toggle_mobile_color'),
        'toggle_mobile_hover_color' => $this->params->get('toggle_mobile_hover_color'),
        'menu_text_color' => $this->params->get('menu_text_color'),
        'menu_text_hover_color' => $this->params->get('menu_text_hover_color'),
        'menu_text_active_color' => $this->params->get('menu_text_active_color'),
        'menu_dropdown_bg_color' => $this->params->get('menu_dropdown_bg_color'),
        'menu_dropdown_text_color' => $this->params->get('menu_dropdown_text_color'),
        'menu_dropdown_text_hover_color' => $this->params->get('menu_dropdown_text_hover_color'),
        'menu_dropdown_text_active_color' => $this->params->get('menu_dropdown_text_active_color'),
        'bottom_bg_color' => $this->params->get('bottom_bg_color'),
        'bottom_title_color' => $this->params->get('bottom_title_color'),
        'bottom_text_color' => $this->params->get('bottom_text_color'),
        'bottom_link_color' => $this->params->get('bottom_link_color'),
        'bottom_link_hover_color' => $this->params->get('bottom_link_hover_color'),        
        'footer_bg_color' => $this->params->get('footer_bg_color'),
        'footer_text_color' => $this->params->get('footer_text_color'),
        'footer_link_color' => $this->params->get('footer_link_color'),
        'footer_link_hover_color' => $this->params->get('footer_link_hover_color')
    );
} else {
    $scssVars = (array) json_decode($this->params->get('preset'));
}

$scssVars['header_stacked_margin'] = $this->params->get('header_stacked_margin', '20px');
$scssVars['topbar_padding_top'] = $this->params->get('topbar_padding_top', '10px');
$scssVars['topbar_padding_bottom'] = $this->params->get('topbar_padding_bottom', '10px');
$scssVars['toolbar_font_size'] = $this->params->get('toolbar_font_size', '14px');
$scssVars['social_icons_size'] = $this->params->get('social_icons_size', '16px');
$scssVars['header_height'] = $this->params->get('header_height', '82px');
$scssVars['dropdown_width'] = $this->params->get('dropdown_width', '200px');
$scssVars['headerbar_top_padding'] = $this->params->get('headerbar_top_padding', '20px');
$scssVars['headerbar_bottom_padding'] = $this->params->get('headerbar_bottom_padding', '20px');
$scssVars['header_stacked_margin'] = $this->params->get('header_stacked_margin', '20px');
$scssVars['offcanvas_width'] = $this->params->get('offcanvas_width', '300') . 'px';
$scssVars['body_bg_color'] = $this->params->get('body_bg_color', '#f0f0f0');

$boxed = $this->params->get('boxed_layout');
$boxed_center = $this->params->get('boxed_center') ? ' uk-margin-auto' : '';
$boxed_top_margin = $this->params->get('boxed_top_margin') ? ' tm-page-margin-top' : '';
$boxed_bottom_margin = $this->params->get('boxed_bottom_margin') ? ' tm-page-margin-bottom' : '';
$boxed_header_outside = $this->params->get('boxed_header_outside');

// Body Background Image
$body_media[] = $boxed ? ' uk-clearfix' : '';

$bg_image = $this->params->get('body_bg_image');
$body_image_size = $this->params->get('body_image_size') ? ' uk-background-'.$this->params->get('body_image_size') : '';
$body_image_position = $this->params->get('body_image_position') ? ' uk-background-'.$this->params->get('body_image_position') : '';
$body_image_visibility = $this->params->get('body_image_visibility') ? ' uk-background-image@'.$this->params->get('body_image_visibility') : '';

$body_image_effect = $this->params->get('body_image_effect');
$body_image_effect_init = $body_image_effect == 'parallax' ? ' uk-background-fixed' : '';
$body_image_effect_init .= $body_image_effect ? ' uk-position-cover uk-position-fixed' : '';

$body_media_init = $boxed && empty($body_image_effect) && $bg_image;

if ($body_media_init) {
    $body_media[] = ' uk-background-norepeat';
    $body_media[] = $body_image_size . $body_image_position . $body_image_visibility;
}

$body_parallax_bgx_start = $this->params->get('body_parallax_bgx_start', '0');
$body_parallax_bgx_end = $this->params->get('body_parallax_bgx_end', '0');
$body_parallax_bgy_start = $this->params->get('body_parallax_bgy_start', '0');
$body_parallax_bgy_end = $this->params->get('body_parallax_bgy_end', '0');

$body_parallax_easing     = $this->params->get('body_parallax_easing') ? ( (int) $this->params->get('body_parallax_easing') / 100 ) : '';
$body_parallax_easing_cls = ( ! empty( $body_parallax_easing ) ) ? 'easing: ' . $body_parallax_easing . ';' : '';

$body_parallax_breakpoint     = $this->params->get('body_parallax_breakpoint');
$body_parallax_breakpoint_cls = ( ! empty( $body_parallax_breakpoint ) ) ? 'media: @' . $body_parallax_breakpoint . ';' : '';

$bgx       = ( ! empty( $body_parallax_bgx_start ) || ! empty( $body_parallax_bgx_end ) ) ? 'bgx: ' . $body_parallax_bgx_start . ',' . $body_parallax_bgx_end . ';' : '';
$bgy       = ( ! empty( $body_parallax_bgy_start ) || ! empty( $body_parallax_bgy_end ) ) ? 'bgy: ' . $body_parallax_bgy_start . ',' . $body_parallax_bgy_end . ';' : '';

$body_parallax = $body_image_effect == 'parallax' ? ' uk-parallax="'.$bgx . $bgy . $body_parallax_easing_cls . $body_parallax_breakpoint_cls .'target:body"' : '';

$body_media       = implode( '', array_filter( $body_media ) );

// Custom CSS
if ($custom_css = $this->params->get('custom_css'))
{
	$this->addStyledeclaration($custom_css);
}

$progress_bar_position = $this->params->get('reading_timeline_position');

if($app->input->get('view') === 'article' && $this->params->get('reading_time_progress', 0))
{
	$progress_style = 'position:fixed;';
	$progress_style .= 'z-index:9999;';
	$progress_style .= 'height:'.$this->params->get('reading_timeline_height').';';
	$progress_style .= 'background-color:'.$this->params->get('reading_timeline_bg').';';
	$progress_style .= $progress_bar_position == 'top' ? 'top:0;' : 'bottom:0;';
	$progress_style = '.sp-reading-progress-bar { '.$progress_style.' }';
	$this->addStyledeclaration($progress_style);
}

// Custom JS
if ($custom_js = $this->params->get('custom_js', null))
{
	$this->addScriptDeclaration($custom_js);
}

?>

<!doctype html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>

		<?php echo $theme->googleAnalytics(); ?>

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php

		$theme->head();
        $theme->loadFontAwesome();
        $theme->add_js('uikit.min.js, main.js');

		/**
		 * Add custom.js for user
		 */
		if (file_exists(JPATH_THEMES . '/' . $template->template . '/js/custom.js'))
		{
			$theme->add_js('custom.js');
		}        

        if($this->direction === 'rtl')
        {
            $theme->add_css('uikit-rtl.min.css');
            $theme->add_scss('rtl', $scssVars, 'rtl');
        } else {
            $theme->add_css('uikit.min.css');
        }
        
        $theme->add_scss('master', $scssVars, 'template');

        $theme->add_scss('presets', $scssVars, 'presets/' . $scssVars['preset']);
        
        $theme->add_scss('custom', $scssVars, 'custom-compiled');
		$theme->add_css('custom.css');

        //Icon Library
        if ($tpl_assets) {
            $theme->add_js('uikit-icons.min.js');
        }

		//Before Head
		if ($before_head = $this->params->get('before_head'))
		{
			echo $before_head . "\n";
		}
    ?>
 
</head>

<body class="<?php echo $theme->bodyClass(); ?>">  

        <?php if ($this->params->get('after_body', '')): ?>
			<?php echo $this->params->get('after_body') . "\n"; ?>
		<?php endif ?>

        <?php if ($this->params->get('preloader')) : ?>
            <div id="preloader" class="uk-width-1-1 uk-height-1-1 uk-position-fixed uk-overflow-hidden uk-background-default" style="z-index: 9999;">
                <div class="uk-position-center">
                    <span class="uk-text-primary" uk-spinner="ratio: 2"></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if($body_media_init) : ?>
            <div class="body-wrapper<?php echo $body_media; ?>" data-src="<?php echo Uri::base(true) . '/' . $bg_image; ?>" uk-img>
        <?php else: ?>
            <div class="body-wrapper<?php echo $body_media; ?>">
        <?php endif; ?>

        <?php if ($boxed && $bg_image && $body_image_effect) : ?>
            <div class="uk-background-norepeat<?php echo $body_image_size; echo $body_image_position; echo $body_image_visibility; echo $body_image_effect_init; ?>" data-src="<?php echo Uri::base(true) . '/' . $bg_image; ?>" uk-img<?php echo $body_parallax; ?>></div>
        <?php endif; ?>

        <?php if ($boxed_header_outside) : ?>
            <?php echo $theme->getHeaderStyle(); ?>
        <?php endif; ?>
 
        <?php if ($boxed) : ?>
            <div class="tm-page<?php echo $boxed_center; echo $boxed_top_margin; echo $boxed_bottom_margin; ?>">
        <?php endif; ?>

            <?php if (!$boxed_header_outside) : ?>
                <?php echo $theme->getHeaderStyle(); ?>
            <?php endif; ?>
            
            <?php $theme->render_layout(); ?>

            <?php if ($boxed) : ?>
            </div>
        <?php endif; ?>

    </div>

    <?php $theme->after_body(); ?>

    <jdoc:include type="modules" name="debug" style="none" />

    <?php if ($this->params->get('preloader')) : ?>
        <script>
            jQuery(function($) {
                $(window).on('load', function() {
                    $('#preloader').fadeOut(500, function() {
                        $(this).remove();
                    });
                });
            });
        </script>
    <?php endif; ?>
    
    <?php if ($this->params->get('goto_top', 0)) : ?>
        <a href="#" class="back__top" aria-label="<?php echo Text::_('HELIX_ULTIMATE_SCROLL_UP_ARIA_LABEL'); ?>" uk-totop uk-scroll></a>
    <?php endif; ?>

    <?php if( $app->input->get('view') === 'article' && $this->params->get('reading_time_progress', 0) ): ?>
			<div data-position="<?php echo $progress_bar_position; ?>" class="sp-reading-progress-bar"></div>
	<?php endif; ?>
    
</body>

</html>