# Docker - My Lamp

This project consists of two conatienrs. One for the Apache server and one for MySQL. The apache container includes Apache and PHP running on CentOS 6. The MySQL container includes MySQL 5 runing on Debian Jessie.

## Container Names
my-lamp-web  
my-lamp-db  

## Setup Steps

1. Build the custom my-lamp image.
    ```
    docker-compose build
    ```

2. Start up the containers.
    ```
    docker-compose up -d
    ```

## Other Helpful Docker Commands

### Poll Log Files
    docker logs -f my-lamp-web
    docker logs -f my-lamp-db



