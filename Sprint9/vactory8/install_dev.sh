#!/bin/sh

# Composer
EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_SIGNATURE="$(php -r "echo hash_file('SHA384', 'composer-setup.php');")"

if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]
then
    >&2 echo 'ERROR: Invalid installer signature'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quiet
RESULT=$?
rm composer-setup.php
mv composer.phar /usr/local/bin/composer
which composer

# Drupal coder
composer global require drupal/coder
composer global show -P
export PATH="$PATH:$HOME/.composer/vendor/bin"
composer global require drupal/coder:^8.2.12
composer global require dealerdirect/phpcodesniffer-composer-installer
phpcs -i

# JSHint
npm install -g jshint

# ScssLint
gem install scss_lint

# Git Hooks.
cp _factory/git-hooks/pre-commit .git/hooks/pre-commit
