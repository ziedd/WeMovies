# WeMovies

This is a web application built with PHP 8.2 and Symfony 6.4, using Composer dependency management.
## Features

The application provides the following features:

- Lists all cinema genres on the left menu, along with the highest-rated movie for each genre, its description, and a play video option.
- Allows selection of a genre to display a new list of movies corresponding to the selected genre.
- Provides a pop-up with detailed information about a movie and its video when a movie is clicked.
- Includes a search bar with autocomplete functionality for searching movies.## Project Structure

The project has the following structure:

- `src/`: This directory contains all the PHP source code for the application.
- `Controller/`: Contains all the controllers for the application.
- `model/`: Contains all the model classes input /output for the application.
- `Services/`: Contains all the service classes for the application.
- `handlers/`: Contains all the handler classes used by moviesController for the application.
- `templates/`: This directory contains all the Twig template files.
- `tests/`: This directory contains all the test files.
- `docker/`: Contains Docker configuration files.
- `Makefile`: Contains commands for quality checks and linting.
- `composer.json`: Specifies the PHP dependencies of the application.
- `package.json`: Specifies the JavaScript dependencies of the application.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes

### Prerequisites

- Composer
- Docker

### Installing

1. Clone the repository
```bash
git@github.com:ziedd/WeMovies.git
```

### Configuration
add your  API key to the .env file
```bash
API_KEY=your_api_key
```

### Installation of the project dependencies
```bash
cd WeMoviesdocker/project
docker-compose up -d
```
## Quality Checks and Linting

This project uses a Makefile to run quality checks and linting. You can use the following commands:

### PHP CodeSniffer (for PHP linting)

```bash
make cs_fix
```
### PHPStan (for PHP static analysis)

```bash
make phpstan
```
### The Makefile for this project can be found [here](./Makefile).
