# Listeem

Welcome to Listeem! 🚀 

Listeem is a simple to-do list web app.

Among the many to-do list tools already available, it's not always easy to find one that suits our needs. Options are either overloaded with features or lack essentials. Listeem was therefore designed with an emphasis on simplicity and the essentials for effective to-do list management.

## Screenshot

![image](https://github.com/timothepoznanski/listeem/assets/8541705/33045511-cffc-4ab0-a7b9-11105beca31f)

## Installation

To get started, follow these steps:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/timothepoznanski/listeem.git
    ```

2. **Navigate to the project directory:**
 
    ```bash
    cd listeem
    ```

3. **Create your configuration:**
    
    Copy the `env_template` file to a `.env` file.
    
    Modify the `.env` file with your settings following instructions commented in the file.


4. **(Optional) Add your own SSL certificate for HTTPS:**
    
    Add your `privkey.pem` and `fullchain.pem` files to the `ssl` folder. 
    
    /!\ They have to be named exactly `privkey.pem` and `fullchain.pem`.

    Uncomment `SSL_CERT_FILE=/etc/apache2/ssl/fullchain.pem` and `SSL_KEY_FILE=/etc/apache2/ssl/privkey.pem` in `.env` file.

5. **Run the application:**
   
     ```bash
    docker compose up -d

    ou

    podman-compose up -d
   
    ```

    Now, the Listeem application should be up and running. 

6. **Open the application:**

    To view it in HTTP, open your web browser and visit:

    `http://YOUR-SERVER-DOMAIN:YOUR-HTTP-PORT`

    To view it in HTTPS (with the self signed certificate or your own certificate), open your web browser and visit:

    `https://YOUR-SERVER-DOMAIN:YOUR-HTTPS-PORT`

7. **Connect to the application:**

    Connect with default password `listeem` or the password you provided in the .env file.

## Updates

If you want to keep your container but change something into the config file (your password for example), stop and remove your running container (don't worry, your data are stored on your host), update your .env file and run the step 5 (Run the application). This will launch a new container from the image already present on your host but will also use the new .env config file.

## Contributing

If you want to contribute to the code, don't hesitate to open a pull request. Thanks!

## Possible errors

**Case 1**

 ```bash
BDD connection error : Connection refused
 ```

or 

 ```bash
Fatal error: Uncaught Error: Call to a member function execute()
 ```

Three possible reasons to this error:

1. The database is still initializing
3. It is a browser cache issue
4. The server runs out of memory
   
Wait a few seconds, visit another web page and come back.

**Case 2**

 ```bash
Bad Request
 ```

You are probably trying to open the url on HTTPS port (probably 8078). Add 'https://' in front of your url or change port to HTTP port (probably 8077).
