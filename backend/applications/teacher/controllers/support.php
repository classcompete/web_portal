<?php

class Support extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
    }

    public function index()
    {
        $questions = array(
            array(
                'question' => 'What Platforms Does this Work On?',
                'answer' => 'Class Compete works on almost every device. Currently we can be found on:
                iPad App (not iPhone), Android App, Kindle Fire App, Desktop Browser',
            ),
            array(
                'question' => 'What does Class Compete Do?',
                'answer' => 'Our goal is to improve student scores and improve student grades. We do this by making them
                practice test taking skills doing what they love best: gaming. ',
            ),
            array(
                'question' => 'How did you come up with this idea of gaming and testing?',
                'answer' => 'Over the last 5 years we have had the privilege of tutoring over 100k students in 20 states.
                In this experience we learned that by adding computer technology we were able to improve student
                results 40% at times. We then focused on what type of technology would have the best impact - gaming.
                Class Compete is the simple solution that came out of years of research to improve student scores.',
            ),
            array(
                'question' => 'Do I have to pay for this?',
                'answer' => 'No payment is necessary. We will always provide some samples for free.
                If that helps your students that’s great! If you feel they need more specific help then we will
                have specialized paid content from experts that can help more.',
            ),
            array(
                'question' => 'Do you protect student information?',
                'answer' => '<strong>ABSOLUTELY!</strong> We have attempted to protect all personally identifiable information and adhere
                to Children’s Online Privacy Protection (COPPA).
                Please check our privacy policy and terms and conditions found on our website for further details.',
            ),
            array(
                'question' => 'Who is using this? Where are you located?',
                'answer' => 'We are a US based company, however, we know the world is flat and US kids are competing globally.
                There are students using this product in schools in Asia and Europe. In this new economy your students
                need the ability to compete with everyone, so let them use Class Compete and see how they do!',
            ),
            array(
                'question' => 'I have been hearing about Common Core. Will this help my student?',
                'answer' => 'We do have content aligned to Common Core in the system as well as other content.',
            ),
            array(
                'question' => 'Can I see this data on my mobile device?',
                'answer' => '<strong>YES!</strong> Just bookmark this url and it will work on your mobile device.',
            ),
            array(
                'question' => 'So you are not teaching the students?',
                'answer' => 'No, we believe there is an art in just improving their test taking abilities. That’s what we specialize in.',
            ),
            array(
                'question' => 'Now that I see the issues my student is having can you help more?',
                'answer' => 'Sure just get in touch with us and we can recommend the best solution we think would work for your student.',
            ),
            array(
                'question' => 'When a licensed is purchased then a student has access to whatever challenge is assigned
                them, or is there an additional purchase price for each challenge?',
                'answer' => 'The license fee is per student and it allows them to use any challenge that is publicly
                available in our system as well as any that you custom create. There are no further charges.',
            ),
            array(
                'question' => 'Can teachers create their own challenges?',
                'answer' => 'Absolutely! We know teachers are creative so we allow any teacher to build their own content
                into our system and save them as challenges to be assigned to their classrooms only….for now :).',
            ),
            array(
                'question' => 'Who do students compete against?',
                'answer' => 'Students compete against their counterparts in the classroom they are associated to.
                They do not compete against everyone. We found that students are more interested when they have a
                relative sense who they compete against and they try harder! ',
            ),
            /*
            array(
                'question' => '',
                'answer' => '',
            ),
            */
        );

        $user = PropUserQuery::create()->findOneByUserId(TeacherHelper::getUserId());

        $data = new stdClass();
        $data->questions = $questions;
        $data->user = $user;
        $data->content = $this->load->view('support/home', $data, true);
        $this->load->view('compete', $data);
    }

    public function sendMail()
    {
        $this->load->library('mailer/mailerlib');

        $name = trim($this->input->post('name'));
        $email = trim($this->input->post('email'));
        $message = trim($this->input->post('message'));

        if (empty($name) === true || empty($email) === true || empty($message) === true) {
            redirect('/support/?error=All fields are mandatory');
        }

        $user = PropUserQuery::create()->findOneByUserId(TeacherHelper::getUserId());
        $teacher = PropTeacherQuery::create()->findOneByUserId(TeacherHelper::getUserId());

        // add logged in user data into table below
        $additional = '<table style="width: 100%; border: 1px solid #d5d5d5; background: #f5f5f5">';
        $additional .= '<tr><th colspan="10" style="text-align: left">Logged in user details</th></tr>';
        $additional .= '<tr><td>Full Name:</td><td>' . $user->getFirstName() . ' ' . $user->getLastName() . '</td></tr>';
        $additional .= '<tr><td>Username:</td><td>' . $user->getUsername() . '</td></tr>';
        $additional .= '<tr><td>Email:</td><td>' . $user->getEmail() . '</td></tr>';
        $additional .= '<tr><td>Intro video played:</td><td>' . $teacher->getViewIntro() . '</td></tr>';
        $additional .= '<tr><td>Is Publisher:</td><td>' . $teacher->getPublisher() . '</td></tr>';
        $additional .= '<tr><td>Registered at:</td><td>' . $teacher->getCreated() . '</td></tr>';
        $additional .= '<tr><td>Sent time:</td><td>' . date("Y-m-d H:i:s") . '</td></tr>';
        $additional .= '<tr><td>Sender Public IP:</td><td>' . $_SERVER['REMOTE_ADDR'] . '</td></tr>';
        $additional .= '<tr><td>Proxy Client IP:</td><td>' . @$_SERVER['HTTP_CLIENT_IP'] . '</td></tr>';
        $additional .= '<tr><td>Proxy Client IP:</td><td>' . @$_SERVER['HTTP_X_FORWARDED_FOR'] . '</td></tr>';
        $additional .= '</table>';

        $message .= '<br/>' . $additional;

        $mailData = new stdClass();
        $mailData->name = $name;
        $mailData->email = $email;
        $mailData->message = $message;
        $this->mailerlib->sendSupportComment($mailData);

        redirect('/support/?sent=ok');
    }
}