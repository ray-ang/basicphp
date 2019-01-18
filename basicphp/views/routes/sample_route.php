<p>This is a sample URL route.</p>
<p>Variables can be used after defining them in the controller file.</p>
<p>Templating is done using native PHP templating.</p>
<?php if (! empty($param1)): ?>
<p>The first paramter is <?= $param1 ?>.</p>
<?php endif ?>
<?php if (! empty($param2)): ?>
<p>The second paramter is <?= $param2 ?>.</p>
<?php endif ?>