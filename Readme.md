### Deploy
Required local composer with local php version 8.2. Could add it to container but its slower there.
With lower php composer can be used with --ignore-platform-reqs

`docker-compose build && docker-compose up -d`

Symfony command run by php container
`docker exec -it [php_container_name] [command]`
for example
`docker exec -it php-task-php-1 bin/console c:c`

### Prepare for tests
`bin/console --env=test doctrine:database:create`
`bin/console --env=test doctrine:migrations:migrate`