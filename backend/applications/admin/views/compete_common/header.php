<header>
    <a href="<?php base_url() ?>" class="logo">
        <img src="/Admin-Dashboard-Logo.png" alt="Logo"/>
    </a>

    <div class="user-profile">
        <a data-toggle="dropdown" class="dropdown-toggle">
            <img src="<?php echo AssetHelper::imageUrl('profile1.png') ?>" alt="Profile-Image">
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu pull-right">
            <li>
                <a href="<?php echo site_url('admin/profile') ?>">Edit Profile</a>
            </li>
            <li>
                <a href="#">Account Settings</a>
            </li>
            <li>
                <a href="<?php echo site_url('auth/process_logout')?>">Logout</a>
            </li>
        </ul>
    </div>
    <ul class="mini-nav">
        <li>
            <a href="#">
                <div class="fs1" aria-hidden="true" data-icon=""></div>
            </a>
        </li>
        <li>
            <a href="#">
                <div class="fs1" aria-hidden="true" data-icon="&#xe040;"></div>
            <span class="info-label">3</span>
            </a>
        </li>
    </ul>
</header>