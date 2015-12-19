<?php

$i=0;
$i++;

$cfg['Servers'][$i]['host'] = getenv('DB_PORT_3306_TCP_ADDR');
$cfg['Servers'][$i]['user'] = getenv('MYSQL_ROOT_USER');
$cfg['Servers'][$i]['password'] = getenv('MYSQL_ROOT_PASSWORD');
