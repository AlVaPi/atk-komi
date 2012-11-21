#!/usr/bin/php -q

<?php
$addres="asu@atk-komi.ru";
$subj="Сообщение через сайт";
$head="Content-type:text/plain; \n\t charset=windows-1251;";
$dat=date("D, d.m.y, H:i");
$name=($_POST['name']);
$email=($_POST['email']);
$msg=($_POST['msg']);
$text="Отправитель: $name \r\nE-Mail: $email \r\nСообщение: $msg \r\nДата: $dat";
mail($addres, $subj, $text, $head);
echo "Ваше сообщение отправлено, спасибо!";

?>