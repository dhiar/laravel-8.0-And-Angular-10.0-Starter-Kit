<div align="center">
	<img src="./logo.png" width="400" alt="Laravel + Angular Logo"/>
</div>

# Laravel + Angular + Ngrx (State Management) + i18n Admin Template
Quick start With Admin Template for Laravel 8.0 + Angular 10.0 With NGRX projects with JWT auth.

## Includes:

### Front-end:
- Angular CLI boilerplate files
- JWT authentication service
- Login components
- i18n


<div>
	<img src="./logo.png" width="800" alt="Laravel + Angular Logo"/>
</div>
<div >
	<img src="./logo.png" width="800" alt="Laravel + Angular Logo"/>
</div>
<div >
	<img src="./logo.png" width="800" alt="Laravel + Angular Logo"/>
</div>

### Back-end:
- Composer build file
- Boilerplate files
- JWT authentication

## Server
- Go to `Server` folder and run `composer install` to install dependencies.

- Set your DB connections in `.env`

- run `php artisan key:generate` to generate app key.

- In migrations, the default user is created for which username is **"admin@admin.com"** and password is **"12345qwe"**.

## Client
- Open *Client* folder in terminal/console and run `npm install` to install all dependencies.

- Add URL to your local server to  `/Client/src/environments/environment.ts`.

- Run `ng serve` for a dev server. Navigate to `http://localhost:4200/`. The app will automatically reload if you change any of the source files.

## License: [MIT](https://opensource.org/licenses/MIT)
