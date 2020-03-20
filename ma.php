<?php

require	        'setting/phpmailer/PHPMailerAutoload.php';
require	        'setting/phpmailer/class.phpmailer.php';
require 		    'setting/ma.settings.php';
require 		    'setting/ma.function.php';

echo "        \e[92m[\e[0m \e[1;4m+\e[0m \e[92m]\e[0m";
        echo "\r\n";
        echo "\n";
echo " \n  \e[38;5;171;1m       \r\n"; 
echo "\033[1;33m   +---------------------- FITTOOL S3ND3R CLI ------------------+\n";
echo"\033[1;36m ╔════════════════════════════════════════════════════════════════════════════════════════════╗ \n";
echo "\033[1;36m║         Motto: Inbox Has No Method U Have To Work For It   #GOOD SMTP STILL HIT SPAMBOX    ║ \n";
echo "\033[1;32m║                            📧📧📧       📧📧📧    📧📧📧                                         ║  \n";
echo "\033[1;36m║         ║ \n";
echo "\033[1;31m╚════════════════════════════════════════════════════════════════════════════════════════════╝ \n";
echo "\033[1;32m   | FB Profile :  \n";
echo "\033[1;36m   +----------------------------------------------------------+\n";
echo "\e[0m \r\n"; 
echo "  \r\n"; 
echo "\r\n";


function Kirim($email, $smtp_acc, $ma_setup)
{
    $smtp           = new SMTP;
    $smtp->do_debug = 0;

    $smtpserver     = $smtp_acc['host'];
    $smtpport       = $smtp_acc['port'];
    $smtpuser       = $smtp_acc['username'];
    $smtppass       = $smtp_acc['password'];
    $priority       = $ma_setup['priority'];
    $userandom      = $ma_setup['userandom'];
    $sleeptime      = $ma_setup['sleeptime'];
    $replacement    = $ma_setup['replacement'];
    $userremoveline = $ma_setup['userremoveline'];
    $fromname       = $ma_setup['fromname'];
    $frommail       = $ma_setup['frommail'];
    $subject        = $ma_setup['subject'];
    $msgfile        = $ma_setup['msgfile'];
    $filepdf        = $ma_setup['filesend'];
    $randurl        = $ma_setup['scampage'];

    if (!$smtp->connect($smtpserver, $smtpport)) {
        throw new Exception('Connect failed');
    }

    //Say hello
    if (!$smtp->hello(gethostname())) {
        throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
    }

    $e = $smtp->getServerExtList();

    if (array_key_exists('STARTTLS', $e)) {
        $tlsok = $smtp->startTLS();
        if (!$tlsok) {
            throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
        }
        if (!$smtp->hello(gethostname())) {
            throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
        }
        $e = $smtp->getServerExtList();
    }

    if (array_key_exists('AUTH', $e)) {

        if ($smtp->authenticate($smtpuser, $smtppass)) {
            $mail           = new PHPMailer;
            $mail->Encoding = 'base64'; // 8bit base64 multipart/alternative quoted-printable
            $mail->CharSet  = 'UTF-8';
            $mail->headerLine("format", "flowed");
            /*  Smtp connect    */
            //$mail->addCustomHeader('X-Ebay-Mailtracker', '11400.000.0.0.df812eaca5dd4ebb8aa71380465a8e74');
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host     = $smtpserver;
            $mail->Port     = $smtpport;
            $mail->Priority = $priority;
            $mail->Username = $smtpuser;
            $mail->Password = $smtppass;

            if ($userandom == 1) {
                $rand     = rand(1, 50);
                $fromname = randName($rand);
                $frommail = randMail($rand);
                $subject  = randSubject($rand);
            }

            if ($ma_setup['filesend'] == 0) {
                $filepdf = file_get_contents($AddAttachment);
                $mail->AddAttachment($filepdf);
            }

            $asu       = RandString1(8);
            $asu1      = RandString(5);
            $asu2      = RandString1(5);
            $nmbr      = RandNumber(5);
            $fromnames = str_replace('##randstring##', $asu1, $fromname);
            $frommails = str_replace('##randstring##', $asu, $frommail);
            $subjects  = str_replace('##randstring##', $asu2, $subject);

            $mail->setFrom($frommails, $fromnames);

            $mail->AddAddress($email);

            $mail->Subject = $subjects;
            if ($replacement == 1) {
                $msg = lettering($msgfile, $email, $frommail, $fromname, $randurl, $subject);
            } else {
                $msg = file_get_contents($msgfile);
            }

            $mail->msgHTML($msg);

            if (!$mail->send()) {
                echo "SMTP Error : " . $mail->ErrorInfo;
                exit();
            } else {
                echo "                  \e[91m[+] \e[38;5;086;1m";
                echo date('h:i:s A');
                echo "\e[0m \x1B[91m[+] \e[38;5;086;1mSend To : \e[38;5;171;1m$email \e[38;5;15m Send OKAY : \e[91m$smtpuser \e[38;5;093;1m [! DELIVERED !]\n";
            }
            $mail->clearAddresses();

        } else {
            throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
        }

        $smtp->quit(true);

    }

}



    $file = file_get_contents($ma_setup['mail_list']);
    if ($file) {
        $ext = preg_split('/\n|\r\n?/', $file);
        echo "        \e[92m[\e[0m \e[1;4m+\e[0m \e[92m]\e[0m";
        echo " \e[1;4m_____________________________________________________________________________________________________________________________________________________\e[92m[\e[0m \e[1;4m+\e[0m \e[92m]\e[0m";
        echo "\r\n";
        echo "\n";
        $smtp_key = 0;
        foreach ($ext as $num => $email) {

            if ($smtp_key == count($smtp_acc)) {
                $smtp_key = 0;
            }
            //kirim
            Kirim($email, $smtp_acc[$smtp_key], $ma_setup);

            $smtp_key++;

            ///
            sleep($ma_setup['sleeptime']);
        }
        if ($ma_setup['userremoveline'] == 1) {
            $remove = Removeline($mailist, $email);
        }
    }
