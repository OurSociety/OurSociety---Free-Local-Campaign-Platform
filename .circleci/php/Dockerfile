FROM circleci/php:7.1-node-browsers

RUN apt-get update \
 && apt-get install -y \
        libicu-dev \
        zlib1g-dev \
 && rm -rf /var/lib/apt/lists/*
