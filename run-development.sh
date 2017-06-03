#!/bin/bash

php -S localhost:8000 "$(pwd)/appservice/src/index.php" &
cd webapp && ng serve &
