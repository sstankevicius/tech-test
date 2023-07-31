## Cyberhawk test


### Setup
Docker dependencies, run the following command:
```bash
docker run --rm \
-u "$(id -u):$(id -g)" \
-v $(pwd):/var/www/html \
-w /var/www/html \
laravelsail/php81-composer:latest \
composer install --ignore-platform-reqs
```
Next start the containers:
```bash
sail up
```
Compile the assets:
```bash
sail yarn run dev
```
Run the migrations:
```bash
sail artisan migrate
```
Seed the database:
```bash
sail artisan db:seed
```
Run the tests:
```bash
sail artisan test
```

### Not started, but was planning to do:
As of now, API authentication and authorization have not been implemented. The plan was:
- Use Laravel Passport to implement OAuth2 authentication
- Protect API endpoints with auth:api middleware
- Implement API authorization to control user access to endpoints
- Add the access token in API request's headers from the front-end side.

### Another possible improvements:
- Add rate limiting to the API.
- Add more tests.
- Create full CRUD for the API endpoints.
- Add more validation rules to the API endpoints.
- Use DTOs for validating and structuring the data. (Easier to transfer data between layers)
