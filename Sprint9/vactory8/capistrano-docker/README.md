docker exec -it vactory_php bash
cap production decompose:run drush status
cap production decompose:run composer install --no-dev --no-interaction --optimize-autoloader
cap production decompose:run "drush en memcache memcache_admin -y"
cap production decompose:run "drush en vactory_decoupled -y"


* make sure you create /home/[USER]/shared/oauth-keys/[private,public].key using 
```
openssl genrsa -out private.key 2048
openssl rsa -in private.key -pubout > public.key
```