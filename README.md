# Underdogs Cup

[![wakatime](https://wakatime.com/badge/user/4309168b-a627-4970-ba6b-7f0ac10393d4/project/e9fad033-b109-4dbb-a164-4e3a8d6c0d8e.svg)](https://wakatime.com/badge/user/4309168b-a627-4970-ba6b-7f0ac10393d4/project/e9fad033-b109-4dbb-a164-4e3a8d6c0d8e)

## structure

- `./app` contains app logic
- `./database/migrations` contains database migrations
- `./routes` contains the routes (or run `php artisan route:list`)
- `./resources/views` contains the views
- `./bot` contains a node.js app for a discord bot to manage roles and nicknames, it receives post requests on localhost

## setup

php8.1, db of choice,

- set `.env` from `.env.example`, check at the very bottom
    - discord client/secret required, token only if you want to use discord bot
    - requires guild members privileged intent
- `composer install`
- `php artisan key:generate`
- `php artisan migrate`, use `--seed` if you're working locally to create a test tournament
- `npm install`
- `npm run dev` or `npm run build` to compile assets
- `npm run bot` to start the discord bot
- `deploy.sh` for a simple deploy script without the discord bot
- `php artisan test` to run tests
