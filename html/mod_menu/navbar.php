<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Registry\Registry;

$id = '';

if ($tagId = $params->get('tag_id', ''))
{
	$id = ' id="' . $tagId . '"';
}

// The menu class is deprecated. Use nav instead
?>

<ul class="<?php echo $class_sfx; ?>">

<?php foreach ($list as $i => &$item)
{
	$layout = \json_decode($item->getParams()->get('helixultimatemenulayout', ''));

	if (\json_last_error() !== JSON_ERROR_NONE)
	{
		$layout = '';
	}

	$helixMenuLayout = new Registry($layout);
	$customClass = $helixMenuLayout->get('customclass', '');

	$class = 'item-' . $item->id;

	if (in_array($item->id, $path))
	{
		$class .= ' uk-active';
	}
	elseif ($item->type === 'alias')
	{
		$aliasToId = $item->getParams()->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$class .= ' uk-active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$class .= ' alias-parent-active';
		}
	}
	
	if ($customClass)
	{
		$class .= ' ' . $customClass;
	}

	if ($item->type === 'separator' && ! $item->parent) {
			$class .= ' uk-nav-divider';
	}
	
	if ($item->type === 'heading' && ! $item->parent) {
		$class .= ' uk-nav-header';
	}

	if ($item->parent)
	{
		$class .= ' uk-parent';
	}

	echo '<li class="' . $class . '">';

	if ($item->parent && $item->type === 'separator') {
		echo '<a class="'.$item->anchor_css.'" tabindex="0">'.$item->title.'</a>';
	}

	switch ($item->type) :
		case 'heading':	
		case 'component':
		case 'url':
			require ModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
			break;

		case 'separator':
			break;

		default:
			require ModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper)
	{
        echo '<div class="uk-navbar-dropdown" uk-drop="clsDrop: uk-navbar-dropdown; flip:x; mode:hover; container: .tm-header;">';
        echo '<div class="uk-navbar-dropdown-grid uk-child-width-1-1 uk-grid" uk-grid>';
        echo '<div>';
		echo '<ul class="uk-nav uk-navbar-dropdown-nav">';
		
	}
	// The next item is shallower.
	elseif ($item->shallower)
	{
		echo '</li>';
		echo str_repeat('</ul></div></div></div></li>', $item->level_diff);
		
	}
	// The next item is on the same level.
	else
	{
		echo '</li>';
	}
}
?>
</ul>
