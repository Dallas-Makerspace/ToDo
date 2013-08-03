<h2>Login</h2>
<?php echo $this->Form->create('User', array('action' => 'login', 'class' => 'login')); ?>
	<div class="form-group">
		<?php echo $this->Form->text('username', array('class' => 'form-control', 'placeholder' => 'Username')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->password('password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
	</div>
	<?php echo $this->Form->button(__('Login'), array('type'=>'submit','class'=>'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
