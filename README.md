##STS Recruitment

##Project setup on docker

```./docker/setup.sh``` - run this script to setup the project. This command will run underneath: 

* ```docker-compose build``` - builds docker containers.
* ```docker-compose up -d``` - restarts docker containers.
* ```composer install``` - installs all dependencies
* ```docker exec sts_php bin/console doc:mig:mig``` - runs db migrations.

###Important:

Just for recruitment purposes and quick project setup I added all environmental variables in .env file although I know it is good practise to keep them in .env.local file.