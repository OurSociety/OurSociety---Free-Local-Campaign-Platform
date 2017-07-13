# Official build of MySQL - https://hub.docker.com/_/mysql/
#
# Version follows the latest version of MySQL on Amazon RDS in US East (N. Virginia) region:
#
# http://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/CHAP_MySQL.html#MySQL.Concepts.VersionMgmt
FROM mysql:5.7.17

# Hard-coded credentials for development
#
# https://github.com/docker-library/docs/tree/master/mysql#environment-variables
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_USER=app
ENV MYSQL_PASSWORD=secret

# Install Dockerize for log redirection
#
# Adds a wrapper entrypoint and redeclares the entrypoint/command to use it.
ENV DOCKERIZE_VERSION=0.5.0
RUN set -x \
 && apt-get update && apt-get install -y --no-install-recommends ca-certificates wget && rm -rf /var/lib/apt/lists/* \
 && wget https://github.com/jwilder/dockerize/releases/download/v${DOCKERIZE_VERSION}/dockerize-alpine-linux-amd64-v${DOCKERIZE_VERSION}.tar.gz \
 && apt-get purge -y --auto-remove ca-certificates wget \
 && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-v${DOCKERIZE_VERSION}.tar.gz \
 && rm dockerize-alpine-linux-amd64-v${DOCKERIZE_VERSION}.tar.gz
COPY docker-entrypoint /usr/local/bin/dockerize-entrypoint.sh
ENTRYPOINT ["dockerize-entrypoint.sh"]
CMD ["mysqld"]

# Add database initializating script
#
# https://github.com/docker-library/docs/tree/master/mysql#initializing-a-fresh-instance
COPY initdb.sh /docker-entrypoint-initdb.d/

# Add custom MySQL settings
COPY mysql.cnf /etc/mysql/conf.d/custom.cnf
