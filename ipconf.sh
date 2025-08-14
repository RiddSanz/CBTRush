#!/bin/sh
ifconfig eth0 192.168.205.100 netmask 255.255.255.0 up
route add default gw 192.168.205.1
