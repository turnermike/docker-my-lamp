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

### SSH Into Containers
    docker exec -it my-lamp-web bash
    docker exec -it my-lamp-db bash

# AWS EC2 Deployments

## Create ECS Cluster

1. Select EC2 Container Services from the main menu.
2. Select Clusters from te Amazon ECS menu (left).
3. Click the Create Cluster button, enter a name (my-lamp-cluster), click Create.
4. 

# Credits/Thanks
Running Docker on AWS From the Ground Up
http://www.ybrikman.com/writing/2015/11/11/running-docker-aws-ground-up/#deploying-docker-containers-on-ecs