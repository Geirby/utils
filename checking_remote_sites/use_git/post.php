<?php
$rn = "\r\n";
$to = "ze-nya@yandex.ru";
$to = "ilyin@lexpro.ru";
$to = "xzenya@gmail.com";
$subject = "Предупрежение о заражении";


// Сообщение
// $message = "Line 1\r\nLine 2\r\nLine 3";

// На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
// $message = wordwrap($message, 70, "\r\n");

// Отправляем
//mail($to, $subject, $message);

function mailSend($to, $subject, $gitStatus = null)
{
    unset($gitStatus[0]);

    $mailconfig = parse_ini_file ('config.ini');
    unset($gitStatus[1]);
    $template = implode("<br />", $gitStatus);
    $mailconfig = (object)$mailconfig;

    $localhost = 'ze-nya.myjino.ru';
    $newLine = "\r\n";
    $timeout = "30";

    $smtpConnect = fsockopen($mailconfig->server, $mailconfig->port, $errno, $errstr, $timeout);

    if(!$smtpConnect && $errno == 0) {
        return false;
    }

    $smtpResponse = fgets($smtpConnect, 515);

    if (empty($smtpConnect)) {
        return false;
    } else {
        $logArray['connection'] = "Connected: $smtpResponse";
    }
//    print_r($logArray);

    fputs($smtpConnect, "HELO $localhost" . $newLine);
    fgets($smtpConnect, 515);

    fputs($smtpConnect, "AUTH LOGIN" . $newLine);
    print_r(fgets($smtpConnect, 515));

    fputs($smtpConnect, base64_encode($mailconfig->username) . $newLine);
    fgets($smtpConnect, 515);

    fputs($smtpConnect, base64_encode($mailconfig->password) . $newLine);
    print_r(fgets($smtpConnect, 515));

    fputs($smtpConnect, "MAIL FROM:<$mailconfig->username>" . $newLine);
    print_r(fgets($smtpConnect, 515));

    fputs($smtpConnect, "RCPT TO:<$to>" . $newLine);
    print_r(fgets($smtpConnect, 515));

    fputs($smtpConnect, "DATA" . $newLine);
    fgets($smtpConnect, 515);

    fputs($smtpConnect,
        "Subject: $subject\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: $mailconfig->fromName <$mailconfig->fromEmail>\r\n\r\n$template\r\n.\r\n");
    print_r(fgets($smtpConnect, 515));

    fputs($smtpConnect, "QUIT" . $newLine);

    if(fgets($smtpConnect, 515) == false) {
        return false;
    };
    return true;
}

mailSend($to, $subject, $argv);