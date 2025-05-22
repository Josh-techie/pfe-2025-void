# FROM composer:1.7.2 AS composer-1

FROM vactory/php-fpm-nginx:8.1.16
USER root

RUN apk add openssl
# COPY --from=composer-1 /usr/bin/composer /usr/local/bin/composer

# curl "https://github.com/tideways/php-xhprof-extension/archive/refs/tags/v5.0.2.tar.gz" -fsL -o ./php-xhprof-extension.tar.gz

# install the xhprof extension to profile requests
# RUN apk --no-cache add php7-dev php7-pear build-base autoconf musl-dev
# RUN curl "https://github.com/tideways/php-xhprof-extension/archive/v5.0.2.tar.gz" -fsL -o /tmp/php-xhprof-extension.tar.gz && \
#     mkdir -p /tmp/php-xhprof-extension && \
#     tar xf /tmp/php-xhprof-extension.tar.gz -C /tmp/php-xhprof-extension && \
#     cd /tmp/php-xhprof-extension/php-xhprof-extension-5.0.2 && \
#     phpize && \
#     ./configure && \
#     make && \
#     make install
# RUN PHP_INI_DIR="/etc/php7/" && \
#     mkdir -p /xhprof_output && \
#     chown nobody:nobody /xhprof_output && \
#     mv /tmp/php-xhprof-extension/php-xhprof-extension-5.0.2/modules/tideways_xhprof.so $(php -r "echo ini_get ('extension_dir');")/tideways_xhprof.so && \
#     printf "extension=tideways_xhprof.so\nxhprof.output_dir=/xhprof_output\n" > $PHP_INI_DIR/conf.d/tideways_xhprof.ini && \
#     rm -rf /tmp/php-xhprof-extension.tar.gz /tmp/php-xhprof-extension
# RUN pecl install jsmin
# RUN PHP_INI_DIR="/etc/php7/" && \
#     printf "extension=jsmin.so\n" > $PHP_INI_DIR/conf.d/jsmin.ini
# RUN apk del php7-dev build-base php7-pear autoconf musl-dev

# RUN PHP_INI_DIR="/etc/php7/" \
#     && version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
#     && architecture=$(uname -m) \
#     && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/$architecture/$version \
#     && mkdir -p /tmp/blackfire \
#     && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
#     && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
#     && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8307\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
#     && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

# # Install blackfire client.
# RUN mkdir -p /tmp/blackfire \
#     && architecture=$(uname -m) \
#     && curl -A "Docker" -L https://blackfire.io/api/v1/releases/cli/linux/$architecture | tar zxp -C /tmp/blackfire \
#     && mv /tmp/blackfire/blackfire /usr/bin/blackfire \
#     && rm -Rf /tmp/blackfire

# # Install newrelic deps
# RUN apk add gcompat;

# RUN PHP_INI_DIR="/etc/php7/" \
#   curl -L https://download.newrelic.com/php_agent/release/newrelic-php5-9.18.1.303-linux.tar.gz | tar -C /tmp -zx && \
#   export NR_INSTALL_USE_CP_NOT_LN=1 && \
#   echo "eu01xx2465cc86e86488ea21530f96983c50NRAL" | /tmp/newrelic-php5-*/newrelic-install install && \
#   rm -rf /tmp/newrelic-php5-* /tmp/nrinstall* && \
#   sed -i \
#       -e 's/"REPLACE_WITH_REAL_KEY"/"eu01xx2465cc86e86488ea21530f96983c50NRAL"/' \
#       -e 's/newrelic.appname = "PHP Application"/newrelic.appname = "drupal_sacd"/' \
#       -e 's/;newrelic.daemon.app_connect_timeout =.*/newrelic.daemon.app_connect_timeout=15s/' \
#       -e 's/;newrelic.daemon.start_timeout =.*/newrelic.daemon.start_timeout=5s/' \
#       -e 's/;newrelic.daemon.address =.*/newrelic.daemon.address=sacd_newrelic:31339/' \
#       /etc/php7/conf.d/newrelic.ini;

# # RUN echo -e "\nnewrelic.daemon.port=31339\n" >> /etc/php7/conf.d/newrelic.ini

# RUN touch /var/log/newrelic/newrelic-daemon.log; \
#     chown nobody:nobody /var/log/newrelic/newrelic-daemon.log;

COPY ./.docker/php/default-prod.ini /etc/php81/conf.d/custom.ini
COPY ./.docker/nginx/default.conf /etc/nginx/nginx.conf
COPY ./.docker/php/www.conf /etc/php81/php-fpm.d/www.conf
COPY ./.docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

USER nobody
