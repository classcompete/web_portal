<tbody>
<?php foreach ($records as $rec): ?>
<tr>
    <?php foreach ($cols as $name => $col): ?>
    <td>
        <?php echo $rec->$name ?>
    </td>
    <?php endforeach ?>
    <td>
        <?php foreach ($rec->options as $option): ?>
        <a href="<?php echo $option->link?>" class="<?php echo $option->name?>" title="<?php echo $option->title?>"><?php echo $option->string?></a>
        <?php endforeach ?>
    </td>
</tr>
    <?php endforeach ?>
</tbody>