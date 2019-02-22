# = C3Hotspot =

Changelogs 

v0.2 : Captive Portal !

I added a captive portal to the solution, using nodogsplash and nginx.
Atm, auth works by querying a company ws to check if the credentials are relied to an user.
Everything is js/php/shell and it is simple enough so that you can use it as you want !
I also added a logging system according to french law, using httpry, that captures every action and connection to the hotspot.

sudoers.tar and nodogsplash.tar are here cause git was annoying me, untar them and run the install script
// TODO add untar to the script
        Improve blacklist
        Hotspot customisation page

v0.11 -
- No more squid, since it fails to parse port 443 traffic (even with ssl_bump)
- bl_utils : blacklist filtering system based on iptables, plus a log archiver that keeps internet traffic for 365 days (according to GDPR)


V0.1 -
A fancy hotspot based on Kupiki hotspot.

Contains the following :
- SQUID on ports 3128/3129 that intercepts and process ports 80/443 (443 soon)
- A blacklist system based on Squid (not SquidGuard) and a blacklist updater
- Necessary routes
- Iptables settings
