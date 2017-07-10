FROM node:alpine

# Add custom entrypoint that runs installs packages and runs webpack
COPY docker-entrypoint /usr/local/bin/
ENTRYPOINT ["docker-entrypoint"]

# Use standard working directory instead of root directory
WORKDIR /app
