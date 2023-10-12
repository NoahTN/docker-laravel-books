## Requirements
- [Docker](https://docs.docker.com/install)
- [Docker Compose](https://docs.docker.com/compose/install)

## Setup
1. Clone the repository.
1. Start the containers by running `docker-compose up -d` in the project root.
1. Install the composer packages by running `docker-compose exec laravel composer install`.
1. Install the npm packages by running `npm install`.
1. Access the Laravel instance on `http://localhost` (If there is a "Permission denied" error, run `docker-compose exec laravel chown -R www-data storage`).
1. If database tables are unset after running dusk tests, run `php artisan migrate`.

Note that the changes you make to local files will be automatically reflected in the container. 


## Frontend Development
Run this command to have the frontend files rebuild on changes made, note that a refresh is required
```
npm run watch-poll
```

## Testing
While executing commands in the Docker Container, use this to run Feature tests
```
./vendor/bin/phpunit tests/Feature --filter {SPECIFIC TEST NAME}
```
For Browser tests with Laravel Dusk, instead run
```
php artisan dusk tests/Feature --filter {SPECIFIC TEST NAME}
```


## Persistent database
If you want to make sure that the data in the database persists even if the database container is deleted, add a file named `docker-compose.override.yml` in the project root with the following contents.
```
version: "3.7"

services:
  mysql:
    volumes:
    - mysql:/var/lib/mysql

volumes:
  mysql:
```
Then run the following.
```
docker-compose stop \
  && docker-compose rm -f mysql \
  && docker-compose up -d
``` 
