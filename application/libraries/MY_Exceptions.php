<?
class MY_Exceptions extends CI_Exceptions {

    function __construct()
    {
        parent::__construct();
    }

    function log_exception($severity, $message, $filepath, $line)

    {   
        if (ENVIRONMENT === 'production') {
            $ci =& get_instance();

            $ci->load->library('email');
            $ci->email->from('errors@instantpowers.com', 'Errors Instant Powers');
            $ci->email->to('jgonzalez@jtmgdevelopment.com');

            $ci->email->subject('errorS');
            $ci->email->message('Severity: '.$severity.'  --> '.$message. ' '.$filepath.' '.$line);
            $ci->email->send();
        }


        parent::log_exception($severity, $message, $filepath, $line);
    }

}