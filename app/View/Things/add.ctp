<h2>Create A Task <small>then do it?</small></h2>
<?php echo $this->Form->create('Thing');?>
	<fieldset>
		<div class="form-group<?php if($this->Form->isFieldError('title')) { echo ' has-warning'; } ?>">
			<?php echo $this->Form->label('title', 'Title', array('class' => 'control-label')); ?>
			<?php echo $this->Form->text('title', array('class' => 'form-control')); ?>
		</div>
		<div class="form-group<?php if($this->Form->isFieldError('description')) { echo ' has-warning'; } ?>">
			<?php echo $this->Form->label('description', 'Description', array('class' => 'control-label')); ?>
			<?php echo $this->Form->textarea('description', array('class' => 'form-control')); ?>
		</div>
		<div class="form-group">
			<legend>Tags</legend>
			<div class="checkbox-buttons" data-toggle="buttons">
				<!-- TODO: Make the buttons the same colors as their tags -->
				<?php echo $this->Form->select('Tag', $tags, array('multiple' => 'checkbox', 'class' => 'btn btn-temp')); ?>
			</div>
		</div>
		<?php echo $this->Form->button('Save', array('type'=>'submit','class'=>'btn btn-primary')); ?>
		<?php echo $this->Html->link('Cancel', array('controller' => 'things', 'action' => 'index'), array('class' => 'btn btn-link')); ?>
	</fieldset>
<?php echo $this->Form->end(); ?>
