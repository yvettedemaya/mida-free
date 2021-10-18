<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

// HTMLHelper::_('behavior.caption');

$app = Factory::getApplication();

$this->category->text = $this->category->description;
$app->triggerEvent('onContentPrepare', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$this->category->description = $this->category->text;

$results = $app->triggerEvent('onContentAfterTitle', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentBeforeDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentAfterDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayContent = trim(implode("\n", $results));

$template = HelixUltimate\Framework\Platform\Helper::loadTemplateData();
$tmpl_params = $template->params;

$blog_divider = $tmpl_params->get('blog_divider') && $tmpl_params->get('blog_list_grid_column_gap') != 'collapse' && $tmpl_params->get('blog_list_grid_row_gap') != 'collapse' ? ' uk-grid-divider' : '';
$center_columns = $tmpl_params->get('center_columns') ? ' uk-flex-center' : '';
$center_rows = $tmpl_params->get('center_rows') ? ' uk-flex-middle' : '';

$grid = '';
$grid .= $center_columns . $center_rows . $blog_divider;

$grid_column_gap = $tmpl_params->get('blog_list_grid_column_gap', '');
$grid_row_gap    = $tmpl_params->get('blog_list_grid_row_gap', '');

if ( $grid_column_gap == $grid_row_gap ) {
	$grid .= ( ! empty( $grid_column_gap ) && ! empty( $grid_row_gap ) ) ? ' uk-grid-' . $grid_column_gap : '';
} else {
	$grid .= ! empty( $grid_column_gap ) ? ' uk-grid-column-' . $grid_column_gap : '';
	$grid .= ! empty( $grid_row_gap ) ? ' uk-grid-row-' . $grid_row_gap : '';
}

$blog_list_breakpoint = $tmpl_params->get('blog_list_breakpoint', 'm');

$blog_masonry = $tmpl_params->get('blog_masonry') ? 'masonry: true;' : '';
$blog_parallax = $tmpl_params->get('blog_parallax', '');
$blog_parallax_cls = $blog_parallax ? ' parallax: '.$blog_parallax : '';

$init_style = '';
if($blog_masonry && $blog_parallax) {
	$init_style .= ' style="box-sizing:initial;"';
}

$grid_row = $tmpl_params->get('blog_list_grid_row_gap') ? ' uk-grid-'.$tmpl_params->get('blog_list_grid_row_gap') : '';

?>

<div class="blog<?php echo $this->pageclass_sfx; ?>" uk-height-viewport="expand: true">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		</div>
	<?php endif; ?>

	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
		<h2>
			<?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
				<span class="subheading-category"><?php echo $this->category->title; ?></span>
			<?php endif; ?>
		</h2>
	<?php endif; ?>
	<?php echo $afterDisplayTitle; ?>

	<?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
		<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
	<?php endif; ?>

	<?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<div class="category-desc clearfix">
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
				<img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>">
			<?php endif; ?>
			<?php echo $beforeDisplayContent; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
			<?php endif; ?>
			<?php echo $afterDisplayContent; ?>
		</div>
	<?php endif; ?>

	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php
	$introcount = count($this->intro_items);
	$counter = 0;
	?>

	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
		<div class="uk-child-width-1-1<?php echo $grid_row; ?>" uk-grid>
		<?php foreach ($this->lead_items as &$item) : ?>
		<div>
			<div id="leading-<?php echo $leadingcount; ?>" class="uk-article<?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
				itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
				<?php
				$this->item = &$item;
				echo $this->loadTemplate('item');
				?>
			</div>
		</div>
		<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($this->intro_items)) : ?>
		<?php if($this->params->get('num_columns') > 1) : ?>
			<div class="uk-child-width-1-<?php echo (int) $this->params->get('num_columns'); ?>@<?php echo $blog_list_breakpoint; echo $grid; ?>" uk-grid="<?php echo $blog_masonry . $blog_parallax_cls; ?>"<?php echo $init_style; ?>>
		<?php else: ?>
			<div class="uk-child-width-1-1<?php echo $grid_row; ?>" uk-grid>
		<?php endif; ?>

			<?php foreach ($this->intro_items as $key => &$item) : ?>
				<div>
				<div id="article-<?php echo $item->id; ?>" class="uk-article<?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
					<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
					?>
				</div>
				</div>
				<?php $counter++; ?>

			<?php endforeach; ?>
			</div>
	<?php endif; ?>

	<?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
			<div class="cat-children">
				<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
					<h3> <?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
				<?php endif; ?>
				<?php echo $this->loadTemplate('children'); ?> </div>
	<?php endif; ?>

	<?php if (!empty($this->link_items)) : ?>
		<div class="uk-margin-large<?php $tmpl_params->get('detail_center_content') ? ' uk-text-center' : '' ?>">
			<h3><?= Text::_('COM_CONTENT_MORE_ARTICLES') ?></h3>
			<?php echo $this->loadTemplate('links'); ?>
		</div>
	<?php endif; ?>

	<?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>

			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="uk-text-center uk-margin-top">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif; ?>
				<?php echo $this->pagination->getPagesLinks(); ?>

	<?php endif; ?>

</div>