<!DOCTYPE html>
	<head>
		<?php if(isset($title_for_layout)): ?>
		<title>Dallas Makerspace ToDo: <?php echo $title_for_layout; ?></title>
		<?php else: ?>
		<title>Dallas Makerspace ToDo</title>
		<?php endif; ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
	echo $this->Html->css('bootstrap.min') . "\n";
	echo $this->Html->css('main') . "\n";
?>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php echo $this->Html->link('Things ToDo', array('controller' => 'things', 'action' => 'index'), array('class' => 'navbar-brand')); ?>
				<div class="nav-collapse collapse">
					<ul class="nav navbar-nav">
						<li<?php if($this->name == 'Tags') { echo ' class="active"'; } ?>><?php echo $this->Html->link('Tags', array('controller' => 'tags', 'action' => 'index')); ?></li>
						<li<?php if($this->name == 'Things' && $this->action == 'add') { echo ' class="active"'; } ?>><?php echo $this->Html->link('Create', array('controller' => 'things', 'action' => 'add')); ?></li>
						<li<?php if($this->name == 'Pages' && strtolower($page) == 'help') { echo ' class="active"'; } ?>><?php echo $this->Html->link('Help', array('controller' => 'pages', 'action' => 'help')); ?></li>
<?php if(!isset($user)): ?>
						<li class="visible-sm"><?php echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login')); ?></li>
<?php endif; ?>
					</ul>
<?php if(isset($user)): ?>
					<ul class="nav navbar-nav pull-right">
						<li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?></li>		
					</ul>
<?php else: ?>
<?php
	echo $this->Form->create('User', array('action' => 'login', 'class' => 'navbar-form pull-right hidden-sm'));
	echo $this->Form->text('username', array('class' => 'form-control', 'placeholder' => 'Username')) . ' ';
	echo $this->Form->password('password', array('class' => 'form-control', 'placeholder' => 'Password')) . ' ';
	echo $this->Form->button(__('Login'), array('type'=>'submit','class'=>'btn btn-mini'));
	echo $this->Form->end();
?>
<?php endif; ?>
				</div><!--/.nav-collapse -->
			</div>
		</div>

		<div class="container">

<?php echo $this->Session->flash(); ?>
<?php echo $content_for_layout; ?>

			<hr>

			<footer>
				<p><a href="https://github.com/Dallas-Makerspace/ToDo">Source code on GitHub</a> | Content is available under <a href="http://creativecommons.org/licenses/by-sa/3.0/" class="external ">Attribution-Share Alike 3.0 Unported</a></p>
			</footer>

		</div> <!-- /container -->

<?php
	echo $this->Html->script('jquery-1.10.2.min') . "\n";
	echo $this->Html->script('bootstrap.min') . "\n";
	echo $this->Js->writeBuffer(); // Write cached scripts
?>
	</body>
</html>
