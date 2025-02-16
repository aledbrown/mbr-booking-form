### About
- An example Livewire booking form component

### Requirements
- Laravel ^11.42.1
- PHP 8.3.16
- SQLite

### Setup Information
- For macOS running Laravel Herd (correct at time of writing)
- Open Terminal.app on macOS then run the following commands
>- cd ~/Herd
>- git clone git@github.com:aledbrown/mbr-booking-form.git
>- cd mbr-booking-form
>- cp .env.example .env
>- optional: set environment to production
>- touch database/database.sqlite
>- composer install
>- npm install
>- npm run build
>- php artisan key:generate
>- php artisan migrate:refresh --seed
>- Optional - open Herd > Sites and add SSL Certificate to mbr-booking-form.test
>- Open http://mbr-booking-form.test
