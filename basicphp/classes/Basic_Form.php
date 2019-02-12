<?php

/**
 * Form Builder Plugin
 * This class plugin builds a submit form.
 * @package  Form Builder
 * @author   Raymund John Ang <raymund@open-nis.org>
 * @license  MIT License
 */

class Basic_Form

{

	public function open( $class='form-horizontal', $method='post' )

	{

		?><form class="<?= $class ?>" action="" method="<?= $method ?>"><?php

	}

	public function text( $name, $label, $value = null )

	{

		?><div class="form-group">
			<label class="control-label col-sm-2" for="<?= $name ?>"><?= $label ?>:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="<?= $name ?>" placeholder="Enter <?= $label ?>" name="<?= $name ?>" value="<?= esc($value) ?>">
			</div>
		</div><?php

	}


	public function textArea( $name, $label, $value = null )

	{

		?><div class="form-group">
			<label class="control-label col-sm-2" for="<?= $name ?>"><?= $label ?>:</label>
			<div class="col-sm-10"> 
				<textarea class="form-control" rows="5" id="<?= $name ?>" placeholder="Enter <?= $label ?>" name="<?= $name ?>"><?= esc($value) ?></textarea>
			</div>
		</div><?php

	}

	public function button( $class, $name, $label = null )

	{

		?><div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="<?= $class ?>" name="<?= $name ?>"><?= $label ?></button>
			</div>
		</div><?php

	}

	public function csrfToken()

	{

		?><input type="hidden" name="csrf-token" value="<?= csrf_token() ?>"><?php

	}

	public function close()

	{

		?></form><?php

	}

}