# Docker-LAMP - Docker set-up for PHP, Apache, MariaDB development.

  
To run the server you need [Docker](https://docs.docker.com/desktop/).
After installation just run ```docker-compose up -d```

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