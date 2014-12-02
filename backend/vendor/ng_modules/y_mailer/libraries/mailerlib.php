<?php
class Mailerlib
{

    private $ci;

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->helper('y_mailer/mailer');
    }

    /**
     *
     * Send e-mail to user when new one is created
     * */
    public function send_mail_to_user($link_to_site, $data, $password)
    {

        $subject = "INFO CLASSCOMPETE Admin panel";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email = "<p>Hi $data->first_name $data->last_name</p>" .
            "<p>Your password for classcompete admin panel was changed</p>" .
            "<p>Link to site : $link_to_site</p>" .
            "<p>New password: <strong>$password</strong></p>";
        @mail($data->email, $subject, $email, $headers);
    }

    public function send_mail_to_subscriber($data)
    {
        $random_hash = md5(date('r', time()));

        $subject = "CLASSCOMPETE Subscriber";

        $headers = '';
        $headers .= 'From: ' . $data->from_email . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        ob_start();
        ?>
        <p>Hello</p>
        <p>Successfully subscribed</p>

        <?php if (empty($data->attachment) === false): ?>

        <?php $attachment = chunk_split(base64_encode(file_get_contents($data->attachment))); ?>

        --PHP-mixed-<?php echo $random_hash; ?>
        Content-Type: application/zip; name="<?php echo $data->attachment ?>"
        Content-Transfer-Encoding: base64
        Content-Disposition: attachment

        <?php echo $attachment; ?>

        --PHP-mixed-<?php echo $random_hash; ?>--

        <?php endif; ?>

        <?php
        $email = ob_get_clean();

        @mail($data->to_email, $subject, $email, $headers);
    }

    public function sent_mail_to_address($data){
        $this->ci->load->library('email');

        $this->ci->email->from($data->from_email, $data->from_name);
        $this->ci->email->to($data->to_email);

        $this->ci->email->subject($data->subject);
        $this->ci->email->message($data->message);

        if(isset($data->attachment_url) === true)
            $this->ci->email->attach($data->attachment_url);

        @$this->ci->email->send();
    }

    public function send_mail_to_new_register_parent($email){
        $subject = "INFO CLASSCOMPETE Parent panel";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $message = "<p>Congratulations!!! You have registered for Class Compete, where your students will improve test taking skills and improve test scores while having fun!</p>
                  <p>To login to the parent portal please <a href='http://parent.classcompete.com'>Click Here</a></p>
                  <p><i>Thank you for being part of this trial.</i></p>
                  <p><i>If you would like further information about what Class Compete can offer you and your school please visit our website. <a href='www.classcompete.com'>www.classcompete.com</a>.
                  By chance if you are receiving this email in error or wish to revoke access to this system, please email: <a href='mailto:moreinfo@classcompete.com'>moreinfo@classcompete.com</a></i></p>";
        @mail($email, $subject, $message, $headers);
    }

    public function send_mail_to_parent_forgot_password($data,$password){
        $subject = "INFO CLASSCOMPETE Admin panel";

        $headers = '';
        $headers .= 'From: info@classcompete.com' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $message = "<p>You have requested your password for Class Compete to be reset. Please see below for your current password and try to login again. If you still have problems please email: <a href='mailto:moreinfo@classcompete.com'>moreinfo@classcompete.com</a></p>
                    <p>Your new password: <strong>$password</strong></p>";
        @mail($data->email, $subject, $message, $headers);
    }

}