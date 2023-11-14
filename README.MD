# Listeem

Welcome to Listeem! 🚀 

Listeem is a simple to-do list web app.

Among the many to-do list tools already available, it's not always easy to find one that suits our needs. Options are either overloaded with features or lack essentials. Listeem was therefore designed with an emphasis on simplicity and the essentials for effective to-do list management.

![capture](https://github.com/Pozinux/listeem/assets/8541705/486ac670-24b8-46b8-bc7d-1b7ae5619f63)

## Table of Contents
- [Features](#features)
- [Installation](#installation)

## Features

Check out some features of Listeem at [Features Link](https://listeem.com/features.php)!

## Docker application - production version

Listeem is provided in the form of a Docker container publicly stored on Docker Hub. 

See [Docker application - Production version](https://hub.docker.com/r/pozinux/listeem)

## Installation of developpement version

To get started, follow these steps:

1. **Clone the repository:**
    ```bash
    git clone https://github.com/pozinux/listeem-app.git
    ```

2. **Navigate to the project directory:**
 
    ```bash
    cd listeem-app
    ```

3. **Create your configuration:**
    
    Copy the `env_template` file to a `.env` file.
    
    Modify the `.env` file with your settings following instructions commented in the file.

4. **(Optional) Add your own SSL certificate for HTTPS:**
    
    Create a folder named `ssl` and add your `privkey.pem` and `fullchain.pem` files to this folder. They have to be named exactly this way.

At this step, you should have the following directories and files:

![image](https://github.com/Pozinux/listeem/assets/8541705/e9ed9198-04bd-4a8d-88ec-b27e5c2adc80)

5. **Run the application:**
   
    ```bash
    docker compose up -d
    ```

Now, the Listeem application should be up and running. 

To view it in HTTP, open your web browser and visit:

`http://your-server-domain:8077`

To view it in HTTPS (with the self signed certificate or your own certificate), open your web browser and visit:

 `https://your-server-domain:8078`

## Possible errors

**Case 1**

 ```bash
    BDD connection error : Connection refused
 ```

The database is probably still initializing. Wait a few seconds and refresh the page.

**Case 2**

 ```bash
    Bad Request
 ```

You are probably trying to open the url on HTTPS port (probably 8078). Add 'https://' in front of your url or change port to HTTP port (probably 8077).
