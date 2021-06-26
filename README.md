## Music Shiksha

Steps to install this project

- Clone the repository
- Move to the project folder
- composer install
- npm install
- npm audit fix
- Create a database with any name you prefer
- cp .env.example .env
- Update .env file with database details
- php artisan optimize
- php artisan view:cache
- php artisan migrate
- composer dump-autoload
- php artisan db:seed
- npm run dev

# Development Plan

- Create git branches as per the task types. Eg. feature/* bugfix/* etc from develop branch and start working on it.
- Once you finish a task you can push it to the remote
- I will check it and if working you can start developing another task.
- Always take a pull from develop branch before creating a branch from it. Develop branch will always have the latest code

# Login credentials

- Super Admin (superadmin@example.com / password)
- Admin (admin@example.com / password)
- Tutor (tutor@example.com / password)
- Student (student@example.com / password)
