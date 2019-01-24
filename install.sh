#!/bin/bash

# Installation des fonctionnalités de base du hotspot

# Sauvegarde de l'état actuel
if [ -f /etc/dhcpcd.conf ]; then
	$(mv -v /etc/dhcpcd.conf /etc/dhcpcd.conf.bak)
fi

apt-get install vim dnsmasq hostapd iptables-persistant
mv -v /etc/hostapd/hostapd.conf /etc/hostapd/hostapd.conf.orig
mv -v /etc/dnsmasq.conf /etc/dnsmasq.conf.orig
iptables-save > /home/pi/iptables.sav.orig

# Copie des nouveaux fichiers 
cp -v /home/pi/C3Hotspot/dhcpcd.conf /etc/dhcpcd.conf
cp -v /home/pi/C3Hotspot/hostapd.conf /etc/hostapd/hostapd.conf
cp -v /home/pi/C3Hotspot/dnsmasq.conf /etc/dnsmasq.conf
cp -v /home/pi/C3Hotspot/bashrc-root ~/.bashrc
iptables-restore < /home/pi/C3Hotspot/iptables_hotspot.sav

if [ -f /root/.local ]; then
	mkdir /root/.local
	mkdir /root/.local/share
fi


#Install des exécutables
chmod u+x c3start.sh
chmod u+x c3stop.sh
cp -v c3start.sh /usr/bin/c3start
cp -v c3stop.sh /usr/bin/c3stop

echo "Hotspot installé !"
# Redémarrage des services
service dhcpcd restart
service dnsmasq restart
c3start
