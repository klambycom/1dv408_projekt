# 1DV408

## Instruktioner för driftsättsning

Ändra model/Settings.php och kör sen model/Setup.php.

## Sätta upp utvecklarmiljön

Jag har bara testat med Ubuntu 12.04 LTS (http://files.vagrantup.com/precise32.box).

Puppetmoduler som måste installeras:

puppetlabs/apache
puppetlabs/mysql
Jag har en absolut sökväg på min dator i puppet.module_path, så det måste ändras. (Det borde finnas en smartare lösning.)

Jag använder Sass, Compass och Bootstrap, så kör compass watch.
