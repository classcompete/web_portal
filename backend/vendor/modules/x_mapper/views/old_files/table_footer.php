<tfoot>
<tr>
    <?php foreach ($headers as $key => $header): ?>
    <th class="head<?php echo ($key % 2) + 1 ?>">
        <?php echo $header->title ?>
    </th>
    <?php endforeach ?>
    <th class="head<?php echo ($key % 2) ?>">&nbsp;</th>
</tr>
<tr>
    <th class="head0" colspan="1000">
        <div class="dataTables_paginate" style="border: 0; margin: 0; padding: 0">
            <div style="float: left; margin-top: 7px;">
                <?php if (empty($order) === false): ?>
                <?php echo lang('mapper.order_by') ?>&nbsp;&nbsp;
                <select name="order">
                    <?php foreach ($order as $col => $title): ?>
                    <option value="<?php echo $col?>+DESC" <?php echo set_select('order', $col . '+DESC')?>>
                        <?php echo $title?> <?php echo lang('mapper.order.desc')?>
                    </option>
                    <option value="<?php echo $col?>+ASC" <?php echo set_select('order', $col . '+ASC')?>>
                        <?php echo $title?> <?php echo lang('mapper.order.asc')?>
                    </option>
                    <?php endforeach ?>
                </select>
                <?php endif ?>
                <button class="radius3" type="submit"><?php echo lang('mapper.filter')?></button>
            </div>
            <span class="first paginate_button"
                  onclick="window.location='<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $paging->first)?>'">
                        <?php echo lang('mapper.page.first')?>
                  </span>
            <span class="previous paginate_button"
                  onclick="window.location='<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $paging->previous)?>'">
                    <?php echo lang('mapper.page.previous')?>
                  </span>
            <span>
                <?php for ($i = 1; $i <= $paging->last; $i++): ?>
                <?php if ($i === (int)$paging->current): ?>
                    <span class="paginate_active"><?php echo $i?></span>
                    <?php else: ?>
                    <a href="<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $i)?>"
                       class="paginate_button"><?php echo $i?></a>
                    <?php endif ?>
                <?php endfor ?>
            </span>
            <span class="next paginate_button"
                  onclick="window.location='<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $paging->next)?>'">
                    <?php echo lang('mapper.page.next')?>
                  </span>
            <span class="last paginate_button"
                  onclick="window.location='<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $paging->last)?>'">
                    <?php echo lang('mapper.page.last')?>
                  </span>
        </div>
    </th>
</tr>
</tfoot>