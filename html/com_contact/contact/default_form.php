<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

?>
<div class="contact-form">
	<form id="contact-form" action="<?php echo Route::_('index.php'); ?>" method="post" class="form-validate uk-form">
	
		<div class="uk-grid-small" uk-grid>
			<div class="uk-width-1-2@s contact-name">
			<?php echo $this->form->getLabel('contact_name'); ?>
			<?php echo $this->form->getInput('contact_name'); ?>
			</div>
			<div class="uk-width-1-2@s contact-email">
			<?php echo $this->form->getLabel('contact_email'); ?>
			<?php echo $this->form->getInput('contact_email'); ?>
			</div>

			<div class="uk-width-1-1@s contact_subject">
			<?php echo $this->form->getLabel('contact_subject'); ?>
			<?php echo $this->form->getInput('contact_subject'); ?>
			</div>

			<div class="uk-width-1-1@s contact_message uk-margin">
			<?php echo $this->form->getLabel('contact_message'); ?>
			<?php echo $this->form->getInput('contact_message'); ?>
			</div>

		</div>

		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
			<?php if ($fieldset->name != 'contact'):?>
			<?php if ($fieldset->name === 'captcha' && !$this->captchaEnabled) : ?>
				<?php continue; ?>
			<?php endif; ?>
			<?php $fields = $this->form->getFieldset($fieldset->name); ?>
			<?php if (count($fields)) : ?>
				<fieldset class="uk-fieldset">
					<?php if (isset($fieldset->label) && ($legend = trim(Text::_($fieldset->label))) !== '') : ?>
						<legend class="uk-legend"><?php echo $legend; ?></legend>
					<?php endif; ?>
					<?php foreach ($fields as $field) : ?>
						<?php echo $field->renderField(); ?>
					<?php endforeach; ?>
				</fieldset>
			<?php endif; ?>
			<?php endif ?>
		<?php endforeach; ?>

		<div class="uk-form-controls">
			<div class="uk-grid-small" uk-grid>
			<?php if ($this->params->get('show_email_copy')) { ?>
				<div class="uk-width-1-1@s contact_email_copy">
							<div class="tm-checkbox">
								<?php echo $this->form->getInput('contact_email_copy'); ?>
								<?php echo $this->form->getLabel('contact_email_copy'); ?>
							</div>
						</div>
				<?php } ?>
				<div class="uk-width-1-1@s contact_button">
				<button class="uk-button uk-button-primary" type="submit"><?php echo Text::_('COM_CONTACT_CONTACT_SEND'); ?></button>
				</div>
				<input type="hidden" name="option" value="com_contact" />
				<input type="hidden" name="task" value="contact.submit" />
				<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
				<?php if(JVERSION >= 4) { ?>
					<input type="hidden" name="id" value="<?php echo $this->item->slug; ?>">
				<?php } else { ?>
					<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>">
				<?php } ?>
				<?php echo HTMLHelper::_('form.token'); ?>	
			</div>
		</div>
	</form>
</div>
