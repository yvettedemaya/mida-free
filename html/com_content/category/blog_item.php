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
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

// Create a shortcut for params.
$params = $this->item->params;
$attribs = json_decode($this->item->attribs);
HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);
$article_format = (isset($attribs->helix_ultimate_article_format) && $attribs->helix_ultimate_article_format) ? $attribs->helix_ultimate_article_format : 'standard';

$template = HelixUltimate\Framework\Platform\Helper::loadTemplateData();
$tmpl_params = $template->params;

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (Associations::isEnabled() && $params->get('show_associations'));

$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
$isUnpublished = JVERSION < 4 ? ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate()) || ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate())) : ($this->item->state == Joomla\Component\Content\Administrator\Extension\ContentComponent::CONDITION_UNPUBLISHED || $this->item->publish_up > $currentDate)
	|| ($this->item->publish_down < $currentDate && $this->item->publish_down !== null);

$content_center = $tmpl_params->get('blog_center_content');

$content_margin = $tmpl_params->get('leading_blog_list_content_margin', 'default');
$content_margin_cls = $content_margin == 'default' ? 'uk-margin-top' : 'uk-margin-'.$content_margin.'-top';
$content_margin_cls .= $content_center ? ' uk-text-center' : '';

$content_length = $tmpl_params->get('content_length');

$image_margin = $tmpl_params->get('image_margin', 'default');
$image_margin_cls = $image_margin == 'default' ? ' uk-margin-top' : ' uk-margin-'.$image_margin.'-top';
$blog_tag_cls = $content_center ? ' class="uk-text-center"' : '';

?>

	<?php if ($params->get('float_intro') == 'none') : ?>
		<div class="uk-text-center">
		<?php if($article_format == 'gallery') : ?>
			<?php echo LayoutHelper::render('joomla.content.blog.gallery', array('attribs' => $attribs, 'id'=>$this->item->id)); ?>
		<?php elseif($article_format == 'video') : ?>
			<?php echo LayoutHelper::render('joomla.content.blog.video', array('attribs' => $attribs)); ?>
		<?php elseif($article_format == 'audio') : ?>
			<?php echo LayoutHelper::render('joomla.content.blog.audio', array('attribs' => $attribs)); ?>
		<?php else: ?>
			<?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
		<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if ($isUnpublished) : ?>
		<div class="system-unpublished">
	<?php endif; ?>

	<?php // Todo Not that elegant would be nice to group the params ?>
	<?php if ($info == 0) : ?>
		<?php echo LayoutHelper::render('joomla.content.meta_block', $this->item); ?>
	<?php endif; ?>

	<?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>

	<?php if ($info != 0) : ?>
		<?php echo LayoutHelper::render('joomla.content.meta_block', $this->item); ?>
	<?php endif; ?>

	<?php if ($params->get('float_intro') != 'none') : ?>
		<div class="uk-text-center<?php echo $image_margin_cls; ?>">
		<?php if($article_format == 'gallery') : ?>
			<?php echo LayoutHelper::render('joomla.content.blog.gallery', array('attribs' => $attribs, 'id'=>$this->item->id)); ?>
		<?php elseif($article_format == 'video') : ?>
			<?php echo LayoutHelper::render('joomla.content.blog.video', array('attribs' => $attribs)); ?>
		<?php elseif($article_format == 'audio') : ?>
			<?php echo LayoutHelper::render('joomla.content.blog.audio', array('attribs' => $attribs)); ?>
		<?php else: ?>
			<?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
		<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if (!$params->get('show_intro')) : ?>
		<?php // Content is generated by content plugin event "onContentAfterTitle" ?>
		<?php echo $this->item->event->afterDisplayTitle; ?>
	<?php endif; ?>

	<?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
	<?php echo $this->item->event->beforeDisplayContent; ?>

	<div class="<?php echo $content_margin_cls; ?>" property="text">
	<?php if (is_numeric($content_length) && $content_length >= 0) : ?>
		<?php echo substr(strip_tags($this->item->introtext), 0, $content_length) . '...'; ?>
    <?php else : ?>
        <?php echo $this->item->introtext; ?>
    <?php endif ?> 
	</div>

	<?php if ($info == 0 && $params->get('show_tags', 1) && !$tmpl_params->get('show_list_tags',0) && !empty($this->item->tags->itemTags)) : ?>
		<p<?php echo $blog_tag_cls; ?>><?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?></p>
	<?php endif; ?>

	<?php if ($params->get('show_readmore') && $this->item->readmore) :
		if ($params->get('access-view')) :
			$link = Route::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
		else :
			$menu = Factory::getApplication()->getMenu();
			$active = $menu->getActive();
			$itemId = $active->id;
			$link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
			$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
		endif; ?>

		<?php echo LayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

	<?php endif; ?>

	<?php if ($params->get('show_create_date') || $params->get('show_modify_date') || $params->get('show_hits')) : ?>
		<ul class="uk-list">
			<?php if ($params->get('show_create_date')) : ?>
				<li>
					<time datetime="<?php echo HTMLHelper::_('date', $this->item->created, 'c'); ?>" itemprop="dateCreated">
						<?php echo Text::sprintf('TPL_META_DATE_CREATED', HTMLHelper::_('date', $this->item->modified, Text::_('DATE_FORMAT_LC3'))); ?>
					</time>
				</li>
			<?php endif ?>

			<?php if ($params->get('show_modify_date')) : ?>
				<li>
					<time datetime="<?php echo HTMLHelper::_('date', $this->item->modified, 'c'); ?>" itemprop="dateModified">
						<?php echo Text::sprintf('TPL_META_DATE_MODIFIED', HTMLHelper::_('date', $this->item->modified, Text::_('DATE_FORMAT_LC3'))); ?>
					</time>
				</li>
			<?php endif ?>

			<?php if ($params->get('show_hits')) : ?>
				<li>
					<meta content="UserPageVisits:<?php echo $this->item->hits; ?>" itemprop="interactionCount">
					<?php echo Text::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
				</li>
			<?php endif ?>
		</ul>
	<?php endif ?>

	<?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
		<ul class="uk-subnav">
			<?php if ($params->get('show_print_icon') && JVERSION < 4 ) : ?>
				<li><?php echo HTMLHelper::_('icon.print_popup', $this->item, $params); ?></li>
			<?php endif; ?>

			<?php if ($params->get('show_email_icon') && JVERSION < 4 ) : ?>
				<li><?php echo HTMLHelper::_('icon.email', $this->item, $params); ?></li>
			<?php endif; ?>

			<?php if ($canEdit) : ?>
				<li class="article-can-edit">
					<?php echo HTMLHelper::_('icon.edit', $this->item, $params); ?>
				</li>
			<?php endif; ?>
		</ul>
	<?php endif; ?>

	<?php if ($isUnpublished) : ?>
		</div>
	<?php endif; ?>

<?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
<?php echo $this->item->event->afterDisplayContent; ?>

