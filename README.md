# Skytel Frontend Application

Skytel is a comprehensive web application built with Laravel 11, Alpine.js/plain JavaScript, Bootstrap, and Swiper for styles. It provides a powerful platform for showcasing the company's products and services, facilitating customer interaction, and managing content through an administrative panel.

## Table of Contents
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Features
The Skytel frontend application includes the following main features:

1. **Plan Selection Functionality**: Users can select and manage their plan options, including features like TV packages, internet speed, and add-ons.
2. **Localization and Internationalization**: The application supports multiple languages, allowing users to switch between different language options.
3. **News and Announcements**: Users can view the latest news and announcements, which are managed by the admin panel.
4. **Responsive and Visually Appealing Design**: The application has a modern and responsive design, created using various CSS frameworks and UI libraries.
5. **Admin Panel**: The admin panel allows authorized users to perform CRUD (Create, Read, Update, Delete) operations on the application's data, including plans, news, and more.

## Technologies Used
The Skytel frontend application utilizes the following technologies and frameworks:

- **Laravel**: A PHP web application framework for building modern and robust web applications.
- **Alpine.js**: A lightweight and flexible JavaScript framework for adding interactivity to the application.
- **Bootstrap 5**: A popular CSS framework for building responsive and mobile-first websites.
- **Bootswatch**: A popular theme for building Bootstrap 5 website designs.
- **Swiper**: A modern touch slider library for building various types of sliders and carousels.
- **Spatie/Translatable**: A Laravel package for adding multi-language support to Eloquent models.
- **Database**: MySQL.

## Key Features

### Public Pages:

- Home/Landing Page with slider and scrollable news bar
- News Page for articles and press releases
- Tariffs Page for service plans
- About Us, Vacancies, Events, and Coverage information (Under Development)
- Complaints submission platform (Under Development)
- Consumer Rights and Regulations information (Under Development)

### Admin Panel:

- Dynamic Content Management
- News CRUD operations
- Slider management
- Tariffs configuration
- Header/Footer content control
- Complaints handling
- Consumer Rights and Regulations updates

## Installation
To set up the Skytel frontend application, follow these steps:

1. Clone the repository:
   ```
   git clone https://github.com/lukachochua/skytel-frontend.git
   ```
2. Install the required dependencies:
   ```
   composer install
   npm install
   ```
3. Configure the environment:
   - Create a `.env` file based on the `.env.example` file.
   - Update the database connection details and other environment-specific settings.
4. Generate the application key:
   ```
   php artisan key:generate
   ```
5. Run the database migrations and seeders:
   ```
   php artisan migrate --seed
   ```
6. Start the development server:
   ```
   php artisan serve
   ```
7. Build the frontend assets:
   ```
   npm run dev
   ```

The application should now be accessible at `http://localhost:8000`.

## Usage
Once the application is installed and running, you can explore the following functionalities:

1. **Plan Selection**: Visit the welcome page to view and select various plan options.
2. **Language Switching**: Use the language switcher in the navbar to change the application's language.
3. **News and Announcements**: View the latest news and announcements on the welcome page.
4. **Admin Panel**: Access the admin panel by logging in with the appropriate credentials. Here, you can manage plans, news, and other application data.

## Contributing
If you'd like to contribute to the Skytel frontend application, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix: `git checkout -b feature/my-feature`.
3. Make your changes and commit them: `git commit -m 'Add some feature'`.
4. Push your branch to your forked repository: `git push origin feature/my-feature`.
5. Open a pull request against the main repository.

Please ensure that your code follows the project's coding standards and includes appropriate tests.

## License
This project is licensed under the [MIT License](LICENSE).