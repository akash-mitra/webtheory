## Installation

Follow the steps below

- Clone this repository: `git clone https://github.com/akash-mitra/webtheory.git`. This will create a new directory in your local machine named "webtheory". (If the above step does not work, try providing github username:password)
- `cd webtheory`
- Run `composer install`
- Run `npm install`
- Run `cp .env.example .env`
- Run `php artisan key:generate`
- Run `php artisan storage:link`
- Run `mkdir -p public/storage/media`
- Run `cp Fs6MxfFgtrVhGgulEVZ0THdb0CYOyrW5wIZW3sS9.png public/storage/media`

Browse `/admin/pages/create`

### optional installation steps


- Run `valet secure` from within the webtheory directory.
- php artisan migrate 
- etc.

(Since currentlyn only front-end code, above steps are not needed. Once backend code is added, please enable them)

### Push code
`git add --all`
`git commit -m "commit comments"`
`git push`

To bring new changes from the `master`, `git pull`
