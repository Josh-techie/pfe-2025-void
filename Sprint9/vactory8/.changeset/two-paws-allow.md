---
"vactory8": minor
---

Update core to 10.2.3

```
composer update drupal/core drupal/core-vendor-hardening drush/drush --with-dependencies
drush updb
drush cr
```