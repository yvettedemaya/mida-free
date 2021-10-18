<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

?>

<div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-expand@m uk-grid-small uk-grid-match" uk-grid>
	<?php for ($i = 0, $n = count($list); $i < $n; $i ++) : ?>
		<?php $item = $list[$i]; ?>
		<div>
			<?php require ModuleHelper::getLayoutPath('mod_articles_news', '_item_secondary'); ?>
		</div>
	<?php endfor; ?>
</div>
 