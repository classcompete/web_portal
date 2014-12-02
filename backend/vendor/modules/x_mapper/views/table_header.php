<colgroup>
    <?php for ($i = 1; $i <= count($headers); $i++): ?>
    <col class="con<?php echo ($i % 2) + 1 ?><?php echo ($i === 1) ? '' : ' hidden-phone' ?>"/>
    <?php endfor; ?>
    <col class="con<?php echo ($i % 2)?> hidden-phone"/>
</colgroup>

<thead>
<tr>
    <td colspan="100">
        <div style="float: right; margin-top: 7px;">
            <?php if (empty($order) === false): ?>
                Order by:&nbsp;&nbsp;
                <select name="order-2" style="margin-bottom: 0px;" onchange="$('select[name=order]').val($(this).val())">
                    <?php foreach ($order as $col => $title): ?>
                        <option value="<?php echo $col ?>+DESC" <?php echo set_select('order', $col . '+DESC')?>>
                            <?php echo $title?> <?php echo lang('mapper.order.desc')?>
                        </option>
                        <option value="<?php echo $col ?>+ASC" <?php echo set_select('order', $col . '+ASC')?>>
                            <?php echo $title?> <?php echo lang('mapper.order.asc')?>
                        </option>
                    <?php endforeach ?>
                </select>
            <?php endif ?>
        </div>
    </td>
</tr>
<tr role="row">
    <?php $i = 0; foreach ($headers as $name => $header): ?>
    <th class="head<?php echo ($i % 2) + 1 ?><?php echo ($i === 0) ? '' : ' hidden-phone' ?>">
        <?php if ($header->searchable === true): ?>
        <?php if ($header->search_type === 'text'): ?>
        <input type="text" class="smallinput smallinput_filter"
               name="<?php echo $name?>" value="<?php echo urldecode(set_value($name))?>"
               placeholder="Search by <?php echo $header->title ?>"
            style="margin-bottom: 0px; width: 95% !important;">
        <?php endif; ?>
        <?php if ($header->search_type === 'select'): ?>
            <select name="<?php echo $name?>">
                <option value="null">-----------</option>
                <?php foreach($header->options as $value => $title): ?>
                <option value="<?php echo $title?>" <?php echo set_select($name, $title)?>>
                    <?php echo $title?>
                </option>
                <?php endforeach ?>
            </select>
            <?php endif; ?>
        <?php endif; ?>
    </th>
    <?php $i++; endforeach ?>
    <th class="head<?php echo ($i % 2) ?>">
        <button class="radius3 btn btn-small" type="submit"><?php echo lang('mapper.filter')?></button>
    </th>
</tr>
<tr>
    <?php $first = true; foreach ($headers as $key => $header): ?>
    <th class="head<?php echo ($key % 2) + 1 ?><?php echo ($first === true) ? '' : ' hidden-phone' ?>">
        <?php echo $header->title ?>
    </th>
    <?php $first = false; endforeach; ?>
    <th class="head<?php echo ($key % 2) ?>">&nbsp;</th>
</tr>
</thead>