<table>
<?php $i = 0; ?>
<?php foreach($data as $row) : ?>
    <tr>
    <?php foreach($keys as $key) : ?>
        <?= $i ? '<td>' : '<th>' ?>
        <?= $row->$key ?>
    <?php endforeach; ?>
    </tr>
    <?php $i++; ?>  
<?php endforeach; ?>
</table>