<?php
$teacherId = TeacherHelper::getId();
$teacher = PropTeacherQuery::create()->findOneByTeacherId($teacherId);

$grades = $teacher->getPropTeacherGrades();
?>
<div class="dashboard-wrapper">
    <div class="left-sidebar" style="width: 100%">
        <div class="row-fluid">
            <div class="span12 col-lg-12 col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">
                            Update your teacher account profile
                        </div>
                        <span class="tools">
                            <i class="fa fa-cogs"></i>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div class="row-fluid">
                            <form class="form-horizontal" autocomplete="off" id="general-profile">
                                <div class="span6 col-lg-6 col-md-6">

                                    <h5>Personal Information</h5>
                                    <hr/>
                                    <div class="control-group <?php echo ($userProfile->getFirstName()=='')?'has-error':''?>">
                                        <label class="control-label" for="first_name"><strong>*</strong> First Name</label>

                                        <div class="controls">
                                            <input type="text" name="first_name" id="first_name"
                                                   value="<?php echo $userProfile->getFirstName()?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="control-group <?php echo ($userProfile->getLastName()=='')?'has-error':''?>">
                                        <label class="control-label" for="last_name"><strong>*</strong> Last Name</label>

                                        <div class="controls">
                                            <input type="text" name="last_name" id="last_name"
                                                   value="<?php echo $userProfile->getLastName()?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="control-group <?php echo ($userProfile->getEmail()=='')?'has-error':''?>">
                                        <label class="control-label" for="email"><strong>*</strong> Email Address</label>

                                        <div class="controls">
                                            <input type="email" name="email" id="email"
                                                   value="<?php echo $userProfile->getEmail()?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="control-group <?php echo ($teacherProfile->getCountry()=='')?'has-error':''?>">
                                        <label class="control-label" for="country"><strong>*</strong> Country</label>

                                        <div class="controls">
                                            <select name="country" id="country">
                                                <option value="">Country</option>
                                                <option value="US"
                                                    <?php echo ('US' === $teacherProfile->getCountry()) ? 'selected="selected"': ''?>>United States</option>
                                                <option value="CA"
                                                    <?php echo ('CA' === $teacherProfile->getCountry()) ? 'selected="selected"': ''?>>Canada</option>
                                                <option value="IN"
                                                    <?php echo ('IN' === $teacherProfile->getCountry()) ? 'selected="selected"': ''?>>India</option>
                                                <option disabled="disabled">-------------------------</option>
                                                <?php foreach ($countryList as $country): ?>
                                                    <option value="<?php echo $country->getIso2Code()?>"
                                                        <?php echo ($country->getIso2Code() === $teacherProfile->getCountry()) ? 'selected="selected"': ''?>>
                                                        <?php echo $country->getName()?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <hr/>
                                    <h5><strong>*</strong> Grades you are teaching</h5>
                                    <div class="<?php echo ($grades->count() == 0)?'has-error':'' ?>">
                                        <div class="control-group grade_holder">
                                            <div class="span12 col-lg-12 col-md-12">
                                                <label class="span3">
                                                    <input class="input" type="checkbox" name="grade[-2]" <?php echo(isset($teacherGrades->grade_pre_k) === true ? 'checked="checked"':'')?>/>Pre - K
                                                </label>
                                                <label class="span3">
                                                    <input class="input" type="checkbox" name="grade[-1]" <?php echo(isset($teacherGrades->grade_k) === true ? 'checked="checked"':'')?>/>K
                                                </label>
                                                <label class="span3">
                                                    <input class="input" type="checkbox" name="grade[1]" <?php echo(isset($teacherGrades->grade_1) ? 'checked="checked"':'')?>/>Grade 1
                                                </label>
                                                <label class="span3">
                                                    <input class="input" type="checkbox"  name="grade[2]" <?php echo(isset($teacherGrades->grade_2) === true ? 'checked="checked"':'')?>/>Grade 2
                                                </label>
                                            </div>
                                        </div>
                                        <div class="control-group grade_holder">
                                            <div class="span12 col-lg-12 col-md-12">
                                                <label class="span3">
                                                    <input class="input" type="checkbox"  name="grade[3]" <?php echo(isset($teacherGrades->grade_3) === true ? 'checked="checked"':'')?>/>Grade 3
                                                </label>
                                                <label class="span3">
                                                    <input class="input" type="checkbox" name="grade[4]" <?php echo(isset($teacherGrades->grade_4) === true ? 'checked="checked"':'')?>/>Grade 4
                                                </label>
                                                <label class="span3">
                                                    <input class="input" type="checkbox"  name="grade[5]" <?php echo(isset($teacherGrades->grade_5) === true ? 'checked="checked"':'')?>/>Grade 5
                                                </label>
                                                <label class="span3">
                                                    <input class="input" type="checkbox" name="grade[6]" <?php echo(isset($teacherGrades->grade_6) === true ? 'checked="checked"':'')?>/>Grade 6
                                                </label>
                                            </div>
                                        </div>
                                        <div class="control-group grade_holder">
                                            <div class="span12 col-lg-12 col-md-12">
                                                <label class="span3">
                                                    <input class="input" type="checkbox"  name="grade[7]" <?php echo(isset($teacherGrades->grade_7) === true ? 'checked="checked"':'')?>/>Grade 7
                                                </label>
                                                <label class="span3">
                                                    <input class="input" type="checkbox"  name="grade[8]" <?php echo(isset($teacherGrades->grade_8) === true ? 'checked="checked"':'')?>/>Grade 8
                                                </label>
                                                <label class="span3">
                                                    <input class="input" type="checkbox"  name="grade[9]" <?php echo(isset($teacherGrades->high_school) === true ? 'checked="checked"':'')?>/>
                                                    High School
                                                </label>
                                                <label class="span3">
                                                    <input class="input" type="checkbox"  name="grade[10]" <?php echo(isset($teacherGrades->higher_ed) === true ? 'checked="checked"':'')?>/>
                                                    Higher ED
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 col-lg-6 col-md-6">
                                    <h5>School Information</h5>
                                    <div class="control-group <?php echo ($teacherProfile->getSchoolId()==0)?'has-error':''?>">
                                        <label class="control-label">Zip code</label>
                                        <div class="controls">
                                            <input class="input" type="text" placeholder="Type zip code" id="zip_code" name="zip_code"
                                                   value="<?php echo ($teacherProfile->getSchoolId() === 0 || $teacherProfile->getSchoolId() === null)?'': $teacherProfile->getPropSchool()->getZipCode();?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group <?php echo ($teacherProfile->getSchoolId()==0)?'has-error':''?>">
                                        <label class="control-label"><strong>*</strong> School name</label>
                                        <div class="controls">
                                            <input type="hidden" id="school_id" name="school_id" value="<?php echo ($teacherProfile->getSchoolId() === 0)?'': $teacherProfile->getSchoolId()?>">
                                            <input class="input password" placeholder="Type your school name" type="text" id="school_name_edit" name="school_name"
                                                   value="<?php echo ($teacherProfile->getSchoolId() === 0 || $teacherProfile->getSchoolId() === null)?'': $teacherProfile->getPropSchool()->getName();?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">My school is not listed</label>
                                        <div class="controls">
                                            <input type="checkbox" name="not_listed" id="not_listed"
                                                <?php echo ($teacherProfile->getSchoolId() === 0 || $teacherProfile->getSchoolId() === null)?'': (($teacherProfile->getPropSchool()->getApproved() === 'not_approved')?'checked':'')?>>
                                        </div>
                                    </div>
                                    <hr/>
                                    <h5>Social Links</h5>
                                    <div class="control-group">
                                        <label class="control-label" for="twitter_name">Twitter Username (@)</label>

                                        <div class="controls">
                                            <input type="text" name="twitter_name" id="twitter_name"
                                                   value="<?php echo $teacherProfile->getTwitterName()?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="facebook_link">Facebook Profile link (with https://)</label>

                                        <div class="controls">
                                            <input type="text" name="facebook_link" id="facebook_link"
                                                   value="<?php echo $teacherProfile->getFacebookLink()?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <hr/>
                                    <h5>Time Zone Information</h5>
                                    <div class="control-group">
                                        <label class="control-label" for="facebook_link">Select Timezone</label>

                                        <div class="controls">
                                            <select name="timezone" id="">
                                                <option value="" disabled selected>Select time zone</option>
                                                <?php foreach($timezones as $zone):?>
                                                    <option value="<?php echo $zone->getDifference()?>"
                                                        <?php echo ($teacherProfile->getTimeDiff() === $zone->getDifference())?'selected':''?>>
                                                        <?php echo $zone->getName()?>
                                                    </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="span12 col-lg-12 col-md-12" style="margin: 0px;">
                                    <div class="form-actions">
                                        <button class="btn btn-info pull-right" type="submit">
                                            Update Profile
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    label, input, button, select, textarea {
        font-size: 15px;
    }
    .has-error {
        background: none repeat scroll 0 0 #f2dede;
        border: 1px solid #a94442;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        padding: 5px 0;
        width: 90%;
    }
    .form-control {
        background-color: #fff;
        background-image: none;
        border: 3px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        color: #555;
        display: block;
        font-size: 14px;
        height: 34px;
        line-height: 1.42857;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    }
</style>
<script type="text/javascript">
    $('#general-profile').on('submit', function () {

        $('#general-profile').find('button[type=submit]').html('Sending...');
        $.post('/v2/profile/generalProfilePut', $('#general-profile').serialize(), function () {
            $.gritter.add({
                title: 'Great',
                text: 'Your profile was updated successfully. <br/>You can now create classrooms',
                sticky: false,
                time: 10000
            });
        }).always(function () {
            $('#general-profile').find('button[type=submit]').html('Update Profile');
        }).fail(function (jqXHR, textStatus, errorThrown) {
            try {
                response = $.parseJSON(jqXHR.responseText);
                if (response.error) {
                    if (response.extended) {
                        message = response.extended.join('<br/>');
                    } else {
                        message = response.error;
                    }

                } else {
                    message = "Please try again. If you keep seeing this message, contact us";
                }
            } catch (e) {
                message = "Please try again. If you keep seeing this message, contact us";
            }

            $.gritter.add({
                title: 'Ooups, something went wrong',
                text: message,
                sticky: false,
                time: 10000
            });
        });
        return false;
    });
</script>