# Docker-LAMP - Docker set-up for PHP, Apache, MariaDB development.
*(LAMP  - Linux Apache MySQL (MariaDB) PHP)*
*This setup allows you to quickly create a development environment for LAMP-based web applications using Docker containers. It's a convenient and portable way to work on web projects in a consistent environment.*


This is strictly for Linux, but can be ran on Windows, using [WSL](https://learn.microsoft.com/en-us/windows/wsl/install), but then why use something designed for Linux, when you can use it designed for Windows? :)
  
To run the server you need [Docker](https://docs.docker.com/desktop/).
After installation of Docker run `./start-docker.sh` to set your `MYSQL_ROOT_PASSWORD` in `docker-compose.yaml`.
Then put your files in `www/` folder  and run ```docker-compose up -d``` to start building the Docker service up.


You can always change the ports and root password by running the script or by doing it manually in docker compose file. (Which is preferred!)



---
lamp  
 ┣ apache_docker  
 ┃ ┣ Dockerfile  
 ┃ ┗ apache-vhost.conf  
 ┣ php_docker  
 ┃ ┗ Dockerfile  
 ┣ www  
 ┃ ┗ index.php  
 ┣ README.md  
 ┗ docker-compose.yaml

