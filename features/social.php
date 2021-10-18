<?php
/**
 * @package Helix_Ultimate_Framework
 * @author JoomShaper <support@joomshaper.com>
 * Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined('_JEXEC') or die();

/**
 * Helix Ultimate social media information.
 *
 * @since	1.0.0
 */
class HelixUltimateFeatureSocial
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
		$this->position = $this->params->get('social_pos', 'toolbar-right');
	}

	/**
	 * Render the social media features
	 *
	 * @return	string
	 * @since	1.0.0
	 */
	public function renderFeature()
	{
		$link_target = $this->params->get('social_icons_link') ? ' target="_blank"' : '';
		$link_button = $this->params->get('social_icons_button') ? 'uk-icon-button' : 'uk-icon-link';
		$social_icons_gap = '' !== $this->params->get('social_icons_gap') ? ' uk-grid-'.$this->params->get('social_icons_gap') : '';
		$socials = array(
			'facebook-f' 	=> $this->params->get('facebook'),
			'twitter' 	=> $this->params->get('twitter'),
			'tiktok' => $this->params->get('tiktok'),
			'twitch' => $this->params->get('twitch'),
			'discord' 	=> $this->params->get('discord'),
			'youtube' 	=> $this->params->get('youtube'),
			'linkedin' 	=> $this->params->get('linkedin'),
			'dribbble' 	=> $this->params->get('dribbble'),
			'instagram' => $this->params->get('instagram'),
			'behance' 	=> $this->params->get('behance'),
			'skype' 	=> $this->params->get('skype'),
			'whatsapp' 	=> $this->params->get('whatsapp'),
			'telegram' 	=> $this->params->get('telegram'),
			'vk' 		=> $this->params->get('vk'),
			'custom' 	=> $this->params->get('custom'),
		);
		$iconPrefix = 'fab';
		$hasAnySocialLink = array_reduce($socials,
			function ($acc, $curr) {
				return $acc || !empty($curr);
			},
			false
		);

		if ($this->params->get('social_pos') && $hasAnySocialLink)
		{
			$html  = '<ul class="tm-social uk-flex-inline uk-flex-middle uk-flex-nowrap'.$social_icons_gap.' uk-grid" uk-grid>';

			foreach ($socials as $name => $link)
			{
				/* Modify links and name if needed. */
				if (!empty($link))
				{
					$iconName = 'fa-' . $name;

					switch($name)
					{
						case 'skype':
							$link = 'skype:' . $link . '?chat';
						break;

						case 'whatsapp':
							$link = 'whatsapp://send?abid=' . $link . '&text=Hi';
						break;

						case 'custom':
							$array = explode(' ', preg_replace("@\s+@", ' ', trim($link)));

							if (!empty($array) && count($array) > 1)
							{
								$chunks = count($array);

								if ($chunks === 2)
								{
									list($iconName, $link) = $array;
								}
								elseif ($chunks === 3)
								{
									list($iconPrefix, $iconName, $link) = $array;
								}
							}							
						break;

						default:
							$link = $link;
						break;
					}
				}

				/** Generate link after modification.*/
				if (!empty($link))
				{
					$iconClass = $iconPrefix . ' ' . $iconName;
					$html .= '<li class="social-icon-' . $name . '"><a class="'.$link_button.'"'.$link_target.' rel="noopener noreferrer" href="' . $link . '" aria-label="' . ucfirst($name) . '"><span class="' . $iconClass . '" aria-hidden="true"></span></a></li>';
				}
			}

			$html .= '</ul>';

			return $html;
		}

	}
}
