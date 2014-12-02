<div class="dashboard-wrapper">

    <div class="left-sidebar">

        <div class="row-fluid">
            <div class="span12">
                <div class="widget no-margin">
                    <div class="widget-header">
                        <div class="title">Edit Profile</div>
                        <span class="tools">
                            <a class="fs1" aria-hidden="true" data-icon="&#xe090;"></a>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div class="container-fluid">

                            <?php echo form_open_multipart('profile/info_update',
                                array(
                                    'method' => 'post',
                                    'class' => 'form-horizontal no-margin',
                                    'id' => 'teacher_info_form'))
                            ?>
                            <div class="row-fluid">
                                <div class="span3">
                                    <div class="thumbnail">
                                        <img id="teacher_avatar"
                                             src="<?php echo site_url('profile/display_teacher_image') ?>"
                                             alt="300x200">
                                        <input type="hidden" id="teacher_avatar_url" name="teacher_avatar_url"/>
                                    </div>
                                    <button type="button" class="btn btn-large btn-info btn-block"
                                            id="teacher_avatar_upload">Upload Image
                                    </button>
                                </div>
                                <div class="span9">
                                    <h5>Your Info</h5>
                                    <hr>

                                    <div class="control-group">
                                        <label class="control-label">First Name</label>

                                        <div class="controls">
                                            <input type="text" placeholder="First Name" name="first_name"
                                                   id="first_name" value="<?php echo $teacher_info->getPropUser()->getFirstName() ?>"/>
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Last Name</label>

                                        <div class="controls">
                                            <input type="text" placeholder="Last Name" name="last_name" id="last_name"
                                                   value="<?php echo $teacher_info->getPropUser()->getLastName() ?>"/>
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Email</label>

                                        <div class="controls">
                                            <div class="input-prepend">
                                                <span class="add-on">@</span>
                                                <input type="text" placeholder="Email" id="email" name="email"
                                                       class="span12" style="width: 193px"
                                                       value="<?php echo $teacher_info->getPropUser()->getEmail() ?>">
                                            </div>
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Bio</label>

                                        <div class="controls">
                                            <textarea name="bio" id="bio" cols="30" class="span6" rows="10"><?php echo $teacher_info->getBiography()?></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group grade_holder">
                                        <div class="controls clearfix">
                                            <label class="span2">
                                                <input class="input" type="checkbox" name="grade[-2]" <?php echo(isset($teacher_grades->grade_pre_k) === true ? 'checked="checked"':'')?>/>Pre - K
                                            </label>
                                            <label class="span2">
                                                <input class="input" type="checkbox" name="grade[-1]" <?php echo(isset($teacher_grades->grade_k) === true ? 'checked="checked"':'')?>/>K
                                            </label>
                                            <label class="span2">
                                                <input class="input" type="checkbox" name="grade[1]" <?php echo(isset($teacher_grades->grade_1) ? 'checked="checked"':'')?>/>Grade 1
                                            </label>
                                            <label class="span2">
                                                <input class="input" type="checkbox"  name="grade[2]" <?php echo(isset($teacher_grades->grade_2) === true ? 'checked="checked"':'')?>/>Grade 2
                                            </label>
                                        </div>
                                        <div class="controls clearfix">
                                            <label class="span2">
                                                <input class="input" type="checkbox"  name="grade[3]" <?php echo(isset($teacher_grades->grade_3) === true ? 'checked="checked"':'')?>/>Grade 3
                                            </label>
                                            <label class="span2">
                                                <input class="input" type="checkbox" name="grade[4]" <?php echo(isset($teacher_grades->grade_4) === true ? 'checked="checked"':'')?>/>Grade 4
                                            </label>
                                            <label class="span2">
                                                <input class="input" type="checkbox"  name="grade[5]" <?php echo(isset($teacher_grades->grade_5) === true ? 'checked="checked"':'')?>/>Grade 5
                                            </label>
                                            <label class="span2">
                                                <input class="input" type="checkbox" name="grade[6]" <?php echo(isset($teacher_grades->grade_6) === true ? 'checked="checked"':'')?>/>Grade 6
                                            </label>
                                        </div>
                                        <div class="controls clearfix">
                                            <label class="span2">
                                                <input class="input" type="checkbox"  name="grade[7]" <?php echo(isset($teacher_grades->grade_7) === true ? 'checked="checked"':'')?>/>Grade 7
                                            </label>
                                            <label class="span2">
                                                <input class="input" type="checkbox"  name="grade[8]" <?php echo(isset($teacher_grades->grade_8) === true ? 'checked="checked"':'')?>/>Grade 8
                                            </label>
                                            <label class="span2">
                                                <input class="input" type="checkbox"  name="grade[9]" <?php echo(isset($teacher_grades->high_school) === true ? 'checked="checked"':'')?>/>
                                                High School
                                            </label><label class="span2">
                                                <input class="input" type="checkbox"  name="grade[10]" <?php echo(isset($teacher_grades->higher_ed) === true ? 'checked="checked"':'')?>/>
                                                Higher ED
                                            </label>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <select class="span12" style="width: 223px;" name="country" id="country">
                                                <option>Country</option>
                                                <?php foreach ($countryList as $country): ?>
                                                    <option value="<?php echo $country->getIso2Code()?>"
                                                        <?php echo ($country->getIso2Code() === $teacher_info->getCountry()) ? 'selected="selected"': ''?>>
                                                        <?php echo $country->getName()?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                            <span>*</span>
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-info" id="teacher_info_form_submit">Save changes</button>
<!--                                        <button type="button" class="btn">Cancel</button>-->
                                    </div>

                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>

                        <div class="container-fluid">
                            <div class="span3"></div>
                            <div class="span9">
                                <?php echo form_open('profile/process_change_timezone', array('method'=>'POST', 'class'=>'form-horizontal no-margin', 'id'=>'teacher_timezone_form'))?>
                                    <h5>Change Time zone</h5>
                                    <hr>
                                    <div class="control-group">
                                        <div class="control-label">Current time zone</div>
                                        <div class="controls">
                                            <select name="timezone" id="">
                                                <option value="" disabled selected>Select time zone</option>
                                                <?php foreach($timezone as $zone_key=>$zone_val):?>
                                                    <option value="<?php echo $zone_val->getDifference()?>" <?php echo ($teacher_info->getTimeDiff() === $zone_val->getDifference())?'selected':''?>> <?php echo $zone_val->getName()?> </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-info" id="teacher_time_zone_submit">Change time zone</button>
                                        </div>
                                    </div>
                                <?php echo form_close();?>
                            </div>
                        </div>

                        <div class="container-fluid">

                            <div class="row-fluid">
                                <div class="span3"></div>
                                <div class="span9">
                                    <?php echo form_open_multipart('profile/password_update',
                                        array(
                                            'method' => 'post',
                                            'class' => 'form-horizontal no-margin',
                                            'id' => 'teacher_password_form'))
                                    ?>
                                    <h5>Change Password</h5>
                                    <hr>

                                    <div class="control-group">
                                        <label class="control-label">Old Password</label>

                                        <div class="controls">
                                            <input type="password" placeholder="Old Password" name="old_password"
                                                   id="old_password" autocomplete="off"/>
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">New Password</label>

                                        <div class="controls">
                                            <input type="password" placeholder="Password" name="password1"
                                                   id="password1" autocomplete="off"/>
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Confirm Password</label>

                                        <div class="controls">
                                            <input type="password" placeholder="Confirm Password" name="password2"
                                                   id="password2" autocomplete="off"/>
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-info" id="teacher_pass_form_submit">Change
                                            Password
                                        </button>
<!--                                        <button type="button" class="btn">Cancel</button>-->
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                            </div>

                        </div>


                        <div class="container-fluid">

                            <div class="row-fluid">
                                <div class="span3"></div>
                                <div class="span9">
                                    <?php echo form_open_multipart('profile/school_update',array('method' => 'post','class' => 'form-horizontal no-margin','id' => 'teacher_school_form'))?>
                                    <h5>Change School</h5>
                                    <span class="error_text"><?php echo ($teacher_info->getSchoolId() === 0 || $teacher_info->getSchoolId() === null)?'Your school is declined':'';?></span>
                                    <hr>
                                    <div class="control-group">
                                        <label class="control-label">Zip code</label>
                                        <div class="controls">
                                            <input class="input" type="text" placeholder="Type zip code" id="zip_code" name="zip_code" value="<?php echo ($teacher_info->getSchoolId() === 0 || $teacher_info->getSchoolId() === null)?'': $teacher_info->getPropSchool()->getZipCode();?>"/>
                                            <span class="help-inline"><?php echo form_error('zip_code'); ?></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">School name</label>
                                        <div class="controls">
                                            <input type="hidden" id="school_id" name="school_id" value="<?php echo ($teacher_info->getSchoolId() === 0)?'': $teacher_info->getSchoolId()?>">
                                            <input class="input password" placeholder="Type your school name" type="text" id="school_name_edit" name="school_name" value="<?php echo ($teacher_info->getSchoolId() === 0 || $teacher_info->getSchoolId() === null)?'': $teacher_info->getPropSchool()->getName();?>"/>
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">My school is not listed</label>
                                        <div class="controls">
                                            <input type="checkbox" name="not_listed" id="not_listed" <?php echo ($teacher_info->getSchoolId() === 0 || $teacher_info->getSchoolId() === null)?'': (($teacher_info->getPropSchool()->getApproved() === 'not_approved')?'checked':'')?>>
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-info" id="teacher_school_form_submit">Change School</button>
<!--                                        <button type="button" class="btn">Cancel</button>-->
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>