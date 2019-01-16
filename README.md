# = C3Hotspot =

Changelogs 
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
