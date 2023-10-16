#!/bin/sh
php -S localhost:8888 -t "$1" sys/router.php &
exo-open --launch WebBrowser "http://localhost:8888/"

