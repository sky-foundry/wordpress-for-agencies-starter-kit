# Wordpress Starter Kit

## Requirements

- Docker - [Install](https://www.docker.com/get-started)
- Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

## Installation

1. Clone the repository:
   ```sh
   $ git clone git@github.com:sky-foundry/wordpress-starter-kit.git
   ```
2. Install dependencies:
   ```sh
   $ composer install && yarn install
   ```
3. Start the development environment. _Note: Docker must be running on your machine before executing the command below_
   ```sh
   $ yarn run dev
   ```
   If the command fails when trying to build the wordpress image, you will need to check that you are correctly authenticated with gcloud.
   ```sh
   $ gcloud auth login
   $ gcloud auth configure-docker
   ```
   You should be able to re-run the `yarn run dev` command and the image will build successfully. If you still receive a permission error, it may be that you need read access on the appropriate Storage Bucket.
4. You can now access the new Wordpress instance at http://localhost:8000.

## Using Cloud SQL

1. Add the `dev-sql-proxy.json` credentials to the directory `.private` in the project root.
   _See https://sky-foundry.slack.com/archives/CG5D6LWR0/p1550023029002200_

2. Within the `docker-compose.yml` file, comment out the existing mysql service and then uncomment the db proxy service.

3. Start the development environment like normal.

## Bedrock Documentation

Bedrock documentation is available at [https://roots.io/bedrock/docs/](https://roots.io/bedrock/docs/).
