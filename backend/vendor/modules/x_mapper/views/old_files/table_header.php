<colgroup>
    <?php for ($i = 1; $i <= count($headers); $i++): ?>
    <col class="con<?php echo ($i % 2) + 1 ?>"/>
    <?php endfor; ?>
    <col class="con<?php echo ($i % 2)?>"/>
</colgroup>

<thead>
<tr>
    <?php $i = 0; foreach ($headers as $name => $header): ?>
    <th class="head<?php echo ($i % 2) + 1 ?>">
        <?php echo $header->title ?>&nbsp;&nbsp;
        <?php if ($header->searchable === true): ?>
        <?php if ($header->search_type === 'text'): ?>
        <input type="text" class="smallinput" name="<?php echo $name?>" value="<?php echo urldecode(set_value($name))?>">
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
        <button class="radius3" type="submit"><?php echo lang('mapper.filter')?></button>
    </th>
</tr>
</thead>