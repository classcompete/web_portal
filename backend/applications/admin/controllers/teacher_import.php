<?php

class Teacher_import extends MY_Controller {

    public function __construct() {
        parent::__construct();
	    $this->load->library('x_users/teacherlib');
	    $this->load->model('x_users/teacher_import_model');
    }

    public function index() {
	    $data = new stdClass();
        //$data->imports = PropTeacherImportQuery::create()->orderById(Criteria::DESC)->find();
	    $this->teacher_import_model->setOrderBy(PropTeacherImportPeer::ID);
	    $this->teacher_import_model->setOrderByDirection(Criteria::DESC);
	    $data->imports = $this->teacher_import_model->getList();

        $data->content = $this->load->view('teacher_import/index', $data, true);
	    $this->load->view(config_item('admin_template'), $data);
    }

	/**
	 * Save teacher import record and file for import in db
	 */
    public function save() {
        $name = $this->input->post('name');

        if ($_FILES['file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file']['tmp_name'])) {
            $file = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
        }
        else { $file = ''; }

            //Create teacher import record
        $data = new stdClass();
        $data->name = $name;
        $data->file = $file;
        $this->teacher_import_model->save($data);

        redirect('teacher_import');
    }

	/**
	 * Do actuall importing of teachers from uploaded spreadsheet file
	 * @param $importId
	 */
    public function do_import($importId) {
        $this->load->library('x_users/teacherimportlib', null, 'importer');
        $teachers = $this->importer->import($importId);

	    /*foreach ($teachers as $t) {
		    echo $t->firstName . ' - ' . $t->lastName . ' - ' . $t->email . ' - ' . $t->username . '<br/>';
	    }*/

        foreach ($teachers as $t) {
			$password = $this->teacherlib->generatePassword();

	        $teacherData = new stdClass();
	        $teacherData->first_name = $t->firstName;
	        $teacherData->last_name = $t->lastName;
	        $teacherData->email = $t->email;
	        $teacherData->password = $this->teacherlib->encodePassword($password);
			$teacherData->username = $t->username;
	        $teacherData->import_id = $t->importId;
	        $this->teacher_model->save($teacherData);

	            //Send welcome email to teacher
	        $this->send_mail_to_new_teacher(config_item('teacher_url'), $teacherData, $password);

	            //Add to MailChimp teachers list
	        $this->load->library('mailchimp/mailchimplib');
	        $this->mailchimplib->call('lists/subscribe', array(
	            'id' => 'b5309bf6ac',
	            'email' => array(
	                'email' => $teacherData->email
	            ),
	            'merge_vars' => array(
	                'FNAME' => $teacherData->first_name,
	                'LNAME' => $teacherData->last_name
	            ),
	            'double_optin' => false,
	            'update_existing' => true,
	            'replace_interests' => false,
	            'send_welcome' => false,
	        ));

        }

        redirect('teacher_import');
    }

	/**
	 * Send welcome mail to imported teacher
	 * @param $link_to_site
	 * @param $data
	 * @param $password
	 */
    private function send_mail_to_new_teacher($link_to_site, $data, $password) {
        $subject = "INFO CLASSCOMPETE teacher panel";

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
	 * Delete teacher import record
	 * @param $id
	 * @throws Exception
	 * @throws PropelException
	 */
    public function delete($id) {
        PropTeacherImportQuery::create()->filterById($id)->delete();
        redirect('teacher_import');
    }
}