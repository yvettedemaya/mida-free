<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<div class="newsflash-horiz<?php echo $params->get('moduleclass_sfx'); ?> uk-child-width-1-1 uk-grid-medium uk-grid-divider uk-grid-match" uk-grid>
	<?php for ($i = 0, $n = count($list); $i < $n; $i ++) : ?>
		<?php $item = $list[$i]; ?>
		<div>
			<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_item'); ?>
		</div>
	<?php endfor; ?>
</div>
