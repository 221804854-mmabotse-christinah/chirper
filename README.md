<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# Chirper Blog

Chirper is a micro-blogging platform that allows users to post short messages (chirps) with the ability to include images, formatted text, and links. Users can also comment on chirps. This project demonstrates a Laravel-based application with a modern frontend using Tailwind CSS and Alpine.js.

## Technologies and Frameworks Used

- **Backend:**
  - [Laravel](https://laravel.com/) - PHP Framework
  - [MySQL](https://www.mysql.com/) - Database

- **Frontend:**
  - [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS framework
  - [Alpine.js](https://alpinejs.dev/) - Minimal JavaScript framework for adding interactivity

- **Tools:**
  - [Composer](https://getcomposer.org/) - PHP dependency manager
  - [NPM](https://www.npmjs.com/) - Node package manager

## Setup and Installation Instructions

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/yourusername/chirper.git
    cd chirper
    ```

2. **Install Backend Dependencies:**

    Ensure you have Composer installed. Then run:

    ```bash
    composer install
    ```

3. **Install Frontend Dependencies:**

    Ensure you have Node.js and NPM installed. Then run:

    ```bash
    npm install
    ```

4. **Environment Configuration:**

    Copy the `.env.example` file to `.env` and update the environment variables as necessary (e.g., database settings):

    ```bash
    cp .env.example .env
    ```

5. **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

6. **Database Migration:**

    Run the following command to migrate the database:

    ```bash
    php artisan migrate
    ```

7. **Run the Development Server:**

    ```bash
    php artisan serve
    ```

    You can now access the application at `http://127.0.0.1:8000`.

8. **Compile Assets:**

    For development:

    ```bash
    npm run dev
    ```

    For production:

    ```bash
    npm run production
    ```

## How to Use

1. **Creating a Chirp:**

   - Navigate to the homepage.
   - In the "What's on your mind?" textarea, write your message.
   - (Optional) Upload an image by clicking the "Choose File" button.
   - Click the "Chirp" button to post your chirp.

2. **Commenting on a Chirp:**

   - Below each chirp, there is a comment section.
   - Write your comment in the "Add a comment..." textarea.
   - Click the "Comment" button to post your comment.

3. **Editing and Deleting Chirps:**

   - If you are the owner of a chirp, you will see an "Edit" and "Delete" option.
   - Click "Edit" to modify your chirp or "Delete" to remove it.

4. **Viewing Chirps:**

   - The homepage displays the latest chirps with pagination support.
   - You can see the username, time of posting, and the chirp content including images.

## Additional Features

- **Session-Based Notifications:** Success and error messages are displayed using Alpine.js for interactivity.
- **Responsive Design:** The application is designed to be responsive using Tailwind CSS.
- **Image Uploads:** Images uploaded with chirps are stored in the public storage and displayed alongside chirps.
- **Formatted Text:** Chirps can include formatted text to enhance readability.
