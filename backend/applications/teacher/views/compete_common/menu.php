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
            <a href="<?php echo base_url('reporting/basic') ?>" <?php echo ($this->uri->segment(1) === 'reporting') ? 'class="selected"' : '' ?>>
                <div class="fs1" aria-hidden="true" data-icon="&#xe097;"></div>
                Reporting
            </a>
        </li>
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
            <li>
                <a href="<?php echo base_url('challenge_builder')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Create Challenges
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('reporting/basic')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Basic Reports
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('reporting/statistic')?>">
                    <div class="fs1" aria-hidden="true"></div>
                    Statistic Reports
                </a>
            </li>
        </ul>
    </div>
</div>