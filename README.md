# Clone Repository
Go to your terminal and clone the repository:
```sh
git clone https://github.com/p2c6/admin-dashboard.git
```

After cloning the repository,go to the **admin-dashboard** directory:

```sh
cd admin-dashboard
```

Then setup the **frontend** and **backend**.


## Setup Frontend

Go to **frontend** directory:

```sh
cd frontend
```

After going to **frontend** directory, run the command below to install packages:

```sh
npm install
```

After installing packages, run your **frontend** with the command below:

```sh
npm run dev
```

## Setup Backend

Go to **backend** directory:

```sh
cd backend
```

After going to **backend** directory, run the command below to install packages:

```sh
composer install
```

**Setup ENV**

Duplicate the .env.example located in your backend root:

```sh
cp .env.example .env
```

After duplicating .**env**, you must copy these variables and paste this in your **.env** or you can manually edit the variable if existing.

```sh
APP_URL=http://localhost:8000
SESSION_DOMAIN=localhost
SANCTUM_STATEFUL_DOMAINS=localhost:8000,localhost:3000
```

Don't forget to edit your database in your **.env**, the database default name in your **.env** is **admin_dashboard** but you can edit it based on your preference:
```sh
DB_DATABASE=admin_dashboard
```

After setting up .env, link the storage with the command below:

```sh
php artisan storage:link
```

Then run the migration and the seeder:

```sh
php artisan migrate:fresh --seed
```

Lastly, run the server with the command below:
 
```sh
php artisan serve
```

## Note

If you encounter problem, try clearing the cache, etc., 

```sh
php artisan optimize:clear
```

Then run the server again:

```sh
php artisan serve
```







