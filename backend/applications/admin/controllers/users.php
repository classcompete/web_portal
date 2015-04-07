<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/5/13
 * Time: 11:25 AM
 * To change this template use File | Settings | File Templates.
 */

require_once APPPATH . 'third_party/PHPExcel.php';
require_once APPPATH . 'third_party/PHPExcel/Writer/Excel2007.php';

class Users extends MY_Controller
{
    public function __construct()
    {
        parent:: __construct();

        $this->load->library('x_users/userslib');
        $this->load->library('propellib');
        $this->load->model('x_users/teacher_model');
        $this->load->model('x_users/parent_model');
        $this->load->library('x_reporting/reportlib');
        $this->load->library('y_mailer/mailerlib');
        $this->load->library('form_validation');

        $this->propellib->load_object('User');
        $this->mapperlib->set_model($this->users_model);

        $this->mapperlib->add_column('login', 'USERNAME', true);
        $this->mapperlib->add_column('first_name', 'FIRST NAME', true);
        $this->mapperlib->add_column('last_name', 'LAST NAME', true);
        $this->mapperlib->add_column('email', 'EMAIL', true);
        $this->mapperlib->add_column('created', 'CREATED ', false);
        $this->mapperlib->add_column('modified', 'MODIFIED', false);

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'username',
            ),
            'uri' => '#users/edit',
            'params' => array(
                'id',
            ),
            'data-toggle' => 'modal',
            'data-target' => '#addEditUser'
        ));

        $this->mapperlib->add_order_by('login', 'USERNAME');
        $this->mapperlib->add_order_by('first_name', 'FIRST NAME');
        $this->mapperlib->add_order_by('last_name', 'LAST NAME');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);

        if ($this->uri->segment(2) === 'teachers')
            $this->mapperlib->set_default_base_page('users/teachers');
        else if ($this->uri->segment(2) === 'students')
            $this->mapperlib->set_default_base_page('users/students');
        else if ($this->uri->segment(2) === 'parents')
            $this->mapperlib->set_default_base_page('users/parents');

    }

    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('users/index/' . $uri);
        }

        $data = new stdClass();

        $data->content = $this->prepareView('x_users', 'home', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function students()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('users/students/' . $uri);
        }

        $this->mapperlib->set_default_order(PropUserPeer::CREATED, Criteria::DESC);

        $this->mapperlib->add_column('login', 'USERNAME', true);

        $this->mapperlib->add_option('classes', array(
            'title' => array(
                'base' => 'Classes',
                'field' => 'username',
            ),
            'uri' => 'class_student/students',
            'params' => array(
                'id',
            ),
            'data-toggle' => '',
            'data-target' => ''
        ));
        $this->mapperlib->add_option('reset_pwd', array(
            'title' => array(
                'base' => 'Reset Pwd',
                'field' => 'username',
            ),
            'uri' => 'users/reset_password_student',
            'params' => array(
                'id',
            ),
            'data-toggle' => '',
            'data-target' => ''
        ));

        $data = new stdClass();


        $this->mapperlib->set_model($this->users_model);
        $data->table = $this->mapperlib->generate_table(true);

        $data->count_students = $this->users_model->getFoundRows();

        $data->content = $this->prepareView('x_users', 'students', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function students_export()
    {
        $this->db->select('first_name, last_name, email, dob, parent_email, login AS username');
        $this->db->join('students', 'users.user_id = students.user_id', 'INNER');
        $this->db->order_by('first_name', 'ASC');
        $students = $this->db->get('users')
            ->result();


        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("ClassCompete");
        $objPHPExcel->getProperties()->setLastModifiedBy("ClassCompete");
        $objPHPExcel->getProperties()->setTitle("Students export - " . date("Y-m-d"));
        $objPHPExcel->getProperties()->setSubject("Students export - " . date("Y-m-d"));
        $objPHPExcel->getProperties()->setDescription("Students export - " . date("Y-m-d"));

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Username');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Firstname');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Lastname');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'DOB');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Parent Email');

        foreach ($students as $k => $user) {
            $r = $k + 2;

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $r, $user->username);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $r, $user->first_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $r, $user->last_name);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $r, $user->dob);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $r, $user->email);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $r, $user->parent_email);
        }

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . 'students-export-' . date("Y-m-d") . '.xls' . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function students_pc($classId)
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('users/students_pc/' . $classId . $uri);
        }

        $this->mapperlib->set_default_base_page('users/students_pc/' . $classId);
        $this->mapperlib->set_breaking_segment(3);
        $this->mapperlib->set_default_order(PropUserPeer::LOGIN, Criteria::DESC);

        $this->mapperlib->add_column('login', 'USERNAME', true);

        $this->mapperlib->add_option('classes', array(
            'title' => array(
                'base' => 'Classes',
                'field' => 'username',
            ),
            'uri' => 'class_student/students',
            'params' => array(
                'id',
            ),
            'data-toggle' => '',
            'data-target' => ''
        ));
        $this->mapperlib->add_option('reset_pwd', array(
            'title' => array(
                'base' => 'Reset Pwd',
                'field' => 'username',
            ),
            'uri' => 'users/reset_password_student',
            'params' => array(
                'id',
            ),
            'data-toggle' => '',
            'data-target' => ''
        ));
        $this->mapperlib->add_option('admin_student_profile', array(
            'title' => array(
                'base' => 'View student results',
                'field' => 'username',
            ),
            'uri' => '#/student_info',
            'params' => array(
                'id',
            ),
            'data-target' => '#studentInfo',
            'data-toggle' => 'modal'
        ));

        $this->users_model->filterByClassId($classId);

        $data = new stdClass();


        $this->mapperlib->set_model($this->users_model);
        $data->table = $this->mapperlib->generate_table(true);

        $data->count_students = $this->users_model->getFoundRows();

        $data->content = $this->prepareView('x_users', 'students', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function parents()
    {
        $this->load->library('x_users/parentlib');
        $this->propellib->load_object('Parent');
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('users/parents/' . $uri);
        }
        $this->mapperlib->set_default_order(PropParentPeer::CREATED, Criteria::DESC);

//        $this->mapperlib->remove_column('created');
//        $this->mapperlib->remove_column('modified');
//        $this->mapperlib->set_breaking_segment(3);
        $data = new stdClass();

        $this->mapperlib->add_option('reset_pwd', array(
            'title' => array(
                'base' => 'Reset Pwd',
                'field' => 'username',
            ),
            'uri' => 'users/reset_password_parent',
            'params' => array(
                'id',
            ),
            'data-toggle' => '',
            'data-target' => ''
        ));

        $this->mapperlib->set_model($this->parent_model);
        $data->table = $this->mapperlib->generate_table(true);

        $data->count_parents = $this->parent_model->getFoundRows();

        $data->content = $this->prepareView('x_users', 'parents', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    /**
     * @var $user PropUser
     * @var $parent PropParent
     */
    public function parents_export()
    {
        $this->db->select('users.user_id, first_name, last_name, email, login AS username');
        $this->db->join('parents', 'users.user_id = parents.user_id', 'INNER');
        $this->db->order_by('first_name', 'ASC');
        $parents = $this->db->get('users')
            ->result();

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("ClassCompete");
        $objPHPExcel->getProperties()->setLastModifiedBy("ClassCompete");
        $objPHPExcel->getProperties()->setTitle("Parents export - " . date("Y-m-d"));
        $objPHPExcel->getProperties()->setSubject("Parents export - " . date("Y-m-d"));
        $objPHPExcel->getProperties()->setDescription("Parents export - " . date("Y-m-d"));

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Username');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Firstname');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Lastname');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Email');

        $objPHPExcel->getActiveSheet()->SetCellValue('E1', '1st Date Purchased');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', '1st Quantity');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', '2nd Date Purchased');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', '2nd Quantity');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', '3rd Date Purchased');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', '3rd Quantity');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Total Purchases');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Total Quantity');

        foreach ($parents as $k => $user) {
            $r = $k + 2;

            $parent = PropParentQuery::create()->findOneByUserId($user->user_id);

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $r, $user->username);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $r, $user->first_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $r, $user->last_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $r, $user->email);

            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $r, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $r, '');

            $ordersToShow = 3;
            $ordersShown = 1;
            // load first 3 orders
            $orders = $parent->getPropParentOrders();
            if ($orders->count() > 0) {
                foreach ($orders as $order) {
                    if ($ordersShown <= $ordersToShow) {

                    }
                }
            }

        }

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . 'parents-export-' . date("Y-m-d") . '.xls' . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function teachers()
    {
        $this->load->model('x_users/teacher_model');

        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('users/teachers/' . $uri);
        }

	    $this->mapperlib->add_column('last_login_time', 'LAST LOGIN', false);
        $this->mapperlib->set_default_order(PropUserPeer::CREATED, Criteria::DESC);

        $this->mapperlib->add_option('classes', array(
            'title' => array(
                'base' => 'Classes',
                'field' => 'username',
            ),
            'uri' => 'classes/index',
            'params' => array(
                'id',
            ),
            'data-toggle' => '',
            'data-target' => ''
        ));
        $this->mapperlib->add_option('profile_info', array(
            'title' => array(
                'base' => 'Profile view',
                'field' => 'username',
            ),
            'uri' => '#users/teacher_profile_data',
            'params' => array(
                'id',
            ),
            'data-toggle' => 'modal',
            'data-target' => '#ProfileView'
        ));
        $this->mapperlib->add_option('delete', array(
            'title' => array(
                'base' => 'Delete',
                'field' => 'username',
            ),
            'uri' => 'users/delete',
            'params' => array(
                'id',
            ),
            'data-toggle' => '',
            'data-target' => ''
        ));
        $this->mapperlib->add_option('reset_pwd', array(
            'title' => array(
                'base' => 'Reset Pwd',
                'field' => 'username',
            ),
            'uri' => 'users/reset_password_teacher',
            'params' => array(
                'id',
            ),
            'data-toggle' => '',
            'data-target' => ''
        ));

        $data = new stdClass();

        $this->mapperlib->set_model($this->teacher_model);
        $data->table = $this->mapperlib->generate_table(true);

        $data->count_teacher = $this->teacher_model->getFoundRows();

        $data->content = $this->prepareView('x_users', 'teachers', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function teachers_export()
    {
        $this->teacher_model->set_order_by(PropUserPeer::FIRST_NAME);
        $this->teacher_model->set_order_by_direction(Criteria::ASC);
        $teachers = $this->teacher_model->getList();

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("ClassCompete");
        $objPHPExcel->getProperties()->setLastModifiedBy("ClassCompete");
        $objPHPExcel->getProperties()->setTitle("Teachers export - " . date("Y-m-d"));
        $objPHPExcel->getProperties()->setSubject("Teachers export - " . date("Y-m-d"));
        $objPHPExcel->getProperties()->setDescription("Teachers export - " . date("Y-m-d"));

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Username');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Firstname');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Lastname');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'School');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Publisher');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', '1st Date Purchased');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', '1st Quantity');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', '2nd Date Purchased');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', '2nd Quantity');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', '3rd Date Purchased');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', '3rd Quantity');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Total Purchases');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Total Quantity');

        /**
         * @var $user PropUser
         * @var $teacher PropTeacher
         * @var $order PropTeacherOrder
         */
        foreach ($teachers as $k => $user) {
            $r = $k + 2;

            $schoolId = $user->getPropTeachers()->getFirst()->getSchoolId();
            $school = PropSchoolQuery::create()->findOneBySchoolId($schoolId);
            if (empty($school) === true) {
                $school = new PropSchool();
            }

            $teacher = $user->getPropTeachers()->getFirst();

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $r, $user->getUsername());
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $r, $user->getFirstName());
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $r, $user->getLastName());
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $r, $user->getEmail());
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $r, $school->getName());
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $r, $teacher->getPublisher());

            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $r, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $r, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $r, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $r, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $r, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $r, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $r, $teacher->getTotalPurchases());
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $r, $teacher->getTotalQuantity());

            $ordersToShow = 3;
            $ordersShown = 1;
            // load first 3 orders
            $orders = $teacher->getPropTeacherOrders();
            if ($orders->count() > 0) {
                foreach ($orders as $order) {
                    if ($ordersShown <= $ordersToShow) {
                        switch($ordersShown) {
                            case 1:
                                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $r, $order->getCreatedAt());
                                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $r, $order->getLicenseCount());
                                break;
                            case 2:
                                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $r, $order->getCreatedAt());
                                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $r, '');
                                break;
                            case 3:
                                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $r, $order->getCreatedAt());
                                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $r, $order->getLicenseCount());
                                break;
                        }
                        $ordersShown++;
                    }
                }
            }
        }

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . 'teachers-export-' . date("Y-m-d") . '.xls' . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function statistic()
    {
        $data = new stdClass();

        $data->content = $this->prepareView('x_users', 'statistic');
        $this->load->view(config_item('admin_template'), $data);
    }

    public function addStudent_new()
    {
        $this->users_form(null, true, 'student');
    }

    public function addTeacher_new()
    {
        $this->users_form(null, true, 'teacher');
    }

    public function edit($id)
    {
        $user_type = $this->users_model->get_user_type_by_id($id);
        $user = $this->users_model->get_user_by_id($id);

        $this->users_form($user, false, $user_type);
    }

    public function users_form(PropUsers $users = null, $add_new = false, $user_type = false)
    {

        $data = new stdClass();
        if (is_object($users)) {
            $_POST = array(
                'username' => $users->getLogin(),
                'password' => $users->getPassword(),
                'first_name' => $users->getFirstName(),
                'last_name' => $users->getLastName(),
                'email' => $users->getEmail()
            );
            $flashdata = $this->session->flashdata('admin-' . $users->getUserId());
            if (empty($flashdata) === false) {
                $_POST = array_merge($_POST, $flashdata);
            }
        } else {
            $_POST = $this->session->flashdata('admin-');
        }
        $data->user = $users;
        $data->add_new = $add_new;

        if ($user_type != false) {
            $data->user_type = $user_type;
        }
        $data->content = $this->prepareView('x_users', 'form', $data);
        $this->load->view('form', $data);
    }

    public function save()
    {
        $custom_error = false;

        $user_type = $this->input->post('user');

        $id = $this->input->post('id');

        if ($user_type === 'student') {
            if (stristr(strtolower($this->input->post('username')), strtolower($this->input->post('first_name'))) != false) {
                $custom_error = true;
            }
            if (stristr(strtolower($this->input->post('username')), strtolower($this->input->post('last_name'))) != false) {
                $custom_error = true;
            }
        }

        if ($this->form_validation->run('user') === false || $custom_error === true) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        //check if username and email unique
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $is_unique = $this->users_model->is_unique_username_and_email($username, $email, $id);

        if (empty($id) == true) {
            if ($is_unique === false) {
                $this->notificationlib->set('Username and/or email addres already exist', Notificationlib::NOTIFICATION_TYPE_FAILURE);
                $this->session->set_flashdata('user-' . $id, $_POST);
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
        $data = new stdClass();

        if (empty($id) === true) {
            $password = $this->adminlib->generatePassword();
            $data->password = md5($password);
        }
        $data->username = $this->input->post('username');
        $data->first_name = $this->input->post('first_name');
        $data->last_name = $this->input->post('last_name');
        $data->email = $this->input->post('email');
        $data->user_type = $this->input->post('user');
        if (empty($_FILES) === false && $_FILES['image']['size'] > 0) {
            $fp = fopen($_FILES['image']['tmp_name'], 'r');
            $data->image_thumb = base64_encode(fread($fp, filesize($_FILES['image']['tmp_name'])));
            fclose($fp);
        }

        switch ($data->user_type) {
            case 'student':
                $t_dob_year = $this->input->post('t_dob_year');
                if (empty($t_dob_year) === false) {
                    $dob_year = $this->input->post('t_dob_year');
                    $dob_month = $this->input->post('t_dob_month');
                    $dob_day = $this->input->post('t_dob_day');
                } else {
                    $dob_year = $this->input->post('dob_year');
                    $dob_month = $this->input->post('dob_month');
                    $dob_day = $this->input->post('dob_day');
                }
                if (isset($dob_year) === true && isset($dob_month) === true && isset($dob_day) === true &&
                    empty($dob_year) === false && empty($dob_month) === false && empty($dob_day) === false
                ) {
                    $data->dob = $dob_year . '/' . $dob_month . '/' . $dob_day;
                }

                $data->parent_email = $this->input->post('parent_email');
                $user = $this->users_model->save($data, $id);

                if (ENVIRONMENT != 'development' && empty($id)) {

                    /** check if student less then 13 and send proper mail to parent */
                    $stud_brt_data = $dob_month . '/' . $dob_day . '/' . $dob_year;
                    $birthDate = explode("/", $stud_brt_data);
                    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                        ? ((date("Y") - $birthDate[2]) - 1)
                        : (date("Y") - $birthDate[2]));
                    if ($age < 13) {
                        $mail_data = new stdClass();
                        $mail_data->parent_mail = $data->parent_email;
                        $this->send_mail_to_parent_student_less_13($mail_data);
                        $this->send_mail_to_new_student(config_item('student_url'), $data, $password);
                    } else {
                        $mail_data = new stdClass();
                        $mail_data->email = $data->email;
                        $mail_data->password = $password;
                        $this->send_mail_to_parent_student_more_13($mail_data);
                    }

                }

                redirect('users/students');
                break;
            case 'teacher':

                $grades = $this->input->post('grade');
                if (isset($grades) === true && empty($grades) === false) {
                    foreach ($grades as $grades => $val) {
                        $data->grades->$grades = $grades;
                    }
                }

                // TODO: fix saving school
                $school_id = $this->input->post('school_id');
                if (isset($school_id) && !empty($school_id)) {
                    $data->school_id = $school_id;
                }

                // TODO: fix saving zip code
                $zip_code = $this->input->post('zip_code');
                if (isset($zip_code) && !empty($zip_code)) {
                    $data->zip_code = $zip_code;
                }

                if (empty($_FILES) === true) {
                    $fp = fopen(X_IMAGES_PATH . '/' . 'profile.png', 'r');
                    $data->image_thumb = base64_encode(fread($fp, filesize(X_IMAGES_PATH . '/' . 'profile.png')));
                    fclose($fp);
                }

                $publisher = $this->input->post('publisher');
                if (isset($publisher) && !empty($publisher)) {
                    $data->publisher = PropTeacherPeer::PUBLISHER_PUBLIC;
                } else {
                    $data->publisher = PropTeacherPeer::PUBLISHER_PRIVATE;
                }

                $user = $this->teacher_model->save($data, $id);
                if (ENVIRONMENT != 'development' && empty($id) === true) {
                    $this->send_mail_to_new_teacher(config_item('teacher_url'), $data, $password);
                }

                redirect('users/teachers');
                break;
            case 'parent':
                if (empty($_FILES) === true) {
                    $fp = fopen(X_IMAGES_PATH . '/' . 'profile.png', 'r');
                    $data->image_thumb = base64_encode(fread($fp, filesize(X_IMAGES_PATH . '/' . 'profile.png')));
                    fclose($fp);
                }

                $user = $this->parent_model->save($data, $id);
                if (ENVIRONMENT != 'development') {
                    $this->send_mail_to_user(config_item('parent_url'), $data, $password);
                }

                redirect('users/parents');
                break;
        }

    }

    /*
     * validation function for save function
     * */

    public function ajax_validation()
    {

        $error = array();

        $this->form_validation->set_error_delimiters('', '');

        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $user_type = $this->input->post('user');
        $id = $this->input->post('id');

        $custom_error = null;


        if ($user_type === 'student') {
            if (stristr(strtolower($this->input->post('username')), strtolower($this->input->post('first_name'))) != false) {
                $custom_error = true;
            }
            if (stristr(strtolower($this->input->post('username')), strtolower($this->input->post('last_name'))) != false) {
                $custom_error = true;
            }
        }

        $is_unique = $this->users_model->is_unique_username_and_email($username, $email, $id);

        if ($this->form_validation->run('user') === false || $custom_error === true || $is_unique === false) {
            if (form_error('username') != '')
                $error['username'] = form_error('username');
            if (form_error('first_name') != '')
                $error['first_name'] = form_error('first_name');
            if (form_error('last_name') != '')
                $error['last_name'] = form_error('last_name');
            if (form_error('email') != '')
                $error['email'] = form_error('email');

            if ($custom_error === true)
                $error['custom'] = 'Username can not contain first or last name';
            if ($is_unique === false)
                $error['unique'] = 'Username or email address already exist';

            $this->output->set_status_header('400');
        } else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));

    }

    /**
     * function for delete user if he do not have asc data
     * @params: user_id
     * @out:
     *  */
    public function delete($user_id)
    {

        if (empty($user_id) === false && isset($user_id) === true) {
            $error = array();
            try {
                $this->teacher_model->delete($user_id);
                $error['passed'] = true;
            } catch (Exception $e) {
                $error['error'] = $e->getMessage();
                $this->output->set_status_header(400);
            }

            $this->output->set_output(json_encode($error));
        } else {
            redirect('users/teachers');
        }
    }

    private function reset_password($user_id)
    {
        $user_data = $this->users_model->get_user_by_id($user_id);

        $new_password = $this->userslib->generatePassword();
        $new_password_md5 = $this->userslib->encodePassword($new_password);

        $user_data->setPassword($new_password_md5);


        $data_for_save = new stdClass();
        $data_for_save->password = $user_data->getPassword();

        $saved = $this->users_model->save($data_for_save, $user_data->getUserId());

        $user_type = $this->users_model->get_user_type_by_id($user_id);

        $data = new stdClass();
        $data->first_name = $user_data->getFirstName();
        $data->last_name = $user_data->getLastName();
        $data->password = $new_password;
        $data->email = $user_data->getEmail();
        $data->user_type = $user_type;

        $this->send_mail_to_user_new_password($data);
    }

    public function reset_password_teacher($user_id)
    {
        $this->reset_password($user_id);
        redirect('users/teachers');
    }

    public function reset_password_parent($user_id)
    {
        $user_data = $this->users_model->get_user_by_id($user_id);

        $new_password = $this->userslib->generatePassword();
        $new_password_md5 = $this->userslib->encodePassword($new_password);

        $data_for_save = new stdClass();
        $data_for_save->password = $new_password_md5;

        $data = new stdClass();
        $data->email = $user_data->getEmail();

        $save_data = new stdClass();
        $save_data->password = $new_password_md5;
        $new_user_data = $this->users_model->save($save_data, $user_id);
        $this->mailerlib->send_mail_to_parent_forgot_password($data, $new_password);
        redirect('users/parents');
    }

    public function reset_password_student($user_id)
    {
        $this->reset_password($user_id);
        redirect('users/students');
    }

    /**
     *
     * Send e-mail to user when password is reset from admin portal
     * */
    private function send_mail_to_user_new_password($data)
    {

        if ($data->user_type === 'teacher') {
            $this->load->library('email');
            $subject = "INFO CLASSCOMPETE Teacher panel";
            $message = $this->load->view('mailer/teacher_password-recovery', $data, true);

            $config['wordwrap'] = false;
            $config['wrapchars'] = false;
            $config['mailtype'] = 'html';
            $config['charset'] = 'UTF-8';
            $this->email->initialize($config);
            // Send email
            $this->email->from('noreply@classcompete.com', 'ClassCompete.com');
            $this->email->to($data->email);
            $this->email->bcc('moreinfo@classcompete.com');
            $this->email->subject($subject);
            $this->email->message($message);

            if (!$this->email->send()) {
                return false;
            }

            return true;
        } else {
            $subject = "INFO CLASSCOMPETE " . $data->user_type . " panel";

            $headers = '';
            $headers .= 'From: info@classcompete.com' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $email = "<p>Hi $data->first_name $data->last_name</p>
                  <p>Your new password is: <strong>$data->password</strong></p>";

            mail($data->email, $subject, $email, $headers);
        }

    }

    /**
     *
     * Send e-mail to user when new one is created
     * */
    private function send_mail_to_user($link_to_site, $data, $password)
    {

        $subject = "INFO CLASSCOMPETE " . $data->user_type . " panel";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>Hi $data->first_name $data->last_name</p>
                    <p>Your account for classcompete $data->user_type panel was created</p>
                    <p>Link to site : $link_to_site</p>
                    <p>Username: <strong>$data->username</strong></p>
                    <p>Password: <strong>$password</strong></p>";
        @mail($data->email, $subject, $email, $headers);
    }

    private function send_mail_to_new_teacher($link_to_site, $data, $password)
    {

        $subject = "INFO CLASSCOMPETE " . $data->user_type . " panel";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>Congratulations!!! You have registered for Class Compete, where your students will improve test taking skills and improve test scores while having fun!</p>
                  <p>To login to the teacher portal please <a href='http://teacher.classcompete.com/'>Click Here</a></p>
                  <p>Username: <strong>$data->username</strong></p>
                  <p>Password: <strong>$password</strong></p>
                  <p><i>Thank you for being part of this trial.</i></p>
                   <p><i>If you would like further information about what Class Compete can offer you and your school please visit our website.
                        <a href='www.classcompete.com'>www.classcompete.com</a>.  By chance if you are receiving this email in error or wish to revoke access to this system,
                        please <a href='mailto:moreinfo@classcompete.com'>moreinfo@classcompete.com</a></i></p>";
        @mail($data->email, $subject, $email, $headers);
    }

    /**
     * Send email to new student
     */
    public function send_mail_to_new_student($link_to_site, $data, $password)
    {
        $subject = "INFO CLASSCOMPETE " . $data->user_type . " panel";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>Congratulations!!! You have registered for Class Compete, where you will improve your test taking skills and improve your test scores while having fun! Take a challenge and see you compete against your friends.</p>
                  <p>You will need a class code to compete. Ask your teacher to register and provide you one to get going. While you are waiting you can take a sample by entering the current month’s name as a class code.</p>
                  <p>Username: <strong>$data->username</strong></p>
                  <p>Your password: <strong>$password</strong></p>
                  <p><i>Thank you for being part of this trial.</i></p>
                  <p><i>If you would like further information about what Class Compete can offer you and your school please visit our website.
                        <a href='www.classcompete.com'>www.classcompete.com</a>.  By chance if you are receiving this email in error or wish to revoke access to this system,
                        please <a href='mailto:moreinfo@classcompete.com'>moreinfo@classcompete.com</a></i></p>";
        @mail($data->email, $subject, $email, $headers);
    }

    public function ajax($id)
    {
        $user = $this->users_model->get_user_by_id($id);

        if (empty($user) === false) {

            $this->load->model('x_users/teacher_model');
            $this->load->model('x_users/parent_model');
            /** @var $user PropUser */
            /** @var $student_data PropStudent */
            $output = new stdClass();
            $output->id = $user->getUserId();
            $output->username = $user->getLogin();
            $output->firstname = $user->getFirstName();
            $output->lastname = $user->getLastName();
            $output->email = $user->getEmail();

            if ($this->parent_model->is_parent($id) === false) {

                /*
             * if user is teacher and we do not have associated data add delete button
             * */
                $asc_data = intval($this->teacher_model->get_associated_data($id));
                if ($asc_data === 0) {
                    $output->asc_data = true;

                    $student_data = $user->getPropStudent();
                    if (empty($student_data) === false) {
                        $output->parent_email = $student_data->getParentEmail();
                        $output->dob = $student_data->getDob();
                    }
                } else {
                    $output->asc_data = false;
                }

            }

            $teacher_info = $this->teacher_model->get_teacher_info($id);
            if (empty($teacher_info) === false) {
                // add grades for teacher and school
                $output->grades = array();
                $grades = $this->teacher_model->get_teacher_grades($teacher_info->getTeacherId());
                foreach ($grades as $grade_key => $grade_val) {
                    if ($grade_val->getGrade() === -2) {
                        $output->grades[$grade_key] = 'pre_k';
                    } else if ($grade_val->getGrade() === -1) {
                        $output->grades[$grade_key] = 'k';
                    } else {
                        $output->grades[$grade_key] = $grade_val->getGrade();
                    }
                }
                if (is_object($teacher_info->getPropSchool())) {
                    $output->zip_code = $teacher_info->getPropSchool()->getZipCode();
                    $output->school_name = $teacher_info->getPropSchool()->getName();
                } else {
                    $output->zip_code = null;
                    $output->school_name = null;
                }
                $output->isPublisher = $teacher_info->getPublisher();
            }

            $this->output->set_output(json_encode($output));
        }
    }

    public function ajax_get_students()
    {
        $students = $this->users_model->getList();

        if (empty($students) === false) {
            $students_array = array();
            foreach ($students as $k => $student) {
                $students_array[$k]['user_id'] = $student->getUserId();
                $students_array[$k]['created'] = $student->getCreated();
                $students_array[$k]['modified'] = $student->getModified();
                $students_array[$k]['login'] = $student->getLogin();
                $students_array[$k]['first_name'] = $student->getFirstName();
                $students_array[$k]['last_name'] = $student->getLastName();
                $students_array[$k]['email'] = $student->getEmail();
            }

            $this->output->set_output(json_encode($students_array));
        }
    }

    /*
    * function to display student image
    * @params: user_id of student
    * @output: image
    * */
    public function display_student_image($user_id = false)
    {
        $content = null;
        if ($user_id) {
            $image = $this->users_model->get_student_image($user_id);
            $this->output->set_header('Content-type: image/png');

            if ($image['avatar_thumbnail'] === null) {
                $fp = fopen(X_IMAGES_PATH . '/' . 'profile.png', 'r');
                $image['avatar_thumbnail'] = base64_encode(fread($fp, filesize(X_IMAGES_PATH . '/' . 'profile.png')));
            }
            $this->output->set_output(base64_decode($image['avatar_thumbnail']));
        }
    }

    public function ajax_student_age_statistics()
    {
        $student_age_statistic = $this->reportlib->student_age_statistic();

        /** format student age statistic for view */
        $students_age = array(array('Name', 'Age'));

        foreach ($student_age_statistic as $student_stat => $val) {
            $students_age[$student_stat + 1][] = $val['name'];
            $students_age[$student_stat + 1][] = $val['age'];
        }

        $this->output->set_output(json_encode($students_age));
    }

    public function ajax_get_total_duration_average_stats()
    {
        $time = $this->report_model->get_average_time_game_app();


        $formatted_time = array(array('Name', 'Student Name'));

        foreach ($time as $k => $v) {
            $formatted_time[$k + 1][] = $v->getPropStudent()->getPropUser()->getFirstName() . ' ' . $v->getPropStudent()->getPropUser()->getLastName();
            $virtual_columns = $v->getVirtualColumns();
            $formatted_time[$k + 1][] = intval($virtual_columns['average_time']);
        }

        $this->output->set_output(json_encode($formatted_time));
    }

    public function ajax_registration_stats()
    {
        $data = new stdClass();
        $data->type = $this->input->post('type');

        $original_date_from = $this->input->post('from');
        $original_date_to = $this->input->post('to');

        $date_from = date("Y/m/d", strtotime($original_date_from));
        $date_to = date("Y/m/d", strtotime($original_date_to));

        $data->from = $date_from;
        $data->to = $date_to;

        switch ($data->type) {
            case 'month':
                $out = $this->reportlib->registration_stats_monthly($data);
                break;
            case 'week':
                $out = $this->reportlib->registration_stats_weekly($data);
                break;
            case 'day':
                $out = $this->reportlib->registration_stats_daily($data);
                break;
        }


        $this->output->set_output(json_encode($out));
    }

    public function ajax_teacher_profile_data()
    {
        $data = new stdClass();

        $teacher_id = $this->input->post('teacher_id');

        $teacher_data = $this->teacher_model->get_teacher_info($teacher_id);
        $teacher_grades = $this->teacher_model->get_teacher_grades($teacher_data->getTeacherId());

        $data->username = $teacher_data->getPropUser()->getLogin();
        $data->firstname = $teacher_data->getPropUser()->getFirstName();
        $data->lastname = $teacher_data->getPropUser()->getLastName();
        $data->email = $teacher_data->getPropUser()->getEmail();
        $school_id = $teacher_data->getSchoolId();

        if ($teacher_data->getSchoolId() != 0 || empty($school_id) === false) {
            $data->school = $teacher_data->getPropSchool()->getName();
        } else {
            $data->school = "Didn't assigned school!";
        }


        $data->grade = '';
        foreach ($teacher_grades as $grade => $val) {
            switch ($val->getGrade()) {
                case -2:
                    $data->grade .= 'Pre K, ';
                    break;
                case -1:
                    $data->grade .= 'K, ';
                    break;
                case 1:
                    $data->grade .= '1, ';
                    break;
                case 2:
                    $data->grade .= '2, ';
                    break;
                case 3:
                    $data->grade .= '3, ';
                    break;
                case 4:
                    $data->grade .= '4, ';
                    break;
                case 5:
                    $data->grade .= '5, ';
                    break;
                case 6:
                    $data->grade .= '6, ';
                    break;
                case 7:
                    $data->grade .= '7, ';
                    break;
                case 8:
                    $data->grade .= '8, ';
                    break;
            }
        }
        if (empty($data->grade) === true) {
            $data->grade = "Didn't assigned grades!";
        }
        $this->output->set_output(json_encode($data));
    }

    private function send_mail_to_parent_student_less_13($data)
    {
        $subject = "INFO CLASSCOMPETE";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>Your child has signed up for Class Compete. We are a new educational gaming software that helps your child improve on test taking skills. </p>
                                   <p>The outcome of this unique product is a heightened experience your children while they improve their academic performance. In recent studies, children who combine teaching with gaming improve their test results by 42% over those who do not!!! With the new Common Core Standards students have an increased demand on academics as well as time sensitive computer based testing. Class Compete will Super Charge their test taking skills</p>
                                   <p>For this limited time trial period, please do the following:</p>
                                   <p>1. Signup Student : <a href='http://www.classcompete.com/#students-login'>http://www.classcompete.com/#students-login</a></p>
                                   <p>2. Login to Parent Portal and associate your student under “Manage” tab. </p>
                                   <p>3. Class Codes: After registering enter the following codes for the trial.</p>
                                   <p style='margin-left: 20px'><i>  *Note: try a grade down and up depending on your students skill*</i></p>
                                   <p style='margin-left: 25px'>      a. First Grade Trial Code:	 trymath1</p>
                                   <p style='margin-left: 25px'>      b. Second Grade Trial Code: trymath2</p>
                                   <p style='margin-left: 25px'>      c. Third Grade Trial Code: trymath3</p>
                                   <p style='margin-left: 25px'>      c. Fourth Grade Trial Code: trymath4</p>
                                   <p style='margin-left: 25px'>      c. Fifth Grade Trial Code: trymath5</p>
                                   <p style='margin-left: 25px'>      c. Sixth Grade Trial Code: trymath6</p>
                                   <p style='margin-left: 25px'>      c. Seventh Grade Trial Code: Coming Soon!</p>
                                   <p style='margin-left: 25px'>      c. Eighth Grade Trial Code: Coming Soon!</p>
                                   <p>4. Results: See your Student Performance (<a href='http://parent.classcompete.com/#/login'>Login</a>)</p>
                                   <p><i>Thank you for being part of this trial. </i></p>
                                   <p><i>If you would like further information about what Class Compete can offer you and your school please visit our website.
                                   <a href='www.classcompete.com'>www.classcompete.com</a>.  By chance if you are receiving this email in error or wish to revoke access for your child to this system, please <a href='mailto:moreinfo@classcompete.com'>moreinfo@classcompete.com</a></i></p>";


        @mail($data->parent_mail, $subject, $email, $headers);
    }

    private function send_mail_to_parent_student_more_13($data)
    {
        $subject = "INFO CLASSCOMPETE ";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>Congratulations!!! You have registered for Class Compete, where you will improve your test taking skills and improve your test scores while having fun! Take a challenge and see you compete against your friends.</p>
                 <p>You will need a class code to compete. Ask your teacher to register and provide you one to get going. While you are waiting you can take a sample by entering the current month’s name as a class code.</p>
                 <p>Your password: <strong>$data->password</strong></p>
                 <p><i>Thank you for being part of this trial. </i></p>
                 <p><i>If you would like further information about what Class Compete can offer you and your school please visit our website.
                 <a href='www.classcompete.com'>www.classcompete.com</a>.  By chance if you are receiving this email in error or wish to revoke access for your child to this system, please <a href='mailto:moreinfo@classcompete.com'>moreinfo@classcompete.com</a></i></p>";
        @mail($data->email, $subject, $email, $headers);
    }

}