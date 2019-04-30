require("dotenv").config();
const config = require("./config.json");
const gulp = require("gulp");
const gulpif = require("gulp-if");
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano");
const postcss = require("gulp-postcss");
const sass = require("gulp-sass");
const sourcemaps = require("gulp-sourcemaps");
const browserSync = require("browser-sync").create();
const yargs = require("yargs");
const PRODUCTION = yargs.argv.prod;

const theme_dir = "./wp-content/themes/" + config.theme_dir + "/";

function styles() {
  return gulp
    .src(theme_dir + config.sass_dir + "/*.scss")
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(sass().on("error", sass.logError))
    .pipe(postcss([autoprefixer]))
    .pipe(gulpif(PRODUCTION, postcss([cssnano])))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(gulp.dest(theme_dir + ""))
    .pipe(browserSync.stream());
}

function reload() {
  browserSync.reload();
}

function watchForChanges() {
  browserSync.init({
    proxy: process.env.LOCAL_URL
  });

  gulp.watch(theme_dir + config.sass_dir + "/**/*.scss", styles);
  gulp.watch(theme_dir + "**/*.php").on("change", reload);
}

const build = gulp.task("build", styles);

exports.dev = gulp.parallel(styles, watchForChanges);
exports.styles = styles;
exports.build = build;
exports.default = exports.dev;
