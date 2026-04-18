# Nexus Elite - Premium E-commerce Platform

Nexus Elite is a modern, high-conversion e-commerce marketplace designed with a premium glassmorphism UI. It features a robust technical architecture, secure authentication, and a seamless shopping experience.

## Features

- **Premium UI/UX**: Stunning glassmorphism design with a custom indigo-midnight color palette.
- **Dynamic Product Management**: Categories, sub-categories, and detailed product views.
- **Shopping Experience**: Wishlist, shopping cart, and streamlined checkout process.
- **User Accounts**: Secure login, signup, profile management, and order history.
- **Admin Dashboard**: Comprehensive tools for managing products, categories, users, and orders.
- **Responsive Design**: Fully optimized for desktops, tablets, and mobile devices.
- **Secure Architecture**: Implementation of prepared statements for database security.

## Tech Stack

- **Frontend**: HTML5, CSS3 (Vanilla CSS with modern glassmorphism), JavaScript
- **Backend**: PHP
- **Database**: MySQL

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/gounderdivakaran08-lang/DBMS.git
   ```
2. Move the files to your local server (e.g., XAMPP `htdocs`).
3. Import the database:
   - Create a new database in phpMyAdmin.
   - Import the `NexusElite_Final_Backup.sql` file.
4. Update the database configuration in `includes/config.php` (or relevant configuration file).
5. Start your local server and navigate to the project folder.

## Project Structure

- `admin/`: Admin dashboard and management tools.
- `assets/`: Images, scripts, and stylesheets.
- `includes/`: Reusable components like headers, footers, and database connection settings.
- `NexusElite_Final_Backup.sql`: Database backup file.

## Deployment to Vercel

This project is configured for deployment on Vercel using the `vercel-php` runtime.

### Configuration

1. **vercel.json**: Included in the root directory to handle PHP routing and static assets.
2. **Environment Variables**: You must set the following variables in your Vercel project settings:
   - `DB_SERVER`: Your remote MySQL host (e.g., from Aiven, PlanetScale, or RDS).
   - `DB_USER`: Database username.
   - `DB_PASS`: Database password.
   - `DB_NAME`: Database name.

### Deployment Steps

1. Connect your GitHub repository to Vercel.
2. Vercel will automatically detect the `vercel.json` file and use the PHP runtime.
3. Ensure your remote database allows connections from Vercel's IP addresses (or use a provider that supports serverless connections).

## License

This project is for educational and portfolio purposes.
