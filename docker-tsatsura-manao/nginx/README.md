## Instructions for launching the application

### 1. First of all you need to create docker containers:

 - Open out terminal in directory `Manao-test-task`
 - Run the following commands in the terminal:   
   ``` 
   cd docker-tsatsura-manao
   docker-compose up
   ```
 - Log in to the container terminal by running the command:
   ```
   docker exec -it tsatsura-app bash
   ```
 - Install the Compositor dependencies:
   ```
   composer install
   ```

   That's it! The application is available at `http://localhost:8000/`