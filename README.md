# OurSociety.org

2017 MVP for OurSociety (Ron Rivers)

## Table of Contents

1. [Development](#development)

## Development

We use [Docker](https://docs.docker.com/engine/installation/) to create a development environment that closely mimics production. The services are defined in `docker-compose.yml` and they can be controlled using the `docker-compose` CLI tool.

There is a `Dockerfile` for each service in the `docker/` directory that declares how to build each image that the containers will be created from. All images can be (re-)built using the `docker-compose build` command.

To start all the services, run `docker-compose up` and open another terminal window. Alternatively, use `docker-compose up -d` to run them in the background, and attach to the log stream with `docker-compose logs -f`.

Finally, add the line `127.0.0.1 mysociety.dev www.mysociety.dev` to your `/etc/hosts` file and visit [http://mysociety.dev](http://mysociety.dev) in your browser.
