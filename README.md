# Picstore

Picstore is a Laravel-based app where users can create events and generate a shareable link for attendees to upload photos taken during the event, perfect for weddings, birthdays, and more.

## Features

- User Authentication (Sign Up, Log In)
- Event Creation with Unique Shareable Links
- Attendees Can Upload Photos to the Event Gallery

## Tech Stack

- **Backend:** Laravel
- **Frontend:** Blade (Laravel templating engine)
- **Database:** (Specify your database, e.g., MySQL, PostgreSQL)

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/your-username/picstore.git
    ```

2. Navigate to the project directory:
    ```bash
    cd picstore
    ```

3. Install dependencies:
    ```bash
    composer install
    ```

4. Create a `.env` file by copying `.env.example` and set your database credentials:
    ```bash
    cp .env.example .env
    ```

5. Generate the application key:
    ```bash
    php artisan key:generate
    ```

6. Run migrations:
    ```bash
    php artisan migrate
    ```

7. Serve the application locally:
    ```bash
    php artisan serve
    ```

## Usage

1. Sign up or log in.
2. Create a new event.
3. Share the generated link with event attendees.
4. Attendees can upload photos directly through the link.

## Contributing

Feel free to submit issues or pull requests to help improve Picstore.

## License

This project is licensed under the MIT License.
