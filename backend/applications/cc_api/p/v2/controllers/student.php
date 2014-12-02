<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/4/14
 * Time: 12:20 PM
 */
class Student extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('x_user/studentlib');
        $this->load->library('x_user/userlib');
        $this->load->library('x_class/classlib');
        $this->load->library('x_game_api/gameapilib');
        $this->load->library('form_validation');


        if(!ParentHelper::isParent()){
            $this->response(null,401);
        }
    }

    public function index_get(){

        $respond = array();

        $this->parent_student_model->filterByParentId(ParentHelper::getId());
        $students = $this->parent_student_model->getList();
        $studentsLength = $this->parent_student_model->getFoundRows();

        for($i = 0; $i < $studentsLength; $i++){
            $tmpStudent = $students[$i];
            $respond[$i]['studentId'] = $tmpStudent->getStudentId();
            $respond[$i]['firstName'] = $tmpStudent->getPropStudent()->getPropUser()->getFirstName();
            $respond[$i]['lastName'] = $tmpStudent->getPropStudent()->getPropUser()->getLastName();
            $respond[$i]['birthday'] = date('m/d/y', strtotime($tmpStudent->getPropStudent()->getDob()));
            $respond[$i]['email'] = $tmpStudent->getPropStudent()->getPropUser()->getEmail();
            $respond[$i]['username'] = $tmpStudent->getPropStudent()->getPropUser()->getLogin();
            $respond[$i]['grade'] =$tmpStudent->getPropStudent()->getGradeId();
            $respond[$i]['gender'] = $tmpStudent->getPropStudent()->getGender();
            $respond[$i]['boughtLicence'] = $this->class_student_model->getClassByBoughtLicence($tmpStudent->getStudentId());
        }

        $this->response($respond, 200);
    }

    public function id_put($studentId){
        $_POST = $this->put();
        $errorData = array();
        $studentDb = $this->student_model->getStudent($this->put('studentId'));

        $this->form_validation->set_rules('firstName','First ame', 'required|min_length[3]');
        $this->form_validation->set_rules('lastName','Last name', 'required|min_length[3]');
        $this->form_validation->set_rules('email','Email', 'required|valid_email');
        $this->form_validation->set_rules('username','Username', 'required|min_length[6]');
        $this->form_validation->set_rules('grade','Grade', 'required');
        $this->form_validation->set_rules('birthday','Birthday', 'required');

        $password = $this->put('password');
        $retypePassword = $this->put('retypePassword');
        if(isset($password) && !empty($password) || isset($retypePassword) && !empty($retypePassword)){
            $this->form_validation->set_rules('password','Password', 'required|min_length[6]');
            $this->form_validation->set_rules('retypePassword','Password', 'required|min_length[6]|matches[password]');
        }

        if($this->form_validation->run() == false){
            if(form_error('firstName')!='')$errorData['firstName'] = form_error('firstName');
            if(form_error('lastName')!='')$errorData['lastName'] = form_error('lastName');
            if(form_error('email')!='')$errorData['email'] = form_error('email');
            if(form_error('username')!='')$errorData['username'] = form_error('username');
            if(form_error('grade')!='')$errorData['grade'] = form_error('grade');
            if(form_error('birthday')!='')$errorData['birthday'] = form_error('birthday');
            if(form_error('password')!='')$errorData['password'] = form_error('password');
            if(form_error('birthday')!='')$errorData['birthday'] = form_error('birthday');
            $this->response($errorData,400);
        }

        // *** check if username is unique
        $userDb = $this->user_model->getUserByUserName($this->put('username'));

        if(!empty($userDb) && $userDb->getUserId() != $studentDb->getUserId()){
            $errorData['username'] = 'Username is already taken!';
        }

        // *** check if email is unique
        $userDb = $this->user_model->getUserByEmail($this->put('email'));
        if(!empty($userDb) && $userDb->getUserId() != $studentDb->getUserId()){
            $errorData['email'] = 'Email is already taken!';
        }

        if(stristr(strtolower($this->put('username')), strtolower($this->put('firstName'))) != false){
            $errorData['usernameFLName'] = 'Username can not be similar with First name';
        }else if(stristr(strtolower($this->put('username')), strtolower($this->put('lastName'))) != false){
            $errorData['usernameFLName'] = 'Username can not be similar with Last name';
        }

        if(!empty($errorData)){
            $this->response($errorData, 400);
        }

        // *** update student table
        $student = new stdClass();
        $student->dob = $this->put('birthday');
        $student->gradeId = $this->put('grade');
        $student->gender = $this->put('gender') === PropStudentPeer::GENDER_FEMALE ? PropStudentPeer::GENDER_FEMALE : PropStudentPeer::GENDER_MALE;
        $savedStudent = $this->student_model->save($student, $studentId);

        // *** update users table
        $user = new stdClass();
        $user->firstName = $this->put('firstName');
        $user->lastName = $this->put('lastName');
        $user->email = $this->put('email');
        $user->username = $this->put('username');

        if(isset($password) && !empty($password)){
            $user->password = $this->studentlib->createMysqlPassword($this->put('password'));
        }

        $savedUser = $this->user_model->save($user, $savedStudent->getUserId());


        $this->response(null,200);
    }

    public function index_post(){
        $students = $this->post();
        $studentsLength= count($students);
        $error = array();

        if($studentsLength === 0)
            $this->response(null,200);

        // loop true each student and check username and email
        for($i = 0; $i < $studentsLength; $i++){

            if($this->userlib->isUniqueUsername($students[$i]['username']) == false){
                $error['username'] = 'Username for student '. ($i + 1) . " is already taken!";
            }

            if($this->userlib->isUniqueEmail($students[$i]['email']) === false){
                $error['email'] = 'Email for student '.($i +1) . " is already taken!";
            }

            if(stristr(strtolower($students[$i]['username']), strtolower($students[$i]['firstName'])) != false){
                $error['usernameFLName'] = 'Username can not be similar with First name';
            }else if(stristr(strtolower($students[$i]['username']), strtolower($students[$i]['lastName'])) != false){
                $error['usernameFLName'] = 'Username can not be similar with Last name';
            }

            if(!empty($error)){
                $this->response($error, 400);
            }
        }


        // prepare data for game api, send it to end point, and manual update missing fields

        $data = array();
        for($i = 0; $i < $studentsLength; $i ++){
            $data['login'] = $students[$i]['username'];
            $data['password'] = $students[$i]['password'];
            $data['firstName'] = $students[$i]['firstName'];
            $data['lastName'] = $students[$i]['lastName'];
            $data['email'] = $students[$i]['email'];
            $data['dob'] = $students[$i]['birthday'];

            // check if user is less then 12 and add parentEmail
            $_age = floor( (strtotime(date('Y-m-d')) - strtotime($students[$i]['birthday'])) / 31556926);

            if($_age < floatval(12)){
                $data['parentEmail'] = ParentHelper::getEmail();
            }else{
                unset($data['parentEmail']);
            }


            // generate xml
            $registerRequestXML = $this->gameapilib->generateXML('generateXML', $data);

            // Send data to game api to register
            if(ENVIRONMENT === 'production'){
                if (!$this->gameapilib->post("/classcompete/api/auth/register/", array(), $registerRequestXML)) {
                    return false;
                }
            }

            // JUST FOR TESTING FUNCTIONALITY IF ENV IS DEV OR TESTING
            if (ENVIRONMENT === 'testing' || ENVIRONMENT === 'development') {
                // add to student table, users table
                $userData = new stdClass();
                $userData->username = $data['login'];
                $userData->password = $data['password'];
                $userData->firstName = $data['firstName'];
                $userData->lastName = $data['lastName'];
                $userData->email = $data['email'];

                $userData = $this->user_model->save($userData);

                $studentData = new stdClass();
                $studentData->userId = $userData->getUserId();
                $studentData->dob = $data['dob'];
                $studentData->studentId = $this->studentlib->getNextStudentId();
                
                if(isset($data['parentEmail'])){
                    $studentData->parentEmail = $data['parentEmail'];
                }
                $studentData = $this->student_model->save($studentData);
            }

        }

        // get default male student data for updating student table
        $defMaleStudent = $this->studentlib->getDefaultMaleStudentData();
        // get default male student data for updating student table
        $defFemaleStudent = $this->studentlib->getDefaultFemaleStudentData();
        // get inserted data and update missing fields and parent_student_table;
        $assignedStudents = array();
        for($i = 0; $i < $studentsLength; $i ++){
            // get user data of inserted student;
            $newUser = $this->user_model->getUserByUserName($students[$i]['username']);
            $newStudent = $this->student_model->getStudentByUserId($newUser->getUserId());

            $updateStudent = new stdClass();
            $updateStudent->gradeId = $students[$i]['grade'];
            $updateStudent->gender = $students[$i]['gender'] === PropStudentPeer::GENDER_MALE ? PropStudentPeer::GENDER_MALE : PropStudentPeer::GENDER_FEMALE;

            if($updateStudent->gender === PropStudentPeer::GENDER_MALE){
                $updateStudent->avatarSettings = $defMaleStudent->getAvatarSettings();
                $updateStudent->avatarImage = $defMaleStudent->getAvatarImage();
                $updateStudent->avatarThumbnail = $defMaleStudent->getAvatarThumbnail();
            }else{
                $updateStudent->avatarSettings = $defFemaleStudent->getAvatarSettings();
                $updateStudent->avatarImage = $defFemaleStudent->getAvatarImage();
                $updateStudent->avatarThumbnail = $defFemaleStudent->getAvatarThumbnail();
            }


            $this->student_model->save($updateStudent, $newStudent->getStudentId());

            // add relation between parent and student
            $parentID = ParentHelper::getId();

            $parentStudent = new stdClass();
            $parentStudent->parentId = $parentID;
            $parentStudent->studentId = $newStudent->getStudentId();
            $connection = $this->parent_student_model->save($parentStudent);

            $assignedStudents[] = $connection->toJSON();
        }

        $this->response(null, 200);
    }

    public function id_post(){
        $error = array();
        $_POST = $this->post();

        if($this->form_validation->run('parent.add-new-student') === false){
            if(form_error('firstName')!='')$error['firstName'] = form_error('firstName');
            if(form_error('lastName')!='')$error['lastName'] = form_error('lastName');
            if(form_error('email')!='')$error['email'] = form_error('email');
            if(form_error('birthday')!='')$error['birthday'] = form_error('birthday');
            if(form_error('grade')!='')$error['grade'] = form_error('grade');
            if(form_error('password')!='')$error['password'] = form_error('password');
            if(form_error('retypePassword')!='')$error['retypePassword'] = form_error('retypePassword');

            $this->response($error, 400);
        }

        if($this->userlib->isUniqueUsername($this->post('username')) == false){
            $error['username'] = 'Username is already taken!';
        }

        if($this->userlib->isUniqueEmail($this->post('email')) === false){
            $error['email'] = 'Email for student is already taken!';
        }

        if(stristr(strtolower($this->post('username')), strtolower($this->post('firstName'))) != false){
            $error['usernameFLName'] = 'Username can not be similar with First name';
        }else if(stristr(strtolower($this->post('username')), strtolower($this->post('lastName'))) != false){
            $error['usernameFLName'] = 'Username can not be similar with Last name';
        }

        if(!empty($error)){
            $this->response($error, 400);
        }

        $data = array();
        $data['login'] = $this->post('username');
        $data['password'] = $this->post('password');
        $data['firstName'] = $this->post('firstName');
        $data['lastName'] = $this->post('lastName');
        $data['email'] = $this->post('email');
        $data['dob'] = $this->post('birthday');
        // check if user is less then 12 and add parentEmail
        $_age = floor( (strtotime(date('Y-m-d')) - strtotime($this->post('birthday'))) / 31556926);

        if($_age < floatval(12)){
            $data['parentEmail'] = ParentHelper::getEmail();
        }else{
            unset($data['parentEmail']);
        }


        // generate xml
        $registerRequestXML = $this->gameapilib->generateXML('generateXML', $data);

        // Send data to game api to register
        if(ENVIRONMENT === 'production'){
            if (!$this->gameapilib->post("/classcompete/api/auth/register/", array(), $registerRequestXML)) {
                return false;
            }
        }

        // JUST FOR TESTING FUNCTIONALITY IF ENV IS DEV OR TESTING
        if (ENVIRONMENT === 'testing' || ENVIRONMENT === 'development') {
            // add to student table, users table
            $userData = new stdClass();
            $userData->username = $data['login'];
            $userData->password = $data['password'];
            $userData->firstName = $data['firstName'];
            $userData->lastName = $data['lastName'];
            $userData->email = $data['email'];

            $userData = $this->user_model->save($userData);

            $studentData = new stdClass();
            $studentData->userId = $userData->getUserId();
            $studentData->dob = $data['dob'];
            $studentData->studentId = $this->studentlib->getNextStudentId();
            if(isset($data['parentEmail'])){
                $studentData->parentEmail = $data['parentEmail'];
            }
            $studentData = $this->student_model->save($studentData);
        }


        // get default user data for updating student table base on gender
        if($this->post('gender') === PropStudentPeer::GENDER_MALE){
            $defStudent = $this->studentlib->getDefaultMaleStudentData();
        }else{
            $defStudent = $this->studentlib->getDefaultFemaleStudentData();
        }
        // get inserted data and update missing fields and parent_student_table;

        // get user data of inserted student;
        $newUser = $this->user_model->getUserByUserName($this->post('username'));
        $newStudent = $this->student_model->getStudentByUserId($newUser->getUserId());

        $updateStudent = new stdClass();
        $updateStudent->gradeId = $this->post('grade');
        $updateStudent->avatarSettings = $defStudent->getAvatarSettings();
        $updateStudent->avatarImage = $defStudent->getAvatarImage();
        $updateStudent->avatarThumbnail = $defStudent->getAvatarThumbnail();
        $updateStudent->gender = $this->post('gender') === PropStudentPeer::GENDER_MALE ? PropStudentPeer::GENDER_MALE : PropStudentPeer::GENDER_FEMALE;
        $this->student_model->save($updateStudent, $newStudent->getStudentId());

        // add relation between parent and student
        $parentID = ParentHelper::getId();

        $parentStudent = new stdClass();
        $parentStudent->parentId = $parentID;
        $parentStudent->studentId = $newStudent->getStudentId();
        $this->parent_student_model->save($parentStudent);

        $respond = array();
        $respond['studentId'] = $newStudent->getStudentId();
        $respond['firstName'] = $newStudent->getPropUser()->getFirstName();
        $respond['lastName'] = $newStudent->getPropUser()->getLastName();
        $respond['birthday'] = date('m/d/y', strtotime($newStudent->getDob()));
        $respond['email'] = $newStudent->getPropUser()->getEmail();
        $respond['username'] = $newStudent->getPropUser()->getLogin();
        $respond['grade'] = $newStudent->getGradeId();
        $respond['gender'] = $newStudent->getGender();

        $this->response($respond);
    }

    protected function connection_post(){
        $_POST = $this->post();
        $error = array();

        if($this->form_validation->run('parent.add-student-connection') === false){
            if(form_error('username')!='')$error['username'] = form_error('username');
            if(form_error('password')!='')$error['password'] = form_error('password');

            $this->response($error, 400);
        }
        $username = $this->post('username');
        $password = $this->post('password');
        // check if we have user with provided data
        $user = $this->user_model->getStudentByUsernamePasswordSql($username, $password);

        if(empty($user)){
            $error['student'] = 'Wrong username/password';
            $this->response($error, 400);
        }
        // check if user is student
        $student = $this->student_model->getStudentByUserId($user->user_id);
        if(empty($student)){
            $error['student'] = 'We do not have student register with this credentials!';
            $this->response($error, 400);
        }
        // we have valid credentials and valid student, add it to parent student connection and return student data
        $parentStudentData = new stdClass();
        $parentStudentData->parentId = ParentHelper::getId();
        $parentStudentData->studentId = $student->getStudentId();

        $newParentStudent = $this->parent_student_model->save($parentStudentData);

        $respond = array();
        $respond['studentId'] = $student->getStudentId();
        $respond['firstName'] = $student->getPropUser()->getFirstName();
        $respond['lastName'] = $student->getPropUser()->getLastName();
        $respond['birthday'] = $student->getDob();
        $respond['email'] = $student->getPropUser()->getEmail();
        $respond['username'] = $student->getPropUser()->getLogin();
        $respond['grade'] =$student->getGradeId();
        $respond['gender'] = $student->getGender();

        $this->response($respond, 200);
    }
}