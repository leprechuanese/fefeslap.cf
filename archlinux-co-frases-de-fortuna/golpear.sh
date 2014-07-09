#!/bin/sh
dicc="archco"
if [ $# -gt 0 -a -f ~/.irssi/scripts/fortune/$1 ] ; then
    dicc=$1
    shift
fi
dicc=~/scripts/fortune/$dicc
echo -n "golpea a $* "
fortune $dicc
