<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagebreak
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;

?>

<?php if ($links['next']) :
	$title = htmlspecialchars($this->list[$page + 2]->title, ENT_QUOTES, 'UTF-8');
	$ariaLabel = Text::_('JNEXT') . ': ' . $title . ' (' . Text::sprintf('JLIB_HTML_PAGE_CURRENT_OF_TOTAL', ($page + 2), $n) . ')';
?>
<div class="uk-grid-small uk-flex-middle uk-text-default" uk-grid>
	<div>
		<a class="uk-button uk-button-secondary" href="<?= $links['next'] ?>" aria-label="<?= $ariaLabel ?>" rel="next"><?= Text::_('TPL_HU_NEXT_PAGE') ?></a>
	</div>

	<?php if ($this->list[$page + 2]->title != Text::sprintf('JLIB_HTML_PAGE_CURRENT', $page + 2)) : ?>
	<div>
		<?= $title ?>
	</div>
	<?php endif ?>

</div>
<?php endif ?>

<div class="uk-grid-small uk-flex-middle uk-child-width-auto uk-text-default uk-margin" uk-grid>
	<div>
		<?= Text::sprintf('JLIB_HTML_PAGE_CURRENT', '') ?>
	</div>
	<div>

		<ul class="uk-pagination">
			<?php foreach ($this->list as $index => $item) :
				$item->liClass = str_replace('active', 'uk-active', $item->liClass);
			?>
			<li class="<?= $item->liClass ?>">
				<?php if($index == $page + 1) : ?>
					<span class="<?= $item->class ?>"><?= ($index == count($this->list)) ? $item->title : $index ?></span>
				<?php else : ?>
					<a href="<?= $item->link ?>" class="<?= $item->class ?>"><?= (Text::sprintf('PLG_CONTENT_PAGEBREAK_ALL_PAGES') == $item->title) ? $item->title : $index ?></a>
				<?php endif ?>
			</li>
			<?php endforeach ?>
		</ul>

	</div>
</div>