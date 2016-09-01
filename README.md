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

## Create Security Group (only need to do this once)

## Create Key/Pair (only need to do this once)


## Create ECS Cluster

1. Select EC2 Container Services from the main menu.
2. Select Clusters from the Amazon ECS menu (left).
3. Click the Create Cluster button, enter a name (my-lamp-cluster), click Create.

## Create an Elastic Load Balancer (ELB)
1. Select EC2 from the main menu.
2. Select Load Balancers from the EC2 Dashboard menu (left).
3. Click the Create Load Balancer button.
4. Select Classic Load Balancer, then click the Continue button.
5. Enter a Load Balancer Name (my-lamp-load-balancer). Leave other settings at default.
6. Click the Next: Assign Security Groups button.
7. Choose Select an existing security group. Select your desired security group (my-lamp-load-balancer).
8. Click the Next: Configure Security Settings button.
9. Ignore any warnings at this step and click the Next: Configure Health Check button.
10. Leave all default settings except for Ping Path, change to "/".
11. Click the Next: Add EC2 Instances button.
12. We will add EC2 instances using an Auto Scaling Group, so skip this step by clicking Next: Add Tags.
13. No tags needed, click the Review and Create button.
14. Click the Create button and then click Close.
15. Done, here you should see the new load balancer.

## Creating IAM Roles

Later we will be creating new EC2 Instances. These EC2 Instances need to be registered with a ECS Cluster. By default, EC2 Instances do not have permissions to talk to an ECS Cluster. We need to create a IAM Role (identity with set of permissions) and attach it to the EC2 Instance.

1. Select IAM from the main menu.
2. Select Roles from the Dashboard menu (left).
3. Click the Create New Role button.
4. Enter a Role Name (ecs-instance-role), then click the Next Step button.
5. From the list of AWS Service Roles, click the Select button for Amazon EC2.
6. Search for AmazonEC2ContainerServiceforEC2Role and select the checkbox for it. Click the Next Step button.
7. Click the Create Role button.
8. Done, here you should see the new role listed.

We will need to create a similar IAM Role to allow the ECS Cluster to talk to the ELB.

1. Click the Create New Role button.
2. Enter a Role Name (ecs-service-role), then click the Next Step button.
3. From the list of AWS Service Roles, click the Select button for Amazon EC2 Container Service Role.
4. Select the checkbox next to AmazonEC2ContainerServiceRole. Click the Next Step button.
5. Click the Create Role button.
6. Done, you should now have two IAM Roles.

## Create an Auto Scaling Group

1. Select EC2 from the main menu.
2. Select Auto Scaling Groups from the EC2 Dashboard menu (left).
3. Click the Create Auto Scaling Group button.

The first step in creating an Auto Scaling Group is to define a Launch Configuration. Which is a reusable template that defines what kind of EC2 Instances the Auto Scaling Group should launch, including AMI, instance type, security group and other detials.

4. Click the Create launch configuation button.
5. Select the AWS Marketplace tab (left).
6. Search for/locate Amazon ECS-Optimized Amazon Linux AMI and click the Select button.
7. Select t2.micro Instance type for the free tier.
8. Click the Next: Configure details button.
9. Give the Launch Configuration a name (ecs-launch-configuration).
10. Select the instance IAM Role created earlier (ecs-instance-role).
11. Click Advanced Details and locate the text field labeld User data and enter the following shell script:
```
    #!/bin/bash

    echo ECS_CLUSTER=my-lamp-cluster > /etc/ecs/ecs.config
```
**NOTE: Be sure to change the ECS_CLUSTER variable to your cluster name.**

User data is a place you can add custom shell scripts that the EC2 Instance will run right after booting. The shell script above puts the name of your ECS Cluster (my-ecs-cluster) into the ```/etc/ecs/ecs.config``` file. The ECS Container Agent knows to look into this file, so this is how you provide it the name of your ECS Cluster. If no name is specified, the Agent will use Default.

12. Leave all other default settings and click the Next: Add Storage button.
13. Leave all the default Storage configuration options and click the Next: Configure Security Group button.
14. Choose Select an existing security group.
15. Select the checkbox for the Security Group we previously created (ssh-http-anywhere).
16. Click the Review button.
17. Click the Create launch configuration button.
18. Select Choose an existing key pair from the first select field.
19. Select your previously created key pair (mturner-key-pair-useast1).
20. Select the checkbox for I acknowledge that I have access...
21. Click the Create launch configuration button.

Now that you’ve created a Launch Configuration, AWS should take you to a screen that is prompting you to create an Auto Scaling Group from that Launch Configuration. 

1. Enter a Group name (ecs-auto-scaling-group).
2. Enter a Group size of 5. This will tell the Auto Scaling Group to initially launch 5 EC2 Instance.
3. Select your desired Subnets. 
4. Click the Next: Configure scaling policies button.
5. Select Keep this group at its intial size.
6. Click the Review button.
7. Click the Create Auto Scaling group button.
8. Click the Close button.
9. Done, here you should see your new Auto Scaling Group.

Initially, the Auto Scaling Group will show 5 “Desired Instances”, but 0 actually launched Instances. If you wait a minute and refresh the list, the number of launched Instances will go to 5. Head back to the ECS Console, and you should now see five “Registered Container Instances” in your ECS Cluster:


# Credits/Thanks

Most of this was stolen from: 

Running Docker on AWS From the Ground Up
http://www.ybrikman.com/writing/2015/11/11/running-docker-aws-ground-up/#deploying-docker-containers-on-ecs
