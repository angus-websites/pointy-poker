<picture style="text-align: center;">
  <source media="(prefers-color-scheme: dark)" srcset="public/assets/images/logo/logo-light.png">
  <img alt="Bud" src="public/assets/images/logo/logo.png" width="200">
</picture>

# Bud

Bud is a boilerplate for Laravel...

- Laravel 12
- Authentication
- TailwindCSS v4
- Livewire 4
- PestPHP 4 for testing
- FluxUi components
- Privacy policy template
- Laravel boost

## Contents

- [Requirements](#requirements)
- [Paid Dependencies](#paid-dependencies)
- [Environment Variables](#environment-variables)
- [Get started with Docker (locally)](#get-started-with-docker-locally)
    - [Build and run with Docker Compose](#build-and-run-with-docker-compose)
    - [Database](#database)
- [Getting started locally (without Docker)](#getting-started-locally-without-docker)
- [Previewing Emails](#previewing-emails)
- [GitHub Actions](#github-actions)
    - [CI Workflow (`ci.yaml`)](#ciyaml)
    - [CD Workflow (`cd.yaml`)](#cdyaml)
- [Testing](#testing)
    - [Running all tests](#running-all-tests)
    - [Running tests and updating snapshots](#running-tests-and-updating-snapshots)
- [Useful notes and commands](#useful-notes-and-commands)
    - [Building the Docker image manually](#building-the-docker-image-manually)
    - [Trusted proxies](#trusted-proxies)

## Requirements

- PHP 8.3+
- Composer
- NodeJS 20+
- Docker (optional, for building images)

## Paid Dependencies

Bud uses [FluxUi](https://fluxui.dev/) pro components for the user interface. This is a paid package and a
license is
required to install the components from their private repository.

If you have a license you can create an auth.json file with your credentials.
See [Flux documentation](https://fluxui.dev/docs/installation) for more details.

use the following command to generate an empty auth.json file:

```bash
php artisan flux:activate
```

## Environment Variables

Laravel uses environment variables to configure various aspects of the application. Most of the defaults are set in the
`.env.example` file. You can copy this file to `.env` and modify it as needed.

To disable stack traces in browser set `APP_DEBUG=false` in your `.env` file.

## Get started with Docker (locally)

> **_Licence:_**  Ensure you have an `auth.json` file with a valid license to install paid dependencies
see [Paid Dependencies](#paid-dependencies)

### Build and run with Docker Compose

The following command will build and start the application using Docker Compose:

```bash
DOCKER_BUILDKIT=1 docker compose up --build
```

Visit [http://127.0.0.1:8000](http://127.0.0.1:8000 ) in your web browser to access the application.

### Database

The compose file includes a MySQL database service configured to persist data in a Docker volume.

### Mailpit

The compose file also includes a Mailpit service for previewing emails sent by the application. You can access the
Mailpit web interface at [http://localhost:8025/]

### Redis

The compose file includes a Redis service used for caching and session management.

## Getting started locally (without Docker)

1. Install PHP dependencies using Composer

   > **_Licence:_**  Some dependencies require a valid license and auth.json file to install correctly
   see [Paid Dependencies](#paid-dependencies)

    ```bash
    composer install
    ```

2. Install JavaScript dependencies using npm, or Bun
    ```bash
    npm install
    # or
    bun install
    ```
3. Copy the example environment file and configure your [environment variables](#environment-variables)
    ```bash
    cp .env.example .env
    ```
4. Generate an application key (APP_KEY) (if not already done)
    ```bash
    php artisan key:generate
    ```
5. Run database migrations
    ```bash
    php artisan migrate
    ```
6. Start Vite development server
    ```bash
    npm run dev
    # or
    bun run dev
    ```
7. Start the Laravel development server
    ```bash
    php artisan serve
    ```

## Previewing Emails

The easiest way to preview emails locally is to use MailPit. You can run a local SMTP server using Docker:

```bash
docker run -p 1025:1025 -p 8025:8025 axllent/mailpit
```

You can then configure your `.env` file to use MailPit as your mail driver:

```
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_ENCRYPTION=null
```

and then follow the link in the console to preview password reset emails and other emails sent by the application.

## GitHub Actions

The project includes two Github Actions workflows for CI/CD.

### ci.yaml

This workflow runs on every pull request to the `main` branch. It will...

1. Check you have updated the project version in `composer.json`
2. Run all the Pest tests (excluding screenshot diff tests)

#### Secrets

This workflow expects the following secrets to be set in the `Testing` environment of your repository settings:

1. `FLUX_USERNAME` - The email address associated with your FluxUi account
2. `FLUX_LICENSE_KEY` - Your FluxUi license key

### cd.yaml

This workflow runs on every push to the `main` branch. It will...

1. Build and push a Docker image to GitHub Container Registry
2. Deploy the app to a CapRover server

#### Secrets

This workflow expects the following secrets to be set in the `Production` environment of your repository settings:

1. `COMPOSER_AUTH` - The contents of your `auth.json` file for installing paid dependencies, note this secret MUST be a
   single line JSON string otherwise the workflow will fail.
2. `CAP_SERVER_URL` - The base URL of your CapRover server e.g `https://captain.yourdomain.com`
3. `CAP_APP_NAME` - The name of the app on your CapRover server e.g `Bud`
4. `CAP_APP_TOKEN` - The token for your CapRover app

## Testing

Bud uses PestPHP for testing. Tests are split into Feature and Unit tests located in the `tests/Feature` and
`tests/Unit` directories respectively.

Bud also makes use of Pest's snapshot testing capabilities for UI components. Snapshots are stored in the
`tests/.pest` directory.

### Running all tests

```bash
php artisan test --parallel
```

### Running tests and updating snapshots

```bash
php artisan test --update-snapshots
```

## Useful notes and commands

### Building the Docker image manually

Build the docker image with secret auth.json manually ...

```bash
DOCKER_BUILDKIT=1
docker build \
  --secret id=composer_auth,src=auth.json \
  -t bud .
```

### Trusted proxies

Bud is currently configured to trust all proxies by default. If you need to restrict this, you can modify the
`bootstrap/app.php` `trustProxies` method.
