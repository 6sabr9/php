1<?php
//Regards
date_default_timezone_set('America/Los_Angeles');
$date = date('G:i A, M d, Y (T)');

/* SMTP SETUP */
$smtp_acc = [
[
       "host"     => "mail.2.mysec0.com",
        "port"     => "587",
        "username" => "_mainaccount@2.mysec0.com",
        "password" => ""
    ],
];
/* Features SETUP */
$ma_setup = [
    "priority"       => 1,
    "userandom"      => 0,
    "sleeptime"      => 59,
    "replacement"    => 1,
    "filesend"       => 1,
    "userremoveline" => 0,
    "mail_list"      => "file/maillist/a.txt",
    "fromname"       => "",/* Sender Name */
    "frommail"       => "",/* Sender's Address */
    "subject"        => "",/* Subject Adress */
    "msgfile"        => "file/letter/",/* letter.Html */
    "filepdf"        => "",/* File Upload */
    "scampage"       => [""],/* Url links */
];//