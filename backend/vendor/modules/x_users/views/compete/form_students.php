<?php echo form_open_multipart('users/save', array('method' => 'post', 'class' => 'form-horizontal no-margin')) ?>

    <div class="control-group">
        <label class="control-label">Username</label>

        <div class="controls">
            <input type="text" name="username" id="username" value="<?php echo set_value('username') ?>"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">First name</label>

        <div class="controls">
            <input type="text" name="first_name" id="first_name" value="<?php echo set_value('first_name') ?>"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Last name</label>

        <div class="controls">
            <input type="text" name="last_name" id="last_name" value="<?php echo set_value('last_name') ?>"/>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label">Email</label>

        <div class="controls">
            <input type="text" name="email" id="email" value="<?php echo set_value('email') ?>"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Date of birth</label>
        <div class="controls" id="text_date">
            <label class="control-label" style="width: 40px">Year</label>
            <div class="controls" style="margin-left: 50px">
                <input type="text" name="t_dob_year" id="t_dob_year" placeholder="Year" class="span2">
            </div>
            <label class="control-label" style="width: 40px">Month</label>
            <div class="controls" style="margin-left: 50px">
                <input type="text" name="t_dob_month" id="t_dob_month" placeholder="Month" class="span2">
            </div>
            <label class="control-label" style="width: 40px">Day</label>
            <div class="controls" style="margin-left: 50px">
                <input type="text" name="t_dob_day" id="t_dob_day" placeholder="Day" class="span2">
            </div>

        </div>
        <div class="controls " id="dropdown_date">
            <select class="span2" name="dob_month" id="dob_month" style="width: 90px">
                <option disabled="disabled">Month</option>
                <option value="01">Jan</option>
                <option value="02">Feb</option>
                <option value="03">Mar</option>
                <option value="04">Apr</option>
                <option value="05">May</option>
                <option value="06">Jun</option>
                <option value="07">Jul</option>
                <option value="08">Aug</option>
                <option value="09">Sep</option>
                <option value="10">Oct</option>
                <option value="11">Nov</option>
                <option value="12">Dec</option>
            </select>
            <select class="span2 input-left-top-margins" name="dob_day" id="dob_day" style="width: 55px">
                <option disabled="disabled">Day</option>
                <option value="01">1</option>
                <option value="02">2</option>
                <option value="03">3</option>
                <option value="04">4</option>
                <option value="05">5</option>
                <option value="06">6</option>
                <option value="07">7</option>
                <option value="08">8</option>
                <option value="09">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
            </select>

            <select class="span2 input-left-top-margins" style="width: 70px" name="dob_year" id="dob_year">
                <option disabled="disabled">Year</option>
                <?php
                $years = range(date("Y"), date("Y", strtotime("now - 20 years")));
                foreach ($years as $year) {
                    echo'<option value="' . $year . '">' . $year . '</option>';
                }
                ?>

            </select>

        </div>
    </div>

    <div class="control-group" style="display: none">
        <label class="control-label">Parent email</label>

        <div class="controls">
            <input type="text" name="parent_email" id="parent_email" value="<?php echo set_value('parent_email') ?>"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Image</label>

        <div class="controls">
            <img id="image_link" src="" width="100px" height="100px">
<!--            <input type="file" name="image" id="image" value="" style="width: 230px !important;"/>-->
        </div>
    </div>




    <div class="modal-footer">
        <button class="btn btn-primary">Save changes</button>
    </div>

    <input type="hidden" name="id" id="edit_student_id"/>

    <input type="hidden" name="user" id="user_type" value="student"/>

<?php echo form_close() ?>