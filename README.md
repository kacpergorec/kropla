# <img width="300" src="https://raw.githubusercontent.com/kacpergorec/kropla/main/public/images/logo/wide-transparent-darkmode.webp?token=GHSAT0AAAAAABZRO7ELDRNEFHUXWCUVFPCMY55Q27A" alt="Kropla" title="Kropla logo">

My [personal blog](https://kropla.ml) and a CMS built from scratch using Symfony and Doctrine.

## Purpose

The goal of this project is to help me track my progress in learning web development, while also creating a functional blog with a custom admin backend.

## Technologies Used

- Backend: PHP8, [Symfony](https://symfony.com/), [Doctrine](https://www.doctrine-project.org/) ([Docker](https://www.docker.com/)-compose included)
- Frontend: [Webpack](https://webpack.js.org/), [SCSS](https://sass-lang.com/), [Tailwind](https://tailwindcss.com/), [PostCSS](https://postcss.org/)

## Project Status

Currently under development.

## Features

- Track your progress in learning web development
- Custom admin backend
- Support for multiple authors
- Semi-automatic CRUD sections

## Installation

1. Set-up your configuration
2. `docker-compose up -d`
3. `symfony serve -d` Run the web-server
4. `npm run watch`  Run SASS watchers and Tailwind JIT compiler
5. To use **'Prettier'** run `npm run format:twig && npm run format:styles`

## TODOs

- PHPUnit integration
- Search functionality
- SEO optimization
- Translations
- Multi-language website
- Comment system
- REST Integration
- Page Nesting
- AJAX backend
- Built-in analytics
- Media management
- Tidy up Twig templates


## Contributing

If you would like to contribute to this project, please fork the repository and create a pull request. I am always happy to receive contributions and feedback!
