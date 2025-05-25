# WEB PEMINJAMAN BARANG BERBASIS PHP NATIVE
### Tech stack:
- PHP 7.4
- Bootstrap 5
- JQuery 3.7
- SweetAlert 2


### HOW TO RUN:
1. Don't forget to adjust .env file
2. Build app with docker
```sh
     docker build -t web-inventory:latest -f containerized/Dockerfile .
```
3. Run Application
- With Docker
```sh
    docker run -d -p 8000:80 -v /mnt/img:/var/www/html/public/assets/img /mnt/sessions:/var/www/html/sessions --name "web-inventory" web-inventory 
```
- With Kubernetes:
```
    kubectl create secret generic web-inventory-env --from-env-file=.env
    kubectl apply -f kubernetes/pv-pvc.yaml
    kubectl apply -f kubernetes/deployment.yaml
    kubectl apply -f kubernetes/service.yaml
    kubectl apply -f kubernetes/ingress.yaml
```
