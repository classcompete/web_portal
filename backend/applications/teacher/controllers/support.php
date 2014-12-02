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
                'answer' => 'Class Compete works on almost every device. Currently we can be found on: Apple IPad,
                any Android Device, Kindle Fire and any computer browser.',
            ),
            array(
                'question' => 'What does Class Compete Do?',
                'answer' => 'Our goal is to improve student scores. We do this by making them practice test taking
                skills doing what they love best: Gaming.',
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
        );


        $data = new stdClass();
        $data->questions = $questions;
        $data->content = $this->load->view('support/home', $data, true);
        $this->load->view('compete', $data);
    }

    public function sendMail()
    {
        $this->load->library('mailer/mailerlib');

        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $message = $this->input->post('message');

        $mailData = new stdClass();
        $mailData->name = $name;
        $mailData->email = $email;
        $mailData->message = $message;
        $this->mailerlib->sendSupportComment($mailData);

        redirect('/support/?sent=ok');
    }
}