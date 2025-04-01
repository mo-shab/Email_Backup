# Email Management System

A web application built with Laravel, Filament, and Livewire that allows users to manage multiple email accounts and interact with their email configurations and folders.

## Features

### User Features
- **User Authentication**: Secure registration, login, and password reset functionalities.
- **Email Account Management**: Add and manage multiple email accounts with SMTP and IMAP configurations.
- **Email Configuration Testing**: Test email settings to ensure configurations are correct.
- **IMAP Folder Management**: Fetch and view available IMAP folders associated with email accounts.
- **Email Fetching**: Retrieve emails from selected folders in email accounts.
- **Profile Management**: Update personal profile information.

### Admin Features
- **Admin Dashboard**: Manage all users through CRUD operations.
- **Role-based Access Control**: Different roles with varying access levels (Admin, User).

## Requirements
- PHP 8.0 or higher
- Laravel 10.x or higher
- Composer
- MySQL or any compatible database
- Node.js (for running frontend assets)

## Installation

1. **Clone the Repository**  
   ```bash
   git clone https://github.com/your-username/email-management-system.git
   cd email-management-system

2. **Install Dependencies**
    ```bash
    composer install
    npm install

3. **Configure Environment Variables**
