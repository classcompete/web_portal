<div class="top-nav">
    <ul>
        <li>
            <a href="<?php echo base_url('home') ?>" <?php echo ($this->uri->segment(1) === 'home' ||
                $this->uri->segment(1) === false) ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></div>
                Home
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('classes') ?>" <?php echo ($this->uri->segment(1) === 'classes' ||
                $this->uri->segment(1) === 'class_student' || uri_string() === 'classes/teachers') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe021;"></div>
                Classrooms
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('marketplace') ?>" <?php echo ($this->uri->segment(1) === 'challenge' ||
                $this->uri->segment(1) === 'challenge_class' || $this->uri->segment(1) === 'marketplace' || $this->uri->segment(1) === 'challenge_builder' ||
                $this->uri->segment(2) === 'challenge') ? 'class="selected"' : '' ?>>
                <div class="fs1 " aria-hidden="true" data-icon="&#xe0a4;"></div>
                Challenges
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('statistics/classroom') ?>" <?php echo ($this->uri->segment(1) === 'statistics') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe097;"></div>
                Reporting
            </a>
        </li>

<!--        <li>-->
<!--            <a href="--><?php //echo base_url('statistics/classroom') ?><!--" --><?php //echo ($this->uri->segment(1) === 'statistics') ? 'class="selected"' : '' ?><!-->-->
<!--                <div class="fs1" aria-hidden="true" data-icon="&#xe097;"></div>-->
<!--                Statistics-->
<!--            </a>-->
<!--        </li>-->
        <li>
            <a href="<?php echo base_url('store') ?>" <?php echo ($this->uri->segment(1) === 'store') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe1c7;"></div>
                Licenses
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('support') ?>" <?php echo ($this->uri->segment(1) === 'support') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe03b;"></div>
                Support
            </a>
        </li>
    </ul>
    <div class="clearfix">
    </div>
</div>

<div class="sub-nav">
    <ul>
        <?php if ($this->uri->segment(1) === 'challenge' || $this->uri->segment(1) === 'challenge_class' || $this->uri->segment(1) === 'challenge_builder' || $this->uri->segment(2) === 'challenge' || $this->uri->segment(1) === 'marketplace'): ?>
            <li>
                <a href="" class="heading">Challenge Management</a>
            </li>
            <li>
                <a href="<?php echo base_url('marketplace') ?>" <?php echo($this->uri->segment(1) === 'marketplace')?'class="sub-nav-selected"':''?>>View Challenges</a>
            </li>
            <li>
                <a href="<?php echo base_url('challenge') ?>" <?php echo($this->uri->segment(1) === 'challenge')?'class="sub-nav-selected"':''?>>Assigned Challenges</a>
            </li>
            <li>
                <a href="<?php echo base_url('challenge_builder') ?>" <?php echo($this->uri->segment(1) === 'challenge_builder')?'class="sub-nav-selected"':''?>>Create Challenges</a>
            </li>
        <?php endif; ?>
        <?php if($this->uri->segment(1) === 'reporting'):?>
            <li>
                <a href="" class="heading">Reporting Management</a>
            </li>
            <li>
                <a href="<?php echo base_url('reporting/basic')?>" <?php echo($this->uri->segment(2) === 'basic')?'class="sub-nav-selected"':''?>>Basic</a>
            </li>
            <li>
                <a href="<?php echo base_url('reporting/statistic')?>" <?php echo($this->uri->segment(2) === 'statistic')?'class="sub-nav-selected"':''?>>Statistic</a>
            </li>
        <?php endif;?>
        <?php if($this->uri->segment(1) === 'statistics'):?>
            <li>
                <a href="" class="heading">Statistics Management</a>
            </li>
            <li>
                <a href="<?php echo base_url('statistics/classroom')?>" <?php echo($this->uri->segment(2) === 'classroom')?'class="sub-nav-selected"':''?>>Classroom</a>
            </li>
            <li>
                <a href="<?php echo base_url('statistics/student')?>" <?php echo($this->uri->segment(2) === 'student')?'class="sub-nav-selected"':''?>>Student</a>
            </li>
            <li>
                <a href="<?php echo base_url('statistics/drilldown')?>" <?php echo($this->uri->segment(2) === 'drilldown')?'class="sub-nav-selected"':''?>>Details</a>
            </li>
        <?php endif;?>
        <?php if($this->uri->segment(1) === 'profile'):?>
            <li>
                <a class="heading">Teacher Profile</a>
            </li>
            <li>
                <a href="<?php echo base_url('profile') ?>" <?php echo($this->uri->segment(3) === '')?'class="sub-nav-selected"':''?>>
                    Change profile
                </a>
            </li>
            <?php if (TeacherHelper::isPublisher() === true): ?>
            <li>
                <a href="<?php echo base_url('profile/publisher') ?>" <?php echo($this->uri->segment(3) === 'publisher')?'class="sub-nav-selected"':''?>>
                    Publisher profile
                </a>
            </li>
            <?php endif ?>
            <li>
                <a href="<?php echo base_url('profile/password') ?>" <?php echo($this->uri->segment(3) === 'password')?'class="sub-nav-selected"':''?>>
                    Change password
                </a>
            </li>
        <?php endif;?>
    </ul>

    <div class="btn-group pull-right">
        <button class="btn btn-warning2">
            Main Navigation
        </button>
        <button data-toggle="dropdown" class="btn btn-warning2 dropdown-toggle">
              <span class="caret">
              </span>
        </button>
        <ul class="dropdown-menu pull-right">
            <li>
                <a href="<?php echo  base_url()?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Home
                </a>
            </li>
            <li>
                <a href="<?php echo  base_url('classes')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Classrooms
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('marketplace')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    View Challenges
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('challenge')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Assigned Challenges
                </a>
            </li>
            <!--<li>
                <a href="<?php echo base_url('challenge_builder')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Create Challenges
                </a>
            </li>-->
            <li>
                <a href="<?php echo base_url('reporting/basic')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Basic Reports
                </a>
            </li>
            <!--<li>
                <a href="<?php echo base_url('reporting/statistic')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Statistic Reports
                </a>
            </li>-->
            <li>
                <a href="<?php echo base_url('store')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Licenses
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('support')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Support
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('profile')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Profile
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('profile/password')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Change Password
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('auth/process_logout')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>