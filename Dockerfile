# Utilizamos la imagen oficial de Node.js como base
FROM node:22-alpine AS build-stage

# Establecer el directorio de trabajo
WORKDIR /app

# Copiar los archivos del proyecto al contenedor
COPY package*.json ./
COPY . . 

# Instalar dependencias y construir la aplicación
RUN npm install
RUN npm run build

# Etapa de producción con Nginx
FROM nginx:alpine

# Copiar el archivo de configuración de Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Copiar los archivos de la etapa de construcción
COPY --from=build-stage /app/dist /usr/share/nginx/html

# Exponer el puerto 8080
EXPOSE 80

# Ejecutar Nginx
CMD ["nginx", "-g", "daemon off;"]
