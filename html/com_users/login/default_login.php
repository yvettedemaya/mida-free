<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

$usersConfig = ComponentHelper::getParams('com_users');

?>
<div class="tm-form-login<?php echo $this->pageclass_sfx; ?>">
<div class="uk-grid uk-flex uk-flex-center" uk-grid>
		<div class="uk-width-large uk-background-muted uk-padding">
			<?php if ($this->params->get('show_page_heading')) : ?>
				<div class="page-header">
					<h1 class="el-title uk-h3 uk-margin-small-top uk-margin-remove-bottom">
						<?php echo $this->escape($this->params->get('page_heading')); ?>
					</h1>
				</div>
			<?php endif; ?>

			<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
				<div class="login-description">
				<?php endif; ?>

				<?php if ($this->params->get('logindescription_show') == 1) : ?>
					<?php echo $this->params->get('login_description'); ?>
				<?php endif; ?>

				<?php if ($this->params->get('login_image') != '') : ?>
					<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo Text::_('COM_USERS_LOGIN_IMAGE_ALT'); ?>">
				<?php endif; ?>

				<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
				</div>
			<?php endif; ?>

			<form action="<?php echo Route::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate">

				<?php foreach ($this->form->getFieldset('credentials') as $field) : ?>
					<?php if (!$field->hidden) : ?>
						<div class="uk-margin">
							<?php echo $field->label; ?>
							<?php echo $field->input; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>

				<?php if ($this->tfa) : ?>
					<div class="uk-margin">
						<?php echo $this->form->getField('secretkey')->label; ?>
						<?php echo $this->form->getField('secretkey')->input; ?>
					</div>
				<?php endif; ?>

				<?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
					<div class="uk-margin">
						<label class="uk-form-label">
							<input class="uk-checkbox" type="checkbox" name="remember" id="remember" value="yes">
							<?php echo Text::_('COM_USERS_LOGIN_REMEMBER_ME') ?>
						</label>
					</div>
				<?php endif; ?>

				<div class="uk-margin">
					<button type="submit" class="uk-button uk-button-primary uk-width-1-1">
						<?php echo Text::_('JLOGIN'); ?>
					</button>
				</div>

				<?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
				<input type="hidden" name="return" value="<?php echo base64_encode($return); ?>">
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>

			<div class="uk-width-medium uk-text-center uk-margin-auto uk-margin-small-top">
					<a class="uk-link-text uk-text-small" href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
						<?php echo Text::_('COM_USERS_LOGIN_RESET'); ?>
					</a>
					<a class="uk-link-text uk-text-small" href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
						<?php echo Text::_('COM_USERS_LOGIN_REMIND'); ?>
					</a>
					<?php if ($usersConfig->get('allowUserRegistration')) : ?>
						<a class="uk-link-text uk-text-small" href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>">
							<?php echo Text::_('COM_USERS_LOGIN_REGISTER'); ?>
						</a>
					<?php endif; ?>
			</div>
		</div>
	</div>
</div>
