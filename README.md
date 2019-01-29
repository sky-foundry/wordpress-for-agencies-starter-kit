# Wordpress Skeleton

## Requirements

- Docker - [Install](https://www.docker.com/get-started)
- Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

## Installation

1. Clone the repository:
   ```sh
   $ git clone git@github.com:sky-foundry/wordpress-skeleton.git
   ```
2. Install dependencies:
   ```sh
   $ composer install && yarn install
   ```
3. Update environment variables in the `.env` file in the project root:

- `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT`
  - Generate with [our WordPress salts generator](https://roots.io/salts.html)
  - Generate with [wp-cli-dotenv-command](https://github.com/aaemnnosttv/wp-cli-dotenv-command)

4. Start the development environment. _Note: Docker must be running on your machine before executing the command below_
   ```sh
   $ yarn run dev
   ```
5. You can now access the new Wordpress instance at http://localhost:8000.

## Documentation

Bedrock documentation is available at [https://roots.io/bedrock/docs/](https://roots.io/bedrock/docs/).
