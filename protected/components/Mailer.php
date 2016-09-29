<?php
class Mailer {

    /**
     * Send mail
     */
    public static function mail($to, $subject, $message, $from ,$SMTP = array() ,$attachments=array())
    {
        $mailTheme=Yii::app()->params['mailTheme'];
        $mailTheme=str_replace('{CurrentYear}', JalaliDate::date('Y'), $mailTheme);
        $message=str_replace('{MessageBody}', $message, $mailTheme);
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail=new JPhpMailer;
        $mail->SetFrom($from, Yii::app()->name);
        if($SMTP && isset($SMTP['Host'])&& isset($SMTP['Secure'])&& isset($SMTP['Username'])&& isset($SMTP['Password'])&& isset($SMTP['Port']))
        {
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = $SMTP['Host'];
            $mail->SMTPSecure = $SMTP['Secure'];
            $mail->Username = $SMTP['Username'];
            $mail->Password = $SMTP['Password'];
            $mail->Port = (int)$SMTP['Port'];
        }
        $mail->Subject=$subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);
        if($attachments)
            foreach($attachments as $attachment)
                $mail->AddAttachment($attachment);
        return $mail->Send();
    }
}