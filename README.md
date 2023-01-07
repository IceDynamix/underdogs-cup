# Underdogs Cup

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
- `composer install`
- `php artisan key:generate`
- `php artisan migrate`, use `--seed` if you're working locally to create a test tournament
- `npm install`
- `npm run dev` or `npm run build` to compile assets
- `npm run bot` to start the discord bot
- `deploy.sh` for a simple deploy script without the discord bot
- `php artisan test` to run tests
