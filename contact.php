<?php

$error = false;
$emailExp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

$name  = array_key_exists('name', $_POST) ? $_POST['name'] : '';
$email = array_key_exists('email', $_POST) ? $_POST['email'] : '';
$phone = array_key_exists('phone', $_POST) ? $_POST['phone'] : '';
$comment = array_key_exists('comment', $_POST) ? $_POST['comment'] : '';

if (!$name) {
    $error = 'Please provide a name';
}

if (!$email && !$phone) {
    $error = 'Please provide an email address or a phone number';
}

if ($email && !preg_match($emailExp, $email)) {
    $error 'The email address you entered does not appear to be valid';
}

function escape ($string) {
    $blacklist = [
        "content-type",
        "bcc:",
        "to:",
        "cc:",
        "href"
    ];
    return str_replace($blacklist, "", $string);
}

if (!$error) {
    
    $message = implode("\n", [
        "Name: " . escape($name),
        "Email: " .escape($email),
        "Phone: " . escape($phone),
        "Comment: " . escape($comment),
    ]);
    
    $headers = implode("\r\n", [
        'From: ' . $email,
        'Reply-To: ' . $email,
        'X-Mailer: PHP/' . phpversion()
    ]);

    @mail('info@bmreholdings.com', 'Contact from', $message, $headers);
}

echo json_encode([ 'error' => $error ]);
