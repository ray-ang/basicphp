<p>This is a sample URL route.</p>
<p>Variables can be used to render view after defining them in the controller file.</p>
<p>Templating is done using native PHP templating.</p>
<h4>Passing Data from Controller</h4>
<?php foreach($person as $name => $age): ?>
The name is <?= $name ?> and the age is <?= $age ?>.
<br>
<?php endforeach ?>
<h4>Using URL substring as parameter.</h4>
<?php if (! empty($param1)): ?>
<p>The first paramter is <?= $param1 ?>.</p>
<?php endif ?>
<?php if (! empty($param2)): ?>
<p>The second paramter is <?= $param2 ?>.</p>
<?php endif ?>
