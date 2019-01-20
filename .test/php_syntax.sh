#!/bin/bash

PHP=/usr/bin/php

COUNT=0
HIT=0

cd ..

for file in `find . -name \*.php`; do
    OUTPUT=`$PHP -l $file`
    if ! [ 0 = $? ]; then
        echo $OUTPUT
	HIT=$(($HIT+1))
    fi
    COUNT=$(($COUNT+1))
done


if ! [ 0 = $HIT ]; then
	echo "Syntax check: FAILED"
	echo "Checked Files: $COUNT, Files with Errors: $HIT"
	exit 1
else
	echo "Syntax check: PASSED"
	echo "Checked Files: $COUNT"
	exit 0
fi
