#!/bin/bash
# ===== BLACKLISTGETTER =====
newName=$(date +%d_%m_%y-%H:%M)-blacklists
wget --timestamping http://dsi.ut-capitole.fr/blacklists/download/blacklists.tar.gz
$wget_ok = $?;
tar -xzf

# IF WGET OK =
if (wget_ok == 0) then
	echo "Téléchargement archive OK\n"
	mv -v ./blacklists.tar.gz /var/lib/squidguard/db/$newName
	rm -fr /var/lib/squidguard/db
	mkdir /var/lib/squidguard/db
	tar -xzf /var/lib/squidguard/db/$newName
	squidGuard -C all
	service squid restart
fi
