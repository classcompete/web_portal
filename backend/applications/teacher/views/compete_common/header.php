<?php $this->load->view(config_item('teacher_template') . '_common/analytics.php') ?>
<header>
    <a href="<?php base_url() ?>" class="logo">
        <img src="<?php echo site_url('assets/images/logo.png') ?>" alt="Logo"/>
    </a>

    <div class="user-profile">
        <a data-toggle="dropdown" class="dropdown-toggle">
            <img src="<?php  echo site_url('profile/display_teacher_image') ?>" alt="Profile image"/>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu pull-right">
            <li>
                <a href="<?php echo site_url('profile') ?>">Edit Profile</a>
            </li>
            <li>
                <a href="<?php echo site_url('auth/process_logout')?>">Logout</a>
            </li>
        </ul>
    </div>
</header>