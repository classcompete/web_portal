<div class="top-nav">
    <ul>
        <li>
            <a href="<?php echo base_url('admin') ?>" <?php echo ($this->uri->segment(1) === 'admin') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe08c;"></div>
                Admin
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('users/teachers') ?>" <?php echo ($this->uri->segment(1) === 'users' ||
                $this->uri->segment(2) === 'students' || $this->uri->segment(2) === 'teachers') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe071"></div>
                Users
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('classes') ?>" <?php echo ($this->uri->segment(1) === 'classes' ||
                ($this->uri->segment(1) === 'class_student' && $this->uri->segment(2) !== 'students')) ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe021;"></div>
                Classes
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('subject') ?>" <?php echo ($this->uri->segment(1) === 'subject' ||
                $this->uri->segment(1) === 'skill' || $this->uri->segment(1) === 'topic') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe149;"></div>
                Subjects
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('games') ?>" <?php echo ($this->uri->segment(1) === 'games' ||
                $this->uri->segment(1) === 'gamelevels' || $this->uri->segment(1) === 'connection') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe016;"></div>
                Misc
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('challenge') ?>" <?php echo ($this->uri->segment(1) === 'challenge' ||
                $this->uri->segment(1) === 'challenge_class') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe022;"></div>
                Challenge
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('question') ?>" <?php echo ($this->uri->segment(1) === 'question') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe0f6;"></div>
                Question
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('reporting/basic') ?>" <?php echo ($this->uri->segment(1) === 'reporting') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe097;"></div>
                Reporting
            </a>
        </li>
    </ul>
    <div class="clearfix">
    </div>
</div>

<div class="sub-nav">
    <ul>
        <?php if ($this->uri->segment(1) === 'admin'): ?>
            <li>
                <a href="" class="heading">Admin Management</a>
            </li>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) === 'users'): ?>
            <li>
                <a href="" class="heading">User Management</a>
            </li>
            <li>
                <a href="<?php echo base_url('users/teachers') ?>">Teachers</a>
            </li>
            <li>
                <a href="<?php echo base_url('users/students') ?>">Students</a>
            </li>
            <li>
                <a href="<?php echo base_url('users/parents')?>">Parents</a>
            </li>
            <li>
                <a href="<?php echo base_url('users/statistic/') ?>">Statistics</a>
            </li>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) === 'classes' || $this->uri->segment(1) === 'class_student'): ?>
            <li>
                <a href="" class="heading">Class Management</a>
            </li>
            <li>
                <a href="<?php echo base_url('classes') ?>">Classes</a>
            </li>
            <?php /*<li>
                    <a href="<?php echo base_url('class_student') ?>">Student in class</a>
                </li>
            */?>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) === 'subject' || $this->uri->segment(1) === 'skill' || $this->uri->segment(1) === 'topic'): ?>
            <li>
                <a href="" class="heading">Subject Management</a>
            </li>
            <li>
                <a href="<?php echo base_url('subject') ?>">Subjects</a>
            </li>
            <li>
                <a href="<?php echo base_url('skill') ?>">Topics</a>
            </li>
            <li>
                <a href="<?php echo base_url('topic') ?>">Subtopics</a>
            </li>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) === 'games' || $this->uri->segment(1) === 'gamelevels' || $this->uri->segment(1) === 'connection' || $this->uri->segment(1) === 'school'): ?>
            <li>
                <a href="" class="heading">Game Management</a>
            </li>
            <li>
                <a href="<?php echo base_url('games') ?>">Environments</a>
            </li>
            <li>
                <a href="<?php echo base_url('connection') ?>">Connection</a>
            </li>
            <li>
                <a href="<?php echo base_url('school') ?>">School</a>
            </li>
            <li>
                <a href="<?php echo base_url('school/pending') ?>">Pending School</a>
            </li>
            <li><a href="<?php echo base_url('subscriber/csv') ?>">Subscribers CSV</a></li>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) === 'challenge' || $this->uri->segment(1) === 'challenge_class'): ?>
            <li>
                <a href="" class="heading">Challenge Management</a>
            </li>
            <li>
                <a href="<?php echo base_url('challenge') ?>">Challenges</a>
            </li>
            <li>
                <a href="<?php echo base_url('challenge_class') ?>">Challenge Classes</a>
            </li>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) === 'question'): ?>
            <li>
                <a href="" class="heading">Question Management</a>
            </li>
        <?php endif; ?>
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
                <a href="<?php echo site_url() ?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Home
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('admin') ?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Admin
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('users') ?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Users
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('classes') ?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Classes
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('subject') ?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Subject
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('games') ?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Games
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('challenge') ?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Challenge
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('question') ?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Question
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('connection') ?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Connection
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('reporting/basic') ?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Rep[orting
                </a>
            </li>
        </ul>
    </div>
</div>