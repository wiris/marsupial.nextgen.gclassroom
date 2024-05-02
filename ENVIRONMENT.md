# Development environment

This project has been developed using [Laravel 10](https://laravel.com/docs/10.x) and [Inertia](https://inertiajs.com/)/[Vue 3](https://vuejs.org/). The development environment is pretty standard for that stack. There are only some extra steps that need to be made for LTI and Google Classroom connections.

## Dependencies

You need to install PHP (at least 8.1) and Composer to run this project. You also need Node.js installed (20.x version is recommended).

## Google project

Create a project in the [Google Cloud Console](https://console.cloud.google.com/). Add the Google Classroom API and create OAuth credentials including all the scopes outlined in the `GOOGLE_API_SCOPES` variable of the `.env.example` file. Add `http://localhost` and `http://localhost:8000` as "Authorized JavaScript origins" and `http://localhost:8000/login/google/callback` as "Authorized redirect URIs".

Once you have the Google Client ID and the Google Client Secret, rename the file `.env.example` to `.env` and set the `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET` variables.

## Private key

The LTI protocol requires you to have a secret key to sign JWT. You can generate one with

```bash
cd storage/app
openssl genrsa -out key.pem -aes256 -passout pass:aaaa
```

Here we set a trivial passphrase `aaaa` for development purposes. Please notice a secure passkey should be used for any public deployments. If you wish to use a different passkey, update the `OIDC_KEY_PASSPHRASE` variable.

## Database

The `.env.example` file is configured to use a MySQL database with a `wiris` user with password `wiris` with all privileges granted in a table named `marsupial`. You can change this to any supported configuration supported by Laravel.

## Setting up the environment

Once you have completed all previous steps, run

```bash
composer install
npm install
php artisan migrate
```

to install all dependencies and migrate the database. Once this command is finished, on two separate terminal tabs, run

```bash
php artisan serve
```

to start up the PHP development server and

```bash
npm run dev
```

to start up vite which will provide the JavaScript HMR development server.

## Some comments about local development

Please notice that if you are connecting your local development environment agaisnt a remote LTI tool, you will need to use tools such [ngrok](https://ngrok.com/) to forward your local development server to a public URL for the JWKS and Token endpoints.
