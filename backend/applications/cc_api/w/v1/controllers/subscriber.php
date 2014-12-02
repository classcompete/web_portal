<?php
class Subscriber extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('y_subscriber/subscriberlib');
        $this->load->library('y_mailer/mailerlib');

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
    }

    public function index_post()
    {
        $_POST = $this->post();
        $error = array();

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[subscriber.email]');

        if ($this->form_validation->run() === false) {
            if (form_error('email') != '') {
                $error['email'] = form_error('email');
            }
            $this->response($error, 400);
        } else {
            $data = new stdClass();
            $data->email = $this->post('email');

            $subscriber = $this->subscriber_model->save($data);

            //sent email to subscriber
            $mail_data = new stdClass();
            $mail_data->from_email = 'info@classcompete.com';
            $mail_data->from_name = 'Info Class Compete';
//            $mail_data->attachment = '';
            $mail_data->to_email = $data->email;
            $mail_data->subject = 'Class Compete';
            $mail_data->message = "";
//            $this->mailerlib->sent_mail_to_address($mail_data);

            $headers = '';
            $headers .= 'From: info@classcompete.com' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $email = "<p>Your child has signed up for Class Compete. We are a new educational gaming software that helps your child improve on test taking skills. </p>
                                   <p>The outcome of this unique product is a heightened experience your children while they improve their academic performance. In recent studies, children who combine teaching with gaming improve their test results by 42% over those who do not!!! With the new Common Core Standards students have an increased demand on academics as well as time sensitive computer based testing. Class Compete will Super Charge their test taking skills</p>
                                   <p>For this limited time trial period, please do the following:</p>
                                   <p>1. Signup: (<a href='https://itunes.apple.com/ca/app/class-compete/id723816000'>Click To Download on IPad</a>) or (<a href='http://student.classcompete.com/'>Click to Website Version</a>)</p>
                                   <p>2. Class Codes: After registering enter the following codes for the trial.</p>
                                   <p style='margin-left: 20px'><i>  *Note: try a grade down and up depending on your students skill*</i></p>
                                   <p style='margin-left: 25px'>      a. First Grade Trial Code:	 trymath1</p>
                                   <p style='margin-left: 25px'>      b. Second Grade Trial Code: trymath2</p>
                                   <p style='margin-left: 25px'>      c. Third Grade Trial Code: trymath3</p>
                                   <p style='margin-left: 25px'>      c. Fourth Grade Trial Code: trymath4</p>
                                   <p style='margin-left: 25px'>      c. Fifth Grade Trial Code: trymath5</p>
                                   <p style='margin-left: 25px'>      c. Sixth Grade Trial Code: Coming Soon!</p>
                                   <p style='margin-left: 25px'>      c. Seventh Grade Trial Code: Coming Soon!</p>
                                   <p style='margin-left: 25px'>      c. Eighth Grade Trial Code: Coming Soon!</p>
                                   <p>3. Track: If you would like to track your student, associate your account with your student(s): (<a href='http://www.classcompete.com/#parent-login'>Signup Here</a>)</p>
                                   <p>4. Results: See your Student Performance (<a href='http://parent.classcompete.com/#/login'>Login</a>)</p>
                                   <p><i>Thank you for being part of this trial. </i></p>
                                   <p><i>If you would like further information about what Class Compete can offer you and your school please visit our website.
                                   <a href='www.classcompete.com'>www.classcompete.com</a>.  By chance if you are receiving this email in error or wish to revoke access for your child to this system, please <a href='mailto:moreinfo@classcompete.com'>moreinfo@classcompete.com</a></i></p>";
            @mail($data->email, $mail_data->subject, $email, $headers);

            $out = array('message' => 'Email ' . $data->email . ' has been successfully submitted.');
            $this->response($out);
        }
    }
}