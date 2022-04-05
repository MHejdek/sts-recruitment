## STS Recruitment

## Project setup on docker

```./docker/setup.sh``` - run this script to setup the project. This command will run underneath: 

* ```docker-compose build``` - builds docker containers.
* ```docker-compose up -d``` - restarts docker containers.
* ```composer install``` - installs all dependencies
* ```docker exec php bin/console doc:mig:mig --no-interaction``` - runs db migrations.

### Important!

#### Issue:

The issue might occur when setting up the env on docker - according to ```https://github.com/doctrine/DoctrineMigrationsBundle/issues/393``` and the issue seems to occur on PHP8.0 and higher.

**Although the issue appears the database migrations run properly.**

## Documentation:

### List of endpoints:

2. http://localhost:8080/api/wallet/create - Creating a wallet                          	
3. http://localhost:8080/api/wallet/add-amount/{id}/{amount} - Adding amount from wallet
4. http://localhost:8080/api/wallet/subtract-amount/{id}/{amount} - Subtracting amount from wallet
5. http://localhost:8080/api/wallet/get-amount/{id} - Getting amount from wallet

### Command: 

1. ```docker exec -it php /bin/bash``` - accessing docker php container
2. ```bin/console app:export-csv <wallet_id>``` - Generating CSV file of Operations that belongs to wallet

### PHP Unit Tests:

1. ```docker exec -it php /bin/bash``` - accessing docker php container
2. ```bin/phpunit tests/Unit``` - runs unit tests