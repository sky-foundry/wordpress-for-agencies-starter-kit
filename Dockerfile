# First we build our static assets using the Node image as a build-step
FROM node:11-alpine as static-build

WORKDIR /usr/src/app

COPY package.json ./
COPY yarn.lock ./

RUN yarn install \
    && yarn cache clean

COPY ./web/app/themes ./web/app/themes

COPY postcss.config.js ./
COPY webpack.config.js ./

RUN yarn run build

# Now create our image which will run the Wordpress instance
FROM skyfoundryagency/docker-nginx-php:latest

COPY composer.json .
COPY composer.lock .

RUN composer install --prefer-dist --no-scripts --no-autoloader --no-progress --no-suggest \
    && composer clear-cache

COPY . .
COPY --from=static-build /usr/src/app/web/app/themes/default-theme/dist /var/www/html/web/app/themes/default-theme/dist

RUN composer dump-autoload --no-scripts --optimize
