# Landing page materialessanotilio.mx

### CLonar el repositorio
```bash
git clone git@github.com:OzzMkl/site-sanotilio-astro.git
```

### Tener instalado docker

### Crear carpetas

```bash
# Crear el directorio para los desafíos de Certbot
mkdir -p certbot/www

# Crear el directorio para los certificados y claves de Certbot (donde Certbot guarda privkey.pem, fullchain.pem)
mkdir -p certbot/conf

# Crear el directorio específico para la configuración SSL de Nginx
mkdir -p nginx/ssl
```

### Generar ssl-dhparams.pem y crear options-ssl-nginx.conf
```bash
# Generar ssl-dhparams.pem dentro de la carpeta nginx/ssl
openssl dhparam -out nginx/ssl/ssl-dhparams.pem 2048

# Crear el archivo options-ssl-nginx.conf
# Puedes copiar el contenido recomendado de Mozilla (Modern) aquí:
# https://ssl-config.mozilla.org/
# (Ejemplo de cómo crear el archivo directamente)
nano nginx/ssl/options-ssl-nginx.conf
# Pega el contenido recomendado y guarda.
```

### Primera vez para produccion
Revisar el archivo nginx-ssl.conf
y comentar los bloques sugeridios, luego levantar los contenedores
```bash
docker compose up -d --build nginx astro
```

### Generar certificados
```bash
docker run -it --rm \
  -v "$(pwd)/certbot/www:/var/www/certbot" \
  -v "$(pwd)/certbot/conf:/etc/letsencrypt" \
  certbot/certbot certonly --webroot \
  -w /var/www/certbot \
  -d materialessanotilio.mx \
  --email email@dominio.mx \
  --agree-tos --no-eff-email
```

Si todo sale bien debería decir "Successfully received certificate." 
Descomentamos los bloques que previamente se comentaron en 'nginx-ssl.conf' y reiniciamos el contenedor de nginx

```bash
docker compose restart nginx
```

