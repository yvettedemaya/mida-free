<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>

<?php if ($params->get('item_title')) : ?>
		
	<?php if ($item->link !== '' && $params->get('link_titles')) : ?>
		<a class="uk-accordion-title" href="#">
			<?php echo $item->title; ?>
		</a>
	<?php else : ?>
		<a class="uk-accordion-title" href="#">
			<?php echo $item->title; ?>
		</a>
	<?php endif; ?>
		
<?php endif; ?>
    
<div class="uk-accordion-content">

    <?php if ($params->get('img_intro_full') !== 'none' && !empty($item->imageSrc)) : ?>
		<a href="<?php echo $item->link; ?>">
			<img src="<?php echo $item->imageSrc; ?>" alt="<?php echo $item->imageAlt; ?>">
		</a>
	<?php endif; ?>

	<?php if (!$params->get('intro_only')) : ?>
		<?php echo $item->afterDisplayTitle; ?>
	<?php endif; ?>

	<?php echo $item->beforeDisplayContent; ?>

	<?php if ($params->get('show_introtext', 1)) : ?>
		<div class="el-content uk-panel uk-margin-top">
			<?php echo strip_tags($item->introtext); ?>
		</div>
	<?php endif; ?>

	<?php echo $item->afterDisplayContent; ?>

	<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) : ?>
		<?php echo '<p class="uk-margin"><a class="uk-button uk-button-text" href="' . $item->link . '">' .Text::_('HELIX_ULTIMATE_READMORE_TEXT'). '</a></p>'; ?>
	<?php endif; ?>

</div>