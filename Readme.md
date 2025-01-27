
# Laravel + Vue 3 Tech test

A small web application with Auth0 integration that displays all countries and their respective flags in a single page layout.

# Installation
## 1. Clone the repository
Find a location on your computer where you want to store the project. A directory made for projects is generally a good choice.

Launch a bash console there and clone the project.

`git clone https://github.com/david-buzas/tech-test-laravel-vue`

## 2. cd into the project and create auth config files
You will need to be inside the project directory that was just created, so cd into it.

`cd project_name`

Now, you need to create two json files where the auth0 configuration will be stored. 

Name these empty files to:
- .auth0.app.json
- .auth0.api.json


## 3. Start the service
Run the following command to deploy services.

`docker-compose up -d nginx`

This will install all the services.

The following services will be deployed and please make sure that the required ports are available:
- nginx on port 8090
- redis cache on port 6379
- vue on port 5173

## 4. Bash to back-end box
Once the deployment is completed and the services are running, bash into the laravel back-end box with the following command:

`docker exec -it <container-id> bash`

In order to find the respective container id, run the following command:

`docker ps`

and search for back-end-laravel container name
## 5. Configure Auth0
When you are in the box, the next step is to configure Auth0. To do that, you need to follow the next instructions.

### 5. a) Login to auth0
Run the following command and select as user in the prompt.

`./auth0 login`

This will require you to open the prompted link in your browser and grant all the necessary permission.
### 5. b) Create auth0 apps
Now run the next command:

`./auth0 apps create \
--name "My Laravel Application" \
--type "regular" \
--auth-method "post" \
--callbacks "http://localhost:8090/callback" \
--logout-urls "http://localhost:8090" \
--reveal-secrets \
--no-input \
--json > .auth0.app.json
`

Note: You can change the name of apps to any of your choice.

### 5. c) Create auth0 apis
Finally, run the last command:

`./auth0 apis create \
--name "My Laravel Application's API" \
--identifier "https://github.com/auth0/laravel-auth0" \
--offline-access \
--no-input \
--json > .auth0.api.json`

Note: You can change the name of apis to any of your choice.

## 6. Open the application
When you are done with all the steps above, open this link in your browser `http://localhost:8090` and Auth0 will ask you to authenticate yourself. Once it's done, the page will render with the countries' names and their respective flags.


