

GO to [./php-app](./php-app) and [./react-app](./react-app) and run `docker-compose up` both at the same time
the first time should take some time to build the images but it's normal.
When the apps are ready you can go at [https://localhost](https://localhost) to see the backend and [http://localhost:3000](http://localhost:3000) for the front. 
The bdd is at [http://localhost:8081](http://localhost:8081)

Finaly you should run `docker-compose exec php php bin/console poe:populate-bdd:mongo -vvv` to fill up the bdd