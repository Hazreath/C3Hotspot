#!/bin/bash


# URL Blacklist
bl="/home/pi/bl_util/blacklist.bl"
old_bl="/home/pi/bl_util/blacklist_old.bl"
# URL fichier catégories
categories="/home/pi/bl_util/categories.bl"


#PARTIE WGET BLACKLISTS =====

#INITIALISATION DE L'ENVIRONNEMENT
cat /home/pi/bl_util/blacklist.bl > $old_bl
echo "" > $bl

while IFS= read -r cat
do
	# Télécharger la blacklist de la catégorie
	wget http://dsi.ut-capitole.fr/blacklists/download/$cat.tar.gz
	
	# Vérification du bon déroulement de wget
	wget_ok=$?;
	echo "RETOUR = $wget_ok"
	if [ wget_ok==0 ]; then 
		tar -xvf $cat.tar.gz
		echo "Ajout à la blacklist"
		cat $cat/domains >> $bl
		rm -fr $cat
		
	else echo "Le téléchargement de l'archive $cat a échoué !"
	
	fi
done < $categories


# PARTIE BLACKLIST -> IPTABLES

# Nombre de lignes de l'ancienne et de la nouvelle blacklist
old_bl_lines=$(cat $old_bl |wc -l)
bl_lines=$(cat $bl |wc -l)

# Si l'ancienne blacklist était plus fournie que la nouvelle
if [ $bl_lines -lt $old_bl_lines ]; then 
	echo "Erreur lors des téléchargements des blacklists."
	echo "La liste précédente restera en vigueur"
	$(cat $old_bl > $bl) # Restauration de l'ancienne blacklist
	exit 2 
fi

# Restauration des règles iptables d'origine
iptables-restore < /home/pi/iptorig.ip

# Blocage de chaque site 
while IFS= read -r site
do
	if [ -n "$site" ]; then
	# Règles iptables associées
		rule80="iptables -I FORWARD -p tcp --dport 80 -m string --string "$site" --algo bm --to 65535 -j DROP"
		log80="iptables -I FORWARD -p tcp --dport 80 -m string --string "$site" --algo bm --to 65535 -j LOG --log-prefix Traffic_INTERDIT:"$site
		rule443="iptables -I FORWARD -p tcp --dport 443 -m string --string "$site" --algo bm --to 65535 -j DROP"
		log443="iptables -I FORWARD -p tcp --dport 443 -m string --string "$site" --algo bm --to 65535 -j LOG --log-prefix Traffic_INTERDIT:"$site
		echo Application des règles iptables...
		
		$($rule80)
		$($log80)	
		$($rule443)
		$($log443)	
	fi
	
done < $bl


# Nettoyage des archives
echo ""
echo "Les catégories suivantes ont été blacklistées :"
echo "$(ls |grep tar.gz)"
rm *.tar.gz*


