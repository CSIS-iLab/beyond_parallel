[![Build Status](https://travis-ci.com/CSIS-iLab/beyond_parallel.svg?branch=master)](https://travis-ci.com/CSIS-iLab/beyond_parallel)

# beyond_parallel

WordPress site for [Beyond Parallel](https://beyondparallel.csis.org). Developed from the [\_s starter theme](http://underscores.me).

## Contributing

1. New features & updates should be created on individual branches. Branch from `master`
2. When ready, submit pull request back into `master`. Rebase the feature branch first.
3. TravisCI will automatically deploy changes on `master` to the staging site
4. After reviewing your work on the staging site, use WPEngine to move from staging to live

## Development

This project uses [Gulp](https://gulpjs.com/) to compile the SASS files & run Browsersync. To run:

1. Run `$ npm install` in the root directory
2. Run `$ npm start` to run the development task, which watches the WP theme directory for changes & compiles the SCSS files.

A `build` task is also included to compile the SCSS files for production.
