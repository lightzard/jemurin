#!/bin/sh

while read line; do 
	echo -$line-
	if [ "$line" = "hujan" ]; then
		wget -nv --quiet -O /dev/null http://sunsquarestudio.com/jemurin/set_rain.php > /dev/null 2>&1;
		echo requues hujan $?;
	elif [ "$line" = "tidakhujan" ]; then
		wget -nv --quiet -O /dev/null http://sunsquarestudio.com/jemurin/set_clear.php > /dev/null 2>&1;
		echo requess tidakhujan $?;
	elif [ "$line" = "kering" ]; then 
		wget -nv --quiet -O /dev/null http://sunsquarestudio.com/jemurin/set_finish.php > /dev/null 2>&1;
		echo requies kering $?;
	fi
done < /dev/ttyACM0
