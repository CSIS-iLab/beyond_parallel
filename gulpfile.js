require("dotenv").config();
const config = require("./gulp.config.js");
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

const sass_dir = config.theme_dir + "/" + config.sass.src;

let output = config.sass.outputStyle;
if (!PRODUCTION) {
  output = "expanded";
}

function styles() {
  return gulp
    .src(sass_dir + "/*.scss")
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(sass({ outputStyle: output }).on("error", sass.logError))
    .pipe(postcss([autoprefixer(config.sass.autoprefixer)]))
    .pipe(gulpif(PRODUCTION, postcss([cssnano])))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(gulp.dest(config.theme_dir))
    .pipe(browserSync.stream());
}

function reload() {
  browserSync.reload();
}

function watchForChanges() {
  browserSync.init({
    proxy: process.env.LOCAL_URL
  });

  gulp.watch(sass_dir + "/**/*.scss", styles);
  gulp
    .watch([config.theme_dir + "/**/*.php", config.theme_dir + "/**/*.js"])
    .on("change", reload);
}

const build = gulp.task("build", styles);

exports.dev = gulp.parallel(styles, watchForChanges);
exports.styles = styles;
exports.build = build;
exports.default = exports.dev;
