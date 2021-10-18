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
<div class="el-item uk-card uk-card-default uk-card-hover uk-link-toggle uk-display-block">

<div class="uk-card-media-top">
	<?php if ($params->get('img_intro_full') !== 'none' && !empty($item->imageSrc)) : ?>
		<a href="<?php echo $item->link; ?>">
			<img src="<?php echo $item->imageSrc; ?>" alt="<?php echo $item->imageAlt; ?>">
		</a>
	<?php endif; ?>
</div>

<div class="uk-card-body uk-margin-remove-first-child">

	<?php if ($params->get('item_title')) : ?>
		<?php $item_heading = $params->get('item_heading', 'h3'); ?>
		<<?php echo $item_heading; ?> class="el-title uk-h5 uk-margin-remove-bottom">
			<?php if ($item->link !== '' && $params->get('link_titles')) : ?>
				<a class="uk-link-heading" href="<?php echo $item->link; ?>">
					<?php echo $item->title; ?>
				</a>
			<?php else : ?>
				<?php echo $item->title; ?>
			<?php endif; ?>
		</<?php echo $item_heading; ?>>
	<?php endif; ?>

	<?php if (!$params->get('intro_only')) : ?>
		<?php echo $item->afterDisplayTitle; ?>
	<?php endif; ?>

	<?php echo $item->beforeDisplayContent; ?>

	<?php if ($params->get('show_introtext', 1)) : ?>
		<div class="el-content uk-panel uk-margin-top">
			<?php echo substr(strip_tags($item->introtext), 0, 100) . '...'; ?>
		</div>
	<?php endif; ?>

	<?php echo $item->afterDisplayContent; ?>

	<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) : ?>
		<?php echo '<p class="uk-margin-top"><a class="uk-button uk-button-primary" href="' . $item->link . '">' .Text::_('HELIX_ULTIMATE_READMORE_TEXT'). '</a></p>'; ?>
	<?php endif; ?>

	</div>
	
</div>