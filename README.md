# Clone Repository
Go to your terminal and clone the repository:
```sh
git clone https://github.com/p2c6/admin-dashboard.git
```

After cloning the repository,go to the **admin-dashboard** directory:

```sh
cd admin-dashboard
```

Once you're in the **admin-dashboard** directory, setup the **frontend** and **backend**.


## Setup Frontend

**Note:** Make sure you're inside the **admin-dashboard** directory

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

After setting up frontend, you can check the frontend app which runs on **http://localhost:3000**

## Setup Backend

**Note:** Make sure you're inside the **admin-dashboard** directory 

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

Don't forget to edit your database in your **.env**, the database default name in your **.env** is **backend** but you can edit it based on your preference:
```sh
DB_DATABASE=backend
```

After setting up .env, link the storage with the command below:

```sh
php artisan storage:link
```

**Note:** Before running the migration and the seeder, please make sure you created your empty database  in your database administration tools like **phpMyAdmin**. Also, make sure the name of your database is the same with your **.env** file.

Run the migration and the seeder:

```sh
php artisan migrate:fresh --seed
```



Lastly, run the server with the command below:
 
```sh
php artisan serve
```

After backend setup, you can check the backend which runs on **http://localhost:8000**

## Note

If you encounter problem, try clearing the cache, etc., 

```sh
php artisan optimize:clear
```

Then run the server again:

```sh
php artisan serve
```

## Example user

username or email: jdoe@gmail.com or admin
password: admin123







