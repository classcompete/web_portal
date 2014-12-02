<?php switch ($type) {
    case Notificationlib::NOTIFICATION_TYPE_INFORMATION:
        $class_type = 'msginfo';
        break;
    case Notificationlib::NOTIFICATION_TYPE_SUCCESS:
        $class_type = 'msgsuccess';
        break;
    case Notificationlib::NOTIFICATION_TYPE_WARNING:
        $class_type = 'msgalert';
        break;
    case Notificationlib::NOTIFICATION_TYPE_FAILURE:
        $class_type = 'msgerror';
        break;
} ?>
<div class="notibar <?php echo $class_type?>">
    <a class="close"></a>

    <p><strong><?php echo strtoupper($type)?>: </strong><?php echo $text?></p>
</div>
<!-- notification msginfo -->