#!/bin/bash

if test $(pgrep -f downloadmonitor.php|wc -l) -eq 0
then
  /usr/local/php/bin/php /var/html/www/Sermanage/Command/downloadmonitor.php
fi
