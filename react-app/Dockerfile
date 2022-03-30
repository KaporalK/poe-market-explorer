FROM node:16-alpine as builder
WORKDIR '/app'
COPY package*.json ./
RUN npm install
COPY . .
#RUN echo "fs.inotify.max_user_watches=524288" >> /etc/sysctl.conf
RUN npm run build

FROM nginx
COPY --from=builder /app/build /usr/share/nginx/html