#!/bin/bash

# Installation des fonctionnalités de base du hotspot
# @author benji

current_pwd=$(basename "$(pwd)")
if [ "$current_pwd" == "C3Hotspot"]; then
	# Sauvegarde de l'état actuel de dhcpcd
	if [ -f /etc/dhcpcd.conf ]; then
		$(mv -v /etc/dhcpcd.conf /etc/dhcpcd.conf.bak)
	fi
	echo "C3Hotspot v0.1 By b.camp"
	# Installation et sauvegarde des fichiers de conf par défaut
	echo "Installing necessary software ..."
	apt-get install -y vim dnsmasq hostapd iptables-persistent nginx \
	libmicrohttpd-dev httpry php7.0 

	# DEV ENV
	apt-get install locate 


	mv -v /etc/hostapd/hostapd.conf /etc/hostapd/hostapd.conf.orig
	mv -v /etc/dnsmasq.conf /etc/dnsmasq.conf.orig
	iptables-save > /home/pi/iptables.sav.orig

	echo "Copying config files ..."
	# Copie des nouveaux fichiers 
	cp -v /home/pi/C3Hotspot/dhcpcd.conf /etc/dhcpcd.conf
	cp -v /home/pi/C3Hotspot/hostapd.conf /etc/hostapd/hostapd.conf
	cp -v /home/pi/C3Hotspot/dnsmasq.conf /etc/dnsmasq.conf
	cp -v /home/pi/C3Hotspot/bashrc-root ~/.bashrc
	cp -v sudoers /etc/sudoers
	iptables-restore < /home/pi/C3Hotspot/iptables_hotspot.sav
	cp -vr sites-availables /etc/nginx/sites-availables 
	cp -vr html /var/www/html
	echo "net.ipv4.ip_forward = 1" >> /etc/sysctl.conf

	# Geany bug
	if [ ! -f /root/.local ]; then
		mkdir /root/.local
		mkdir /root/.local/share
	fi


	#Install des exécutables
	chmod u+x c3start
	chmod u+x c3stop
	chmod u+x C3Trace
	cp -v c3start /usr/bin/c3start
	cp -v c3stop /usr/bin/c3stop
	cp -v C3Trace /usr/bin/C3Trace
	cp -v joinLogs /usr/bin/joinLogs
	chown -R www-data:www-data /usr/bin/C3Trace
	echo "Hotspot installé !"

	# Installation nodogsplash
	cd nodogsplash
	make; make install


	# Redémarrage des services
	service dhcpcd restart
	service dnsmasq restart
	crontab -l | { cat; echo "@reboot sudo c3start";} | crontab -
	crontab -l | { cat; echo "0 0 * * * sudo joinLogs";} | crontab -
	c3start
else 
	echo "Error : you must be in the cloned folder root (C3Hotspot) folder to proceed."
	echo "Execute the following command : cd <C3Hotspot folder> ;"
fi
