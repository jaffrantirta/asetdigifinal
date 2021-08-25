<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists('send_mail'))
{
    function send_mail($data=array(""))
    {
        require __DIR__ . '/vendor/autoload.php';
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($data['from'], 'F-Rent');
        $email->setSubject($data['subject']);
        $email->addTo($data['to']);
        $email->addContent(
         "text/html", $data['message']
        );
        if (isset($data['attach'])) {
            $file_encoded = $data['attach']['file'];
            $file_title = $data['attach']['title'];
            $file_format = $data['attach']['format'];
            $email->addAttachment(
             $file_encoded,
             $file_format,
             $file_title,
             "attachment"
            );
        }
        $sendgrid = new \SendGrid($data['api_key']);
        try {
         $response = $sendgrid->send($email);
        } catch (Exception $e) {
         echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}
?>