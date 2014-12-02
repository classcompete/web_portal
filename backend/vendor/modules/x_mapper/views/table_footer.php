<tfoot>
<tr>
    <?php $first = true; foreach ($headers as $key => $header): ?>
        <th class="head<?php echo ($key % 2) + 1 ?><?php echo ($first === true) ? '' : ' hidden-phone' ?>">
            <?php echo $header->title ?>
        </th>
    <?php $first = false; endforeach; ?>
    <th class="head<?php echo ($key % 2) ?>">&nbsp;</th>
</tr>
<tr>
    <th class="head0 hidden-phone" colspan="1000">
        <div style="float: left; margin-top: 7px;">
            <?php if (empty($order) === false): ?>
                <?php echo lang('mapper.order_by') ?>&nbsp;&nbsp;
                <select name="order" style="margin-bottom: 0px;">
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
            <button class="radius3 btn btn-small" type="submit"><?php echo lang('mapper.filter')?></button>
        </div>
        <div class="dataTables_paginate" style="border: 0; margin: 12px 0 0; padding: 0">

            <a class="first paginate_button"
               onclick="window.location='<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $paging->first) ?>'">
                <?php echo lang('mapper.page.first')?>
            </a>
            <a class="previous paginate_button"
               onclick="window.location='<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $paging->previous) ?>'">
                <?php echo lang('mapper.page.previous')?>
            </a>
            <a>
                <?php for ($i = 1; $i <= $paging->last; $i++): ?>
                    <?php if ($i === (int)$paging->current): ?>
                        <a class="paginate_active"><?php echo $i?></a>
                    <?php else: ?>
                        <?php if (($i <= 2) || (($paging->last - $i) < 2)): ?>
                        <a href="<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $i) ?>"
                           class="paginate_button"><?php echo $i?></a>
                        <?php elseif (($paging->current - $i <= 2) && ($paging->current - $i >= -2)): ?>
                            <?php if ($paging->current - $i === 2 && $i != 3): ?>
                            <a class="paginate_active" style="border: none">...</a>
                            <?php endif ?>
                            <a href="<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $i) ?>"
                               class="paginate_button"><?php echo $i?></a>
                            <?php if (($paging->current - $i === -2) && ($paging->last - $i != 2)): ?>
                            <a class="paginate_active" style="border: none">...</a>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endif ?>
                <?php endfor ?>
            </a>
            <a class="next paginate_button"
               onclick="window.location='<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $paging->next) ?>'">
                <?php echo lang('mapper.page.next')?>
            </a>
            <a class="last paginate_button"
               onclick="window.location='<?php echo site_url($paging->base . '/' . Mapper_Helper::create_uri_segments() . '/page/' . $paging->last) ?>'">
                <?php echo lang('mapper.page.last')?>
            </a>
        </div>
    </th>
</tr>
</tfoot>