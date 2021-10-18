<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');


// Load user_profile plugin language
$lang = Factory::getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);

?>
<div class="profile-edit tm-form-profile-edit<?php echo $this->pageclass_sfx; ?>">
	<div class="uk-grid uk-flex uk-flex-center">
		<div class="uk-width-xxlarge uk-background-muted uk-padding">
			<?php if ($this->params->get('show_page_heading')) : ?>
				<div class="page-header">
					<h1 class="el-title uk-h2 uk-margin-remove-bottom"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
				</div>
			<?php endif; ?>
 
			<script type="text/javascript">
			Joomla.twoFactorMethodChange = function(e)
			{
				var selectedPane = 'com_users_twofactor_' + jQuery('#jform_twofactor_method').val();

				jQuery.each(jQuery('#com_users_twofactor_forms_container>div'), function(i, el) {
					if (el.id != selectedPane)
					{
						jQuery('#' + el.id).hide(0);
					}
					else
					{
						jQuery('#' + el.id).show(0);
					}
				});
			}
			</script>

			<form id="member-profile" action="<?php echo Route::_('index.php?option=com_users&task=profile.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
				<?php // Iterate through the form fieldsets and display each one. ?>
				<?php foreach ($this->form->getFieldsets() as $group => $fieldset) : ?>
					<?php $fields = $this->form->getFieldset($group); ?>
					<?php if (count($fields)) : ?>
						<fieldset class="uk-fieldset">
							<?php if (isset($fieldset->label)) : ?>
								<legend class="uk-legend">
									<h3 class="el-title uk-h4 uk-margin-small-top uk-margin-remove-bottom"><?php echo Text::_($fieldset->label); ?></h3>
								</legend>
							<?php endif; ?>
							<?php if (isset($fieldset->description) && trim($fieldset->description)) : ?>
								<?php echo '<p>' . $this->escape(Text::_($fieldset->description)) . '</p>'; ?>
							<?php endif; ?>
							<?php // Iterate through the fields in the set and display them. ?>
							<div class="uk-grid-small" uk-grid>
								<?php foreach ($fields as $field) : ?>
									<?php // If the field is hidden, just display the input. ?>
									<?php if ($field->hidden) : ?>
										<?php echo $field->input; ?>
									<?php else : ?>
										<?php if(($field->fieldname == 'name') || ($field->fieldname == 'username')) : ?>
											<div class="uk-width-1-1@m">
											<?php else: ?>
												<div class="uk-width-1-2@m">
												<?php endif; ?>
												<div class="form-group">
													<?php echo $field->label; ?>
													<?php if ($field->fieldname === 'password1') : ?>
														<input type="password" style="display:none">
													<?php endif; ?>
													<?php echo $field->input; ?>
												</div>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</fieldset>
						<?php endif; ?>
					<?php endforeach; ?>

					<?php if (count($this->twofactormethods) > 1) : ?>
						<fieldset class="uk-fieldset">
							<legend class="uk-legend"><?php echo Text::_('COM_USERS_PROFILE_TWO_FACTOR_AUTH'); ?></legend>

							<div class="form-group">
								<label id="jform_twofactor_method-lbl" for="jform_twofactor_method" class="hasTooltip"
								title="<?php echo '<strong>' . Text::_('COM_USERS_PROFILE_TWOFACTOR_LABEL') . '</strong><br>' . Text::_('COM_USERS_PROFILE_TWOFACTOR_DESC'); ?>">
								<?php echo Text::_('COM_USERS_PROFILE_TWOFACTOR_LABEL'); ?>
							</label>
							<?php echo HTMLHelper::_('select.genericlist', $this->twofactormethods, 'jform[twofactor][method]', array('onchange' => 'Joomla.twoFactorMethodChange()'), 'value', 'text', $this->otpConfig->method, 'jform_twofactor_method', false); ?>
						</div>
						<div id="com_users_twofactor_forms_container">
							<?php foreach ($this->twofactorform as $form) : ?>
								<?php $style = $form['method'] == $this->otpConfig->method ? 'display: block' : 'display: none'; ?>
								<div id="com_users_twofactor_<?php echo $form['method']; ?>" style="<?php echo $style; ?>">
									<?php echo $form['form']; ?>
								</div>
							<?php endforeach; ?>
						</div>
					</fieldset>

					<fieldset class="uk-fieldset">
						<legend class="uk-legend">
							<?php echo Text::_('COM_USERS_PROFILE_OTEPS'); ?>
						</legend>
						<div class="uk-alert uk-alert-primary">
							<?php echo Text::_('COM_USERS_PROFILE_OTEPS_DESC'); ?>
						</div>
						<?php if (empty($this->otpConfig->otep)) : ?>
							<div class="uk-alert uk-alert-warning">
								<?php echo Text::_('COM_USERS_PROFILE_OTEPS_WAIT_DESC'); ?>
							</div>
						<?php else : ?>
							<?php foreach ($this->otpConfig->otep as $otep) : ?>
								<span class="col-md-3">
									<?php echo substr($otep, 0, 4); ?>-<?php echo substr($otep, 4, 4); ?>-<?php echo substr($otep, 8, 4); ?>-<?php echo substr($otep, 12, 4); ?>
								</span>
							<?php endforeach; ?>
							<div class="clearfix"></div>
						<?php endif; ?>
					</fieldset>
				<?php endif; ?>

				<div class="form-group">
					<button type="submit" class="uk-button uk-button-primary validate"><span><?php echo Text::_('JSUBMIT'); ?></span></button>
					<a class="uk-button uk-button-secondary" href="<?php echo Route::_('index.php?option=com_users&view=profile'); ?>" title="<?php echo Text::_('JCANCEL'); ?>"><?php echo Text::_('JCANCEL'); ?></a>
					<input type="hidden" name="option" value="com_users">
					<input type="hidden" name="task" value="profile.save">
				</div>
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
