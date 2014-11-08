<?php if (!defined('APPLICATION')) exit(); ?>

<?php $Form = $this->Data('Form'); ?>

<h1>
	<?= T('Advertisements'); ?>
</h1>

<div class="Info">
	<?= T('Add Advertisements to your forum'); ?>
</div>

<h3>
	<?= T('New Advertisement'); ?>
</h3>

<?= $Form->Open(); ?>
<?= $Form->Errors(); ?>

<div class="Homepage">
	<p>
		<strong>
			<?= T('Advertisement Network'); ?>
		</strong>
		<br />
		<?= T('Choose which network this advertisement should be for.'); ?>
	</p>

	<?= $Form->RadioList('Network', $this->Data('Networks'), array( 'list' => true )); ?>
</div>

<hr />

<br />

<?= $Form->Button(T('Create Advertisement'), array( 'class' => 'Button Submit' )); ?>

<?= $Form->Close(); ?>
