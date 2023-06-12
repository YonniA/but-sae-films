#!/usr/bin/env bash

php -d display_errors -d auto_prepend_file="$PWD/vendor/autoload.php" -S localhost:8000 -t public/