<?php
/**
 * @package Helix_Ultimate_Framework
 * @author JoomShaper <support@joomshaper.com>
 * Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/**
 * Helix ultimate custom search features
 *
 * @since	1.0.0
 */
class HelixUltimateFeatureSearch
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
        $this->position = $this->params->get('search_position', 'header');
        $this->app      = Factory::getApplication();
        $this->input    = $this->app->input;

        // Load the smart search component language file.
        $lang = $this->app->getLanguage();
        $lang->load('com_finder', JPATH_SITE);

    }
    
	/**
	 * Render the contact features
	 *
	 * @return	string
	 * @since	1.0.0
	 */
	public function renderFeature()
	{
        $app = Factory::getApplication();

        if (JVERSION >= 4) {
        // Load the smart search component language file.
        $lang = $app->getLanguage();
        $lang->load('com_finder', JPATH_SITE);
        // Get the route.
        $route = Joomla\Component\Finder\Site\Helper\RouteHelper::getSearchRoute($this->params->get('searchfilter', null));
        }

        $mitemid = (int) $this->input->get('Itemid', '', 'INT');
        $navbar_search = $this->params->get('search_position');

        $search_style = $this->params->get('search_style');
        $header_container = $this->params->get('header_style');
        $output = '';
        if (JVERSION < 4) {
            if ($navbar_search != 'hide') {
                if ($search_style == 'modal' && !in_array($header_container, ['style-10', 'style-11', 'style-12', 'style-13', 'style-14', 'style-15', 'style-16', 'style-17'])) {
                    $output .= '<a class="uk-search-toggle" href="#search-header-modal" uk-search-icon uk-toggle></a>';
                    $output .= '<div id="search-header-modal" class="uk-modal-full" uk-modal>';
                    $output .= '<div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>';
                    $output .= '<button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>';
                    $output .= '<div class="uk-search uk-search-large">';
                    $output .= '<form id="searchForm" class="uk-search uk-search-large" action="' . Route::_('index.php?option=com_search') . '" method="post">';
                    $output .= '<input name="searchword" class="uk-search-input uk-text-center" type="search" placeholder="' . Text::_("HELIX_ULTIMATE_SEARCH_FEATURE") . '" autofocus>';
                    $output .= '<input type="hidden" name="task" value="search">';
                    $output .= '<input type="hidden" name="option" value="com_search">';
                    $output .= '<input type="hidden" name="Itemid" value="' . $mitemid . '">';
                    $output .= '</form>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                } else {
                    $output .= '<form class="uk-search uk-search-default" action="' . Route::_('index.php?option=com_search') . '" method="post">';
                    $output .= '<span uk-search-icon></span>';
                    $output .= '<input name="searchword" class="uk-search-input" type="search" placeholder="' . Text::_("HELIX_ULTIMATE_SEARCH_FEATURE") . '">';
                    $output .= '<input type="hidden" name="task" value="search">';
                    $output .= '<input type="hidden" name="option" value="com_search">';
                    $output .= '<input type="hidden" name="Itemid" value="' . $mitemid . '">';
                    $output .= '</form>';
                }
            }
      
        } else {
            if ($navbar_search != 'hide') {
                if ($search_style == 'modal' && !in_array($header_container, ['style-10', 'style-11', 'style-12', 'style-13', 'style-14', 'style-15', 'style-16', 'style-17'])) {
                    $output .= '<a class="uk-search-toggle" href="#search-header-modal-' . $mitemid . '" uk-search-icon uk-toggle></a>';
                    $output .= '<div id="search-header-modal-' . $mitemid . '" class="uk-modal-full" uk-modal>';
                    $output .= '<div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>';
                    $output .= '<button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>';
                    $output .= '<div class="uk-search uk-search-large">';
                    $output .= '<form id="searchForm" class="uk-search uk-search-large" action="' . Route::_($route) . '" method="get" role="search">';
                    $output .= '<span uk-search-icon></span>';
                    $output .= '<input type="text" name="q" id="q" class="uk-search-input uk-text-center" value="' . htmlspecialchars($app->input->get('q', '', 'string'), ENT_COMPAT, 'UTF-8') . '"'
                    . ' placeholder="' . Text::_('HELIX_ULTIMATE_SEARCH_FEATURE') . '" autofocus>';
                    $output .= Joomla\Module\Finder\Site\Helper\FinderHelper::getGetFields($route, (int) $this->params->get('set_itemid', 0));
                    $output .= '</form>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                } else {
                    $output .= '<form class="uk-search uk-search-default" action="' . Route::_($route) . '" method="get" role="search">';
                    $output .= '<span uk-search-icon></span>';
                    $output .= '<input type="search" name="q" id="q" class="uk-search-input"  value="' . htmlspecialchars($app->input->get('q', '', 'string'), ENT_COMPAT, 'UTF-8') . '"'
                    . ' placeholder="' . Text::_("HELIX_ULTIMATE_SEARCH_FEATURE") . '">';
                    $output .= Joomla\Module\Finder\Site\Helper\FinderHelper::getGetFields($route, (int) $this->params->get('set_itemid', 0));
                    $output .= '</form>';
                }
            }

        }
        return $output;
    }
}
