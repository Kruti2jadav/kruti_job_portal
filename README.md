 # Job Portal Laravel Project

## Overview

This is a simple **Job Portal application** built with Laravel. It allows:

* **Candidates** to upload resumes, add skills, and apply for jobs
* **Recruiters** to post jobs, evaluate candidates, and view leaderboards
* **Reviwers** to review the application of candidate
* **Automated skill evaluation** and score-based ranking

---

## Requirements

* PHP >= 8.1
* Composer
* MySQL or SQLite
* Node.js & npm (optional, for frontend assets)
* Git (for version control)

---

## Installation

1. **Clone the repository**

```bash
git clone https://github.com/yourusername/job-portal-laravel.git
cd job-portal-laravel
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install dependencies (if using frontend assets)**

```bash
npm install
npm run dev
```

4. **Copy environment file and configure**

```bash
cp .env.example .env
```

Update database credentials in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

5. **Generate application key**

```bash
php artisan key:generate
```

6. **Run migrations**

```bash
php artisan migrate // or can do without migration too
```

7. **Serve the application**

```bash
php artisan serve
```

The app will be available at [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Usage

### Recruiter

* Login as **recruiter**
* Post jobs and view candidate applications
* View **Leaderboard** filtered by skills
* Review candidate technical and HR scores

### Candidate

* Login as **candidate**
* Upload resume and add skills
* Apply for jobs and track applications

---

## GitHub Workflow

1. Stage changes:

```bash
git add .
```

2. Commit with a descriptive message:

```bash
git commit -m "Added feature XYZ or Fixed bug ABC"
```

3. Push to repository:

```bash
git push
```

> ✅ Tip: Only push your project files, **exclude `.env`** and storage files if not needed.

---

## Notes

* `.env` contains sensitive credentials. **Do not push it to GitHub**
* After cloning, always run `composer install` and `npm install`
* Leaderboard and skill evaluation are implemented in `LeaderboardController` and candidate/job models

---

## Optional

If you want to reset database:

```bash
php artisan migrate:fresh
```

> This will drop all tables and re-run migrations
