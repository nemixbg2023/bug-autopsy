# Bug Autopsy 🧪

Bug Autopsy is a Laravel application focused on **structured bug investigation**.

Instead of treating bugs as simple tickets, each bug is analyzed through a clear thinking process:
- hypothesis
- experiment
- finding
- final conclusion

## Core Domain Rule

A `BugReport` can have **many entries**, but **only one conclusion**.

This rule is:
- enforced inside the domain model
- protected by automated tests
- impossible to bypass accidentally

## Why this project exists

Most bug trackers store *what* happened.
Bug Autopsy stores *how you thought* while fixing the bug.

The goal is to make debugging:
- explicit
- reviewable
- repeatable

## The Stack

- Laravel 12
- PHP 8.4
- SQLite (local development)
- Domain-driven rules
- Feature tests for business invariants

## Local Setup (Laravel Herd)

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate

```

## Open in browser


http://bug-autopsy.test



## Running Tests

```bash
php artisan test
```

## Project Status

This repository represents a **finished MVP**.

- Core domain model is defined
- Business rules are enforced in code
- Critical behavior is protected by automated tests


Further extensions are inentionally left out.
