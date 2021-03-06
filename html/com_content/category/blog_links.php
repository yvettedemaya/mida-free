<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

use Joomla\CMS\Router\Route;

?>

<ul class="uk-list">
	<?php foreach ($this->link_items as &$item) : ?>
		<li>
			<a href="<?php echo Route::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)); ?>">
				<?php echo $item->title; ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>

