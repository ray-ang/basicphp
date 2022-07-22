<?php

/**
 * Form Builder
 * This class plugin builds a Bootstrap-based form.
 * 
 * @package  FormBuilder
 * @author   Raymund John Ang <raymund@open-nis.org>
 * @license  MIT License
 */

class BasicForm
{

	public function open($class = 'form-horizontal', $method = 'post')
	{
?>
		<form class="<?= $class ?>" action="" method="<?= $method ?>">
		<?php
	}

	public function input($type, $name, $label, $value = NULL, $required = FALSE)
	{
		?>
			<div class="form-group">
				<label class="control-label col-sm-2" for="<?= $name ?>"><?= $label ?>:</label>
				<div class="col-sm-10">
					<input type="<?= $type ?>" class="form-control" id="<?= $name ?>" placeholder="Enter <?= $label ?>" name="<?= $name ?>" value="<?= $value ?>" <?php if ($required === TRUE) echo 'required'; ?> />
				</div>
			</div>
		<?php
	}


	public function textArea($name, $label, $value = NULL, $required = FALSE)
	{
		?>
			<div class="form-group">
				<label class="control-label col-sm-2" for="<?= $name ?>"><?= $label ?>:</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="5" id="<?= $name ?>" placeholder="Enter <?= $label ?>" name="<?= $name ?>" <?php if ($required === TRUE) echo 'required'; ?>><?= $value ?></textarea>
				</div>
			</div>
		<?php
	}

	public function button($name, $label, $class = 'btn btn-default')
	{
		?>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="<?= $class ?>" name="<?= $name ?>"><?= $label ?></button>
				</div>
			</div>
		<?php
	}

	public function csrfToken()
	{
		?>
			<input type="hidden" name="csrf-token" value="<?= Basic::csrfToken() ?>">
		<?php
	}

	public function close()
	{
		?>
		</form>
<?php
	}
}
