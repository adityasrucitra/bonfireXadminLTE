<?php
	$site_open = $this->settings_lib->item('auth.allow_register');
?>
<div class="login-box">
	<div class="login-logo">
		<h2><?php echo lang('us_login'); ?></h2>
		<?php echo Template::message(); ?>
		<!-- <a href="../../index2.html"><b>Admin</b>LTE</a> -->
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session</p>

		<?php echo form_open(LOGIN_URL, array('autocomplete' => 'off')); ?>
		<div class="form-group has-feedback" <?php echo iif(form_error('login'), 'error'); ?>>
			<input type="text" name="login" id="login_value" value="<?php echo set_value('login'); ?>" class="form-control" placeholder="<?php echo $this->settings_lib->item('auth.login_type') == 'both' ? lang('bf_username') . '/' . lang('bf_email') : ucwords($this->settings_lib->item('auth.login_type')) ?>">
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback <?php echo iif(form_error('password'), 'error'); ?>">
			<input type="password" name="password" id="password" value="" class="form-control" placeholder="<?php echo lang('bf_password'); ?>">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="row">
			<?php if ($this->settings_lib->item('auth.allow_remember')) : ?>
				<div class="col-xs-8">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="remember_me" id="remember_me" value="1"> Remember Me
						</label>
					</div>
				</div>
			<?php endif; ?>	
			<!-- /.col -->
			<div class="col-xs-4">
				<button type="submit" type="submit" name="log-me-in" id="submit" value="<?php e(lang('us_let_me_in')); ?>" class="btn btn-primary btn-block btn-flat">Sign In</button>
			</div>
			<!-- /.col -->
		</div>
		</form>

		<!-- <a href="#">I forgot my password</a><br>
		<a href="register.html" class="text-center">Register a new membership</a> -->

		<?php // show for Email Activation (1) only
		if ($this->settings_lib->item('auth.user_activation_method') == 1) : ?>
			<!-- Activation Block -->
			<p style="text-align: left" class="well">
				<?php echo lang('bf_login_activate_title'); ?><br />
				<?php
				$activate_str = str_replace('[ACCOUNT_ACTIVATE_URL]', anchor('/activate', lang('bf_activate')), lang('bf_login_activate_email'));
				$activate_str = str_replace('[ACTIVATE_RESEND_URL]', anchor('/resend_activation', lang('bf_activate_resend')), $activate_str);
				echo $activate_str; ?>
			</p>
		<?php endif; ?>

		<p style="text-align: center">
			<?php if ($site_open) : ?>
				<?php echo anchor(REGISTER_URL, lang('us_sign_up')); ?>
			<?php endif; ?>

			<br /><?php echo anchor('/forgot_password', lang('us_forgot_your_password')); ?>
		</p>

	</div>
	<!-- /.login-box-body -->
</div>
<!-- /.login-box -->