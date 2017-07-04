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

# Add database initializating script
#
# https://github.com/docker-library/docs/tree/master/mysql#initializing-a-fresh-instance
COPY initdb.sh /docker-entrypoint-initdb.d/
