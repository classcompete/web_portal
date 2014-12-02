<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/29/14
 * Time: 1:24 PM
 */
class Reportnewlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('y_reporting_new/reportnew_model');
        $this->ci->load->helper('y_reporting_new/reportnew');
        $this->ci->load->model('y_user/student_model');
        $this->ci->load->model('y_question/question_model');
    }

    /** function for calculating coins for specific challenge by score log */

    public function get_student_coins_for_challenge($created, $student, $class, $challenge_id){
        $shop_transactions = $this->ci->reportnew_model->get_student_coins_from_shop_transaction($created, $student, $class, $challenge_id);


        $coins_num = 0;

        if($shop_transactions->getFirst() !== null){
            foreach($shop_transactions as $key=>$transaction){
                $coins_num += intval($transaction->getNumCoins());
            }
        }


        return $coins_num;
    }

    /**
     * function for creating table for student statistic
     * @params: $data
     * @out:    html
     * */
    public function get_table_student_statistic_individually_challenge($data){
        ob_start();
        ?>
        <table id="class_student_stats_table"
               class="table table-condensed table-striped table-hover table-bordered pull-left dataTable">
            <thead>
            <tr role="row">
                <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">Date</th>
                <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">Challenge Name</th>
                <th style="width: 258px;" class="sorting" rowspan="1" colspan="1">Percentage</th>
                <th style="width: 305px;" class="sorting" rowspan="1" colspan="1">Correct Answers</th>
                <th style="width: 242px;" class="sorting" rowspan="1" colspan="1">Incorrect Answers</th>
                <th class="hidden-phone sorting" style="width: 242px;" rowspan="1" colspan="1">Time on Course</th>
                <?php /*<th class="hidden-phone sorting_desc" style="width: 242px;" rowspan="1" colspan="1">Coins Collected</th>*/?>
            </tr>
            </thead>
            <tbody id="class_student_stats_tbody">
            <?php foreach ($data as $k => $v): ?>
                <tr class="gradeA info odd">
                    <td><?php echo $v['date']?></td>
                    <td><?php echo $v['challenge_name']?></td>
                    <td><?php echo $v['percentage']?></td>
                    <td><?php echo $v['correct_answers']?></td>
                    <td><?php echo $v['incorrect_answers']?></td>
                    <td class="hidden-phone"><?php echo $v['time_on_course']?></td>
                    <?php /*<td class="hidden-phone sorting_1"><?php echo $v['coins_collected']?></td>*/?>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php
        $out =  ob_get_clean();
        return $out;
    }
}