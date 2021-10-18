<?php
/**
 * @package Helix_Ultimate_Framework
 * @author JoomShaper <support@joomshaper.com>
 * Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use HelixUltimate\Framework\Platform\Helper;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

/**
 * Helix Ultimate Mobile Header layout.
 *
 * @since	1.0.0
 */
class HelixUltimateFeatureMobile
{
	/**
	 * Template parameters
	 *
	 * @var		object	$params		The parameters object
	 * @since	1.0.0
	 */
	private $params;

	/**
	 * Constructor function
	 *
	 * @param	object	$params		The template parameters
	 *
	 * @since	1.0.0
	 */
	public function __construct($params)
	{
		$this->params = $params;
		$this->position = 'mobile';
	}
	
	/**
	 * Render the mobile features
	 *
	 * @return	string
	 * @since	1.0.0
	 */
	public function renderFeature()
	{
		$mobile_sticky_init[] = '';
		$doc = Factory::getDocument();
		$mobile_breakpoint_options     = $this->params->get('mobile_breakpoint_options', 'm');
		$mobile_sticky                 = $this->params->get('mobile_navbar_options', 0);
		$mobile_logo_pos                   = $this->params->get('mobile_logo_options', 'center');
		$remove_logo_padding 		   = $this->params->get('mobile_logo_padding_remove', 0);
		$remove_logo_padding_cls = ($mobile_logo_pos == 'left' || $mobile_logo_pos == 'right') && $remove_logo_padding ? ' uk-padding-remove-' . $mobile_logo_pos : '';

		$mobile_toggle                 = $this->params->get('mobile_toggle_options', 'left');
		$mobile_toggle_text            = $this->params->get('mobile_toggle_text', 0);
		$mobile_animations             = $this->params->get('mobile_animations', 'offcanvas');
		$mobile_offcanvas_mode         = $this->params->get('mobile_offcanvas_mode', 'slide');
		$mobile_dropdown_mode         = $this->params->get('mobile_dropdown_mode', 'slide');
		$mobile_dropdown_toggle        = $mobile_animations === 'dropdown' ? 'animation: true' : '';
		$mobile_dropdown_animation_cls = $mobile_dropdown_mode === 'slide' ? ' class="uk-position-top"' : '';
 
		$mobile_menu_center_vertical = $this->params->get('mobile_menu_center_vertical', 0);
		$mobile_center_text          = $this->params->get('mobile_center_horizontally', 0);
		$mobile_center_text_cls      = $mobile_center_text ? ' uk-text-center' : '';

		$mobile_menu_style = $this->params->get('mobile_menu_options', '');

		$menu_style_cls = empty($mobile_menu_style) ? 'default' : 'primary';
		$menu_style_cls .= $this->params->get('mobile_center_horizontally', 0) ? ' uk-nav-center' : '';

		$menuType = $this->params->get('offcanvas_menu', 'mainmenu', 'STRING');
		$maxLevel = $this->params->get('offcanvas_max_level', 0, 'INT');

		$menuModule = Helper::createModule('mod_menu', [
			'title' => 'Main Menu',
			'params' => '{"menutype":"' . $menuType . '","base":"","startLevel":"1","endLevel":"' . $maxLevel . '","showAllChildren":"1","tag_id":"","class_sfx":"uk-nav uk-nav-' . $menu_style_cls . ($maxLevel != 1 ? ' uk-nav-parent-icon uk-nav-accordion' : '') . '","window_open":"","layout":"_:nav","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0", "hu_offcanvas": 1}',
			'name' => 'menu'
		]); 

		$flex_cls = $mobile_menu_center_vertical ? ' uk-flex' : '';

		$mobile_menu_offcanvas_right = $this->params->get('mobile_menu_offcanvas_right', 0);

		$offcanvas_flip = $mobile_menu_offcanvas_right ? ' flip: true;' : '';

		if ($mobile_sticky) {
			$mobile_sticky_init[] = 'cls-active: uk-navbar-sticky';
			$mobile_sticky_init[] = 'sel-target: .uk-navbar-container';
			if ('2' === $mobile_sticky) {
				$mobile_sticky_init[] = 'show-on-up: true';
				$mobile_sticky_init[] = 'animation: uk-animation-slide-top';
			}
		}

		$logo_mobile = $this->params->get('mobile_logo') || $this->params->get('logo_image') || $this->params->get('logo_text') || $doc->countModules('logo-mobile');

		$logo = $this->params->get('logo_text');
		$sitename = Factory::getApplication()->get('sitename');
		$altText = $this->params->get('logo_alt', $sitename);
	
		$logo_type = $this->params->get('logo_type');

		if($logo_type === 'image') {
			if($this->params->get('mobile_logo')) {
				$logo = '<img class="tm-logo" src="' . $this->params->get('mobile_logo') . '" alt="' . strip_tags($altText) . '" />';
			} elseif($this->params->get('logo_image')) {
				$logo = '<img class="tm-logo" src="' . $this->params->get('logo_image') . '" alt="' . strip_tags($altText) . '" />';
			}
		}

		$logo_init = '';

		if($logo) {
			$logo_init .= '<a class="uk-navbar-item' . $remove_logo_padding_cls . ' uk-logo" href="' . Uri::base(true) . '/">'; 
			$logo_init .= $logo;
			$logo_init .= '</a>';
		}

		$mobile_sticky_init     = ' uk-sticky="' . implode('; ', array_filter($mobile_sticky_init)) . '"';

		$output = '';

		$output  .= '<div class="tm-header-mobile uk-hidden@' . $mobile_breakpoint_options . '">';

		if ($mobile_sticky) {
			$output  .= '<div' . $mobile_sticky_init . '>';
		}

		$output  .= '<div class="uk-navbar-container">';
		$output  .= '<nav class="uk-navbar" uk-navbar>';

		if ($mobile_logo_pos == 'left' || $mobile_toggle == 'left') {
			$output  .= '<div class="uk-navbar-left">';

			if ($mobile_logo_pos == 'left' && $logo_mobile) {
				$output .= $logo_init;
				$output .= '<jdoc:include type="modules" name="logo-mobile" style="warp_xhtml" />';
			}

			if ($mobile_toggle == 'left') {
				$output .= '<a aria-label="' . Text::_('HELIX_ULTIMATE_NAVIGATION') . '" title="' . Text::_('HELIX_ULTIMATE_NAVIGATION') . '" class="uk-navbar-toggle" href="#" uk-toggle="target: #tm-mobile;' . $mobile_dropdown_toggle . '">';
				$output .= '<div uk-navbar-toggle-icon></div>';

				if ($mobile_toggle_text) {
					$output .= '<span class="uk-margin-small-left">' . Text::_('TPL_HELIX_ULTIMATE_MENU') . '</span>';
				}

				$output .= '</a>';
			}

			$output  .= '</div>';
		}

		if ($mobile_logo_pos == 'center' && $logo_mobile) {
			$output  .= '<div class="uk-navbar-center">';
			$output .= $logo_init;
			$output .= '<jdoc:include type="modules" name="logo-mobile" style="warp_xhtml" />';
			$output  .= '</div>';
		}

		if ($mobile_logo_pos == 'right' || $mobile_toggle == 'right') {
			$output  .= '<div class="uk-navbar-right">';

			if ($mobile_toggle == 'right') {
				$output .= '<a aria-label="' . Text::_('HELIX_ULTIMATE_NAVIGATION') . '" title="' . Text::_('HELIX_ULTIMATE_NAVIGATION') . '" class="uk-navbar-toggle" href="#" uk-toggle="target: #tm-mobile;' . $mobile_dropdown_toggle . '">';
				$output .= '<div uk-navbar-toggle-icon></div>';
				if ($mobile_toggle_text) {
					$output .= '<span class="uk-margin-small-left">' . Text::_('TPL_HELIX_ULTIMATE_MENU') . '</span>';
				}
				$output .= '</a>';
			}

			if ($mobile_logo_pos == 'right' && $logo_mobile) {
				$output .= $logo_init;
				$output .= '<jdoc:include type="modules" name="logo-mobile" style="warp_xhtml" />';
			}

			$output  .= '</div>';
		}

		$output  .= '</nav>';
		$output  .= '</div>';

		if ($mobile_animations == 'dropdown') {

			if ($mobile_dropdown_mode == 'slide') {
				$output  .= '<div class="uk-position-relative tm-header-mobile-slide">';
			}

			$output  .= '<div id="tm-mobile"' . $mobile_dropdown_animation_cls . ' hidden>';
			$output  .= '<div class="uk-background-default uk-padding' . $mobile_center_text_cls . '">';

			$output  .= '<div class="uk-child-width-1-1 uk-grid" uk-grid>';

			$output  .= '<div>';

			$output  .= ModuleHelper::renderModule($menuModule);

			$output  .= '</div>';

			$output  .= '<jdoc:include type="modules" name="mobile" style="sp_xhtml" />';
			
			$output  .= '</div>';

			$output  .= '</div>';
			$output  .= '</div>';

			if ($mobile_dropdown_mode == 'slide') {
				$output  .= '</div>';
			}
		}

		if ($mobile_sticky) {
			$output  .= '</div>';
		}

		if ($mobile_animations == 'offcanvas') {
			$output  .= '<div id="tm-mobile" class="uk-offcanvas" uk-offcanvas="mode:' . $mobile_offcanvas_mode . ';' . $offcanvas_flip . ' overlay: true">';
			$output  .= '<div class="uk-offcanvas-bar' . $mobile_center_text_cls . $flex_cls . '">';

			$output  .= '<button class="uk-offcanvas-close" type="button" uk-close></button>';

			if ($mobile_menu_center_vertical) {
				$output  .= '<div class="uk-margin-auto-vertical uk-width-1-1">';
			}

			$output  .= '<div class="uk-child-width-1-1 uk-grid" uk-grid>';

			$output  .= '<div>';

			$output  .= ModuleHelper::renderModule($menuModule);

			$output  .= '</div>';

			$output  .= '<jdoc:include type="modules" name="mobile" style="sp_xhtml" />';
			
			$output  .= '</div>';

			if ($mobile_menu_center_vertical) {
				$output  .= '</div>';
			}

			$output  .= '</div>';
			$output  .= '</div>';
		}

		if ($mobile_animations == 'modal') {
			$output  .= '<div id="tm-mobile" class="uk-modal-full" uk-modal>';
			$output  .= '<div class="uk-modal-dialog uk-modal-body' . $mobile_center_text_cls . $flex_cls . ' uk-height-viewport">';
			$output  .= '<button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>';
			
			if ($mobile_menu_center_vertical) {
				$output  .= '<div class="uk-margin-auto-vertical uk-width-1-1">';
			}

			$output  .= '<div class="uk-child-width-1-1 uk-grid" uk-grid>';

			$output  .= '<div>';

			$output  .= ModuleHelper::renderModule($menuModule);

			$output  .= '</div>';

			$output  .= '<jdoc:include type="modules" name="mobile" style="sp_xhtml" />';

			$output  .= '</div>';

			if ($mobile_menu_center_vertical) {
				$output  .= '</div>';
			}

			$output  .= '</div>';
			$output  .= '</div>';
		}

		$output  .= '</div>';
		return $output;
	}
}
