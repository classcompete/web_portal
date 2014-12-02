<tbody role="alert">
<?php foreach ($records as $rec): ?>
    <tr>
        <?php $first = true; foreach ($cols as $name => $col): ?>
            <td<?php echo ($first === true) ? '' : ' class="hidden-phone"' ?>>
                <?php echo $rec->$name ?>
            </td>
        <?php $first = false; endforeach; ?>
        <td>
            <div class="btn-group">
                <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown">
                    Action<span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right">
                    <?php foreach ($rec->options as $option): ?>
                        <li>
                            <a href="<?php echo $option->link ?>" class="<?php echo $option->name ?>"
                               title="<?php echo $option->title ?>"
                                <?php echo (empty($option->data_target) === false) ? ' data-target="' . $option->data_target . '"' : '' ?>
                                <?php echo (empty($option->data_toggle) === false) ? ' data-toggle="' . $option->data_toggle . '"' : '' ?>>
                                <?php echo $option->string?>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </td>
    </tr>
<?php endforeach ?>
</tbody>