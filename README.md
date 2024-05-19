# Cinemate Project

## Overview

Cinemate is a web application designed to demonstrate API integration and UI development using PHP, HTML, CSS, JavaScript, and AJAX. It provides a platform where users can search for movies, TV episodes, and cast information. The application emphasizes a non-reloading data presentation using AJAX calls to dynamically display content based on user input.

## Technical Features

- **API Integration:** Custom API endpoints to manage movie, episode, and cast data.
- **Dynamic Content Loading:** Utilizes AJAX for seamless content updates without page reloads.
- **Responsive Design:** Uses Bootstrap to ensure the site is responsive and functional on both desktop and mobile devices.
- **Lazy Loading:** Implements lazy loading to enhance performance and data fetching efficiency.
- **Search Functionality:** Includes a detailed search mechanism that filters movies, episodes, or cast members based on user input.
- **Advanced CSS Handling:** Leverages SASS for more sophisticated style management, compiled via Grunt tasks.
- **JavaScript Optimization:** Uses Grunt to concatenate and minify JavaScript files, improving load times and script efficiency.
- **Caching:** Uses local .json caching on data found, implemented on the ContentManger.class.php file.

## Limitations

- Due to server constraints and the self-hosted nature of APIs, features like extensive filtering for cast and episode information are limited.
- Not all potential features are fully developed due to time constraints and the focus on backend integrations over frontend enhancements.

## Directory Structure

```
cinemate/
│
├── htdocs/                  # Web server files
│   ├── assets/              # Static assets like images
│   ├── css/                 # Compiled CSS files
│   ├── js/                  # Compiled JavaScript files
│   ├── src/                 # PHP source files
│   │   ├── api/             # API endpoint scripts
│   │   ├── lib/             # Library files for backend logic
│   │   │   ├── includes/    # Helper classes and configurations
│   │   ├── template/        # Template files for UI
│   │   └── load.php         # Initial loader for dependencies
│   ├── vendor/              # Third-party libraries
│   ├── .htaccess            # Apache server config
│   └── index.php            # Main entry point
│
├── workspace/               # Development files
│   ├── js/                  # JavaScript source files
│   ├── sass/                # SASS source files
│   ├── scripts/             # Additional scripts
│   ├── Gruntfile.js         # Grunt task runner config
│   └── cinemateconfig.json  # Configuration settings
│
├── .gitignore               # Specifies intentionally untracked files to ignore
└── README.md                # Project documentation
```

## Functionality Details

- **API Endpoints:** Handle data fetching and manipulation for movies, episodes, and casts.
- **LoadTemplate Function:** Dynamically includes PHP templates based on the page context, enhancing modular development and maintenance.
- **Session and Database Handling:** Manages user sessions and database connections, ensuring secure and efficient data transactions.
- **Grunt Automation:** Automates repetitive tasks like SASS compilation and JS minification, ensuring efficient development workflows.

## Installation and Usage

1. Clone the repository to your local machine or server.
2. Ensure the server meets PHP and MongoDB requirements.
3. Configure the database and adjust settings in `cinemateconfig.json`.
4. Run `npm install` to install dependencies for Grunt.
5. Use Grunt commands to build CSS and JS assets.

## Demo and Links

- **Project Repository:** [Cinemate GitHub Repository](https://github.com/hariharandr/cinemate)
- **Live Demo:** [Cinemate Live Demo](https://cinimate.zeal.lol/)

## Future Enhancements

With more resources and time, further enhancements like more extensive filtering options, user account integration, and an expanded set of APIs could be implemented to enrich the application's functionality and user experience.
