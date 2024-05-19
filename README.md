# Laravel StackOverflow Search

This Laravel project provides an interface to search questions on Stack Overflow using its public API.

## Features

- **Question Search:** Users can search for questions on Stack Overflow by providing optional tags and dates.
- **Cache Storage:** Repeated queries are stored in the database to avoid redundant calls to the Stack Overflow API.
- **Responsive User Interface:** The user interface adapts to mobile and desktop devices.

## System Requirements

- PHP >= 7.3
- Composer
- MySQL

## Facility

1. Clone this repository to your local machine:

git clone https://github.com/ArellanoF/apiQuestionStackOverFlow

2. Navigate to the project directory:

3. Install PHP dependencies with Composer:
composer install

4. Copy the .env.example file and rename it to .env:

5. Generate a new application key:
php artisan key:generate

6. Run the migrations to create the database tables:
php artisan migrate

7. Start the development server:
php artisan serve

8. Visit http://localhost:8000/ in your browser to view the application.

## Use
- On the http://localhost:8000/search page, enter the search tags and optionally the start and end dates.
- Click the "Search" button to search for questions on Stack Overflow.
- The results will be shown in the collapse.
- You can click on any question to see more details on the Stack Overflow site.

![Alt Text](https://i.ibb.co/4m61pHd/Api-Stack-Hechocon-Clipchamp-ezgif-com-video-to-gif-converter.gif)

![Alt Text](https://i.ibb.co/BBdTpjm/Api-Stack-Hechocon-Clipchamp-ezgif-com-video-to-gif-converter-1.gif)

![Alt Text](https://i.ibb.co/xYxsBHx/Api-Stack-Hechocon-Clipchamp-ezgif-com-video-to-gif-converter-2.gif)



