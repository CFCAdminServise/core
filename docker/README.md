Configure the hosts file
```bash
$ sudo nano /etc/hosts
```
add new line
```bash
127.0.0.1 cfc-admin.local
```

Run the project environment run
```bash
$ docker-compose up
```
To get in to the container as non root user run
```bash
docker exec -it cfc_admin_php_1 su dev
```
