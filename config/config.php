<?php

return $config = [
    'database' => [
        'mysql' => [
            'db_user' => getenv('DB_ENV_MYSQL_USER'),
            'db_pass' => getenv('DB_ENV_MYSQL_PASSWORD'),
            'db_name' => getenv('DB_ENV_MYSQL_DATABASE'),
            'db_host' => getenv('DB_PORT_3306_TCP_ADDR')
        ]
    ]
];
