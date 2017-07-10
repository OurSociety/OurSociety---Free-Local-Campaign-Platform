# Official build of Nginx - https://hub.docker.com/_/nginx/
#
# Version follows the latest stable Nginx release.
#
# TODO: Determine exact version/tag for base image after going to production.
FROM nginx:stable-alpine

# Virtual host configuration
COPY app.conf /etc/nginx/conf.d/

# Change working directory to standard location to match PHP container
WORKDIR /app/webroot
