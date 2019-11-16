############################################################################
# Container for running Codeception tests on a WooGraphQL Docker instance. #
############################################################################

# Using the 'DESIRED_' prefix to avoid confusion with environment variables of the same name.
ARG DESIRED_WP_VERSION
ARG DESIRED_PHP_VERSION

FROM kidunot89/woographql-app:wp${DESIRED_WP_VERSION}-php${DESIRED_PHP_VERSION}


LABEL author=kidunot89
LABEL author_uri=https://github.com/kidunot89

SHELL [ "/bin/bash", "-c" ]

ARG DESIRED_WP_VERSION
ARG DESIRED_PHP_VERSION

# Install php extensions
RUN docker-php-ext-install pdo_mysql

# Install Xdebug
RUN if [ "$DESIRED_PHP_VERSION" != "5.6" ] || [ "$DESIRED_PHP_VERSION" != "7.0" ]; then \
    apt-get install zip unzip -y && \
    pecl install pcov && \
    docker-php-ext-enable pcov && \
    rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ;\
    fi 

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Add composer global binaries to PATH
ENV PATH "$PATH:~/.composer/vendor/bin"

# Configure php
RUN echo "date.timezone = UTC" >> /usr/local/etc/php/php.ini

# Remove exec statement from base entrypoint script.
RUN sed -i '$d' /usr/local/bin/app-entrypoint.sh

# Set up entrypoint
WORKDIR    /var/www/html/wp-content/plugins/wp-graphql-woocommerce
COPY       bin/testing-entrypoint.sh /usr/local/bin/testing-entrypoint.sh
RUN        chmod 755 /usr/local/bin/testing-entrypoint.sh
ENTRYPOINT ["testing-entrypoint.sh"]