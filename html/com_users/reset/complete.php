<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

?>
<div class="reset-complete<?php echo $this->pageclass_sfx; ?>">
	<div class="uk-grid uk-flex uk-flex-center" uk-grid>
		<div class="uk-width-large uk-background-muted uk-padding">
			<?php if ($this->params->get('show_page_heading')) : ?>
				<div class="page-header">
					<h1 class="el-title uk-h3 uk-margin-small-top uk-margin-remove-bottom">
						<?php echo $this->escape($this->params->get('page_heading')); ?>
					</h1>
				</div>
			<?php endif; ?>
			<form action="<?php echo Route::_('index.php?option=com_users&task=reset.complete'); ?>" method="post" class="form-validate">
				<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
					<fieldset class="uk-fieldset">
						<p><?php echo Text::_($fieldset->label); ?></p>
						<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
							<div class="margin">
								<?php echo $field->label; ?>
								<?php echo $field->input; ?>
							</div>
						<?php endforeach; ?>
					</fieldset>
				<?php endforeach; ?>
				<div class="uk-margin">
					<button type="submit" class="uk-button uk-button-primary validate">
						<?php echo Text::_('JSUBMIT'); ?>
					</button>
				</div>
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>