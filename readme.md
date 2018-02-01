# About quizapp

An api for authenticating users of a mobile quiz application. 
> Laravel 5.5 API that uses the API resources

## Endpoints

### Register a new user
```
- POST [api/signup]
accepts: username, email, password
```
### Login a new user
```
- POST  [api/signin]
accepts: username/email, pasword
```

# Usage

```
git clone te app

cp .env.example .env

configure your database 

run - php artisan migrate
```
Done!

## Social login integration yet to be implemeted
