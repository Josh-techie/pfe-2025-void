// Include gulp.
var gulp = require("gulp");
var fs = require("fs");
var path = require("path");
var browsersync = require("browser-sync").create();
var config = require("./config.json");
var icomoon = require("./assets/fonts/icons-font/vactory-icons-font/selection.json");

// Include plugins.
var postcss = require("gulp-postcss");
var pxtorem = require("postcss-pxtorem");
var cssvariables = require("postcss-css-variables");
var autoprefixer = require("autoprefixer");
var gulpAutoprefix = require("gulp-autoprefixer");
var gulpif = require("gulp-if");
var shell = require("gulp-shell");
var plumber = require("gulp-plumber");
var notify = require("gulp-notify");
var concat = require("gulp-concat");
var jshint = require("gulp-jshint");
var banner = require("gulp-banner");
var sass = require("gulp-sass");
var glob = require("gulp-sass-glob");
var scssLint = require("gulp-scss-lint");
var sourcemaps = require("gulp-sourcemaps");
var csscomb = require("gulp-csscomb");
var rtlcss = require("gulp-rtlcss");
var rename = require("gulp-rename");
var imagemin = require("gulp-imagemin");
var pngcrush = require("imagemin-pngcrush");
var uglify = require("gulp-uglify");
var twig = require("gulp-twig");
var data = require("gulp-data");
var header = require("gulp-header");
var styledown = require("gulp-styledown");
var gulpInject = require("gulp-inject");
var postcssobjectfit = require("postcss-object-fit-images");
var sassJson = require("gulp-sass-json");
var foreach = require("gulp-foreach");
var gulpFn = require("gulp-fn");
var bulkSass = require("gulp-sass-bulk-import");
var cssdepth = require("gulp-cssdepth-check");

var comment =
  "/*\n" +
  " * <%= pkg.name %> <%= pkg.version %>\n" +
  " * <%= pkg.description %>\n" +
  " * <%= pkg.homepage %>\n" +
  " *\n" +
  " * Copyright (c) <%= new Date().getFullYear() %>, <%= pkg.author %>\n" +
  " * Released under the <%= pkg.license %> license.\n" +
  "*/\n\n";

var postcssPluginsConfig = [
  postcssobjectfit(),
  autoprefixer({
    overrideBrowserslist: ["last 8 versions", "> 1%", "ie 9", "ie 10"],
  }),
  pxtorem({
    rootValue: 16,
    unitPrecision: 5,
    propList: ["*", "!background*", "!letter-spacing"],
    selectorBlackList: [/^body$/, /^html$/, /^:root$/],
    replace: false,
    mediaQuery: false,
    minPixelValue: 0,
  }),
  cssvariables({
    preserve: "computed",
  }),
];

var cssdepthConfig = {
  depthAllowed: 8,
  showStats: false,
  showSelectors: true,
  logFolder: "src/json/cssDepth",
  throwError: false,
};

var gulpPlumberConfig = {
  errorHandler: function (error) {
    notify.onError({
      title: "Gulp",
      subtitle: "Failure!",
      message: "Error: <%= error.message %>",
      sound: "Beep",
    })(error);
    this.emit("end");
  },
};

var sassConfig = {
  includePaths: config.essentiel_files.import,
  outputStyle: "expanded",
  errLogToConsole: true,
};

// CSS.
gulp.task("css", (done) => {
  return (
    gulp
      .src(config.css.file, { allowEmpty: true })
      .pipe(header("$is_rtl: false;\n"))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(postcss(postcssPluginsConfig))
      .pipe(cssdepth(cssdepthConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(gulp.dest(config.css.dest))
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_rtl", (done) => {
  return (
    gulp
      .src(config.css.file, { allowEmpty: true })
      .pipe(header("$is_rtl: true;\n"))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(rtlcss()) // Convert to RTL.
      .pipe(rename({ suffix: "-rtl" })) // Append "-rtl" to the filename.
      .pipe(postcss(postcssPluginsConfig))
      .pipe(cssdepth(cssdepthConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(gulp.dest(config.css.dest))
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_components", function (done) {
  return (
    gulp
      .src(config.css_components.file, { allowEmpty: true })
      .pipe(header('$is_rtl: false;\n @import "__import.scss";\n'))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(postcss(postcssPluginsConfig))
      .pipe(cssdepth(cssdepthConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(gulp.dest(config.css_components.dest))
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_components_rtl", function (done) {
  return (
    gulp
      .src(config.css_components.file, { allowEmpty: true })
      .pipe(header('$is_rtl: true;\n @import "__import.scss";\n'))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(rtlcss()) // Convert to RTL.
      .pipe(rename({ suffix: "-rtl" })) // Append "-rtl" to the filename.
      .pipe(postcss(postcssPluginsConfig))
      .pipe(cssdepth(cssdepthConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(gulp.dest(config.css_components.dest))
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_custom_module", function (done) {
  return (
    gulp
      .src(config.css_custom_module.file, { allowEmpty: true })
      .pipe(header('$is_rtl: false;\n @import "__import.scss";\n'))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(postcss(postcssPluginsConfig))
      .pipe(cssdepth(cssdepthConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(
        gulp.dest(function (file) {
          var filedirname = file.dirname;
          filedirname = filedirname.replace("scss", "css");
          return filedirname;
        })
      )
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_custom_module_rtl", function (done) {
  return (
    gulp
      .src(config.css_custom_module.file, { allowEmpty: true })
      .pipe(header('$is_rtl: true;\n @import "__import.scss";\n'))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(rtlcss()) // Convert to RTL.
      .pipe(rename({ suffix: "-rtl" })) // Append "-rtl" to the filename.
      .pipe(postcss(postcssPluginsConfig))
      .pipe(cssdepth(cssdepthConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(
        gulp.dest(function (file) {
          var filedirname = file.dirname;
          filedirname = filedirname.replace("scss", "css");
          return filedirname;
        })
      )
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_dynamic_field", function (done) {
  return (
    gulp
      .src(config.css_dynamic_field.file, { allowEmpty: true })
      .pipe(header('$is_rtl: false;\n @import "__import.scss";\n'))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(postcss(postcssPluginsConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(cssdepth(cssdepthConfig))
      .pipe(
        gulp.dest(function (file) {
          var filedirname = file.dirname;
          // filedirname = filedirname.replace('scss', 'css');
          return filedirname;
        })
      )
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_dynamic_field_rtl", function (done) {
  return (
    gulp
      .src(config.css_dynamic_field.file, { allowEmpty: true })
      .pipe(header("$is_rtl: true;\n"))
      .pipe(header('@import "__import.scss";\n'))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(rtlcss()) // Convert to RTL.
      .pipe(rename({ suffix: "-rtl" })) // Append "-rtl" to the filename.
      .pipe(postcss(postcssPluginsConfig))
      .pipe(cssdepth(cssdepthConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(
        gulp.dest(function (file) {
          var filedirname = file.dirname;
          // filedirname = filedirname.replace('scss', 'css');
          return filedirname;
        })
      )
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_dynamic_field_default", function (done) {
  return (
    gulp
      .src(config.css_dynamic_field_default.file, { allowEmpty: true })
      .pipe(header('$is_rtl: false;\n @import "__import.scss";\n'))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(postcss(postcssPluginsConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(cssdepth(cssdepthConfig))
      .pipe(
        gulp.dest(function (file) {
          var filedirname = file.base;
          // filedirname = filedirname.replace('scss', 'css');
          return filedirname;
        })
      )
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_dynamic_field_default_rtl", function (done) {
  return (
    gulp
      .src(config.css_dynamic_field_default.file, { allowEmpty: true })
      .pipe(header("$is_rtl: true;\n"))
      .pipe(header('@import "__import.scss";\n'))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(rtlcss()) // Convert to RTL.
      .pipe(rename({ suffix: "-rtl" })) // Append "-rtl" to the filename.
      .pipe(postcss(postcssPluginsConfig))
      .pipe(cssdepth(cssdepthConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(
        gulp.dest(function (file) {
          var filedirname = file.base;
          // filedirname = filedirname.replace('scss', 'css');
          return filedirname;
        })
      )
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_vactory_module", function (done) {
  return (
    gulp
      .src(config.css_vactory_module.file, { allowEmpty: true })
      .pipe(header('$is_rtl: false;\n @import "__import.scss";\n'))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(postcss(postcssPluginsConfig))
      .pipe(cssdepth(cssdepthConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(
        gulp.dest(function (file) {
          var filedirname = file.dirname;
          filedirname = filedirname.replace("scss", "css");
          return filedirname;
        })
      )
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("css_vactory_module_rtl", function (done) {
  return (
    gulp
      .src(config.css_vactory_module.file, { allowEmpty: true })
      .pipe(header('$is_rtl: true;\n @import "__import.scss";\n'))
      .pipe(glob())
      .pipe(plumber(gulpPlumberConfig))
      // .pipe(sourcemaps.init())
      .pipe(sass(sassConfig))
      .pipe(rtlcss()) // Convert to RTL.
      .pipe(rename({ suffix: "-rtl" })) // Append "-rtl" to the filename.
      .pipe(postcss(postcssPluginsConfig))
      .pipe(cssdepth(cssdepthConfig))
      // .pipe(sourcemaps.write("./"))
      .pipe(
        gulp.dest(function (file) {
          var filedirname = file.dirname;
          filedirname = filedirname.replace("scss", "css");
          return filedirname;
        })
      )
      .pipe(browsersync.stream())
  );
  done();
});

gulp.task("ckeditor", (done) => {
  return gulp
    .src(config.ckeditor.file)
    .pipe(glob())
    .pipe(
      plumber({
        errorHandler: function (error) {
          notify.onError({
            title: "Gulp",
            subtitle: "Failure!",
            message: "Error: <%= error.message %>",
            sound: "Beep",
          })(error);
          this.emit("end");
        },
      })
    )
    .pipe(
      sass({
        includePaths: config.essentiel_files.import,
        style: "compressed",
        errLogToConsole: true,
      })
    )
    .pipe(postcss(postcssPluginsConfig))
    .pipe(gulp.dest(config.ckeditor.dest));
  done();
});

gulp.task("generate_fonts", function (done) {
  return gulp
    .src(config.css_fonts.file)
    .pipe(glob())
    .pipe(
      sass({
        includePaths: config.essentiel_files.import,
        outputStyle: "expanded",
        errLogToConsole: true,
      })
    )
    .pipe(gulp.dest(config.css_fonts.dest))
    .pipe(browsersync.stream());
  done();
});

gulp.task("csscomb", function (done) {
  return gulp
    .src(config.csscomb.src)
    .pipe(csscomb())
    .pipe(gulp.dest(config.csscomb.dest));
  done();
});

gulp.task("sass-json", function (done) {
  return gulp
    .src(config.essentiel_files.variables)
    .pipe(sassJson())
    .pipe(gulp.dest("./src/json/scssVars"));
  done();
});

// JavaScript.
gulp.task("js", (done) => {
  return (
    gulp
      .src(config.js.src)
      .pipe(jshint())
      // .pipe(sourcemaps.init())
      .pipe(
        concat(config.js.file, {
          newLine: ";",
        })
      )
      .pipe(
        banner(comment, {
          pkg: config,
        })
      )
      // .pipe(uglify())
      // .pipe(sourcemaps.write(./))
      .pipe(gulp.dest(config.js.dest))
      .pipe(browsersync.reload({ stream: true }))
  );
  done();
});

gulp.task("jsplugins", (done) => {
  return (
    gulp
      .src(config.jsplugins.src)
      .pipe(jshint())
      // .pipe(sourcemaps.init())
      .pipe(
        banner(comment, {
          pkg: config,
        })
      )
      // .pipe(sourcemaps.write())
      .pipe(gulp.dest(config.jsplugins.dest))
      .pipe(browsersync.reload({ stream: true }))
  );
  done();
});

// Compress images.
gulp.task("images", (done) => {
  return gulp
    .src(config.images.src)
    .pipe(
      imagemin({
        progressive: true,
        svgoPlugins: [
          {
            removeViewBox: false,
          },
        ],
        use: [pngcrush()],
      })
    )
    .pipe(gulp.dest(config.images.dest));
  done();
});

gulp.task("styleguide", (done) => {
  return gulp
    .src(config.styleguide.src)
    .pipe(
      plumber({
        errorHandler: function (error) {
          notify.onError({
            title: "Gulp",
            subtitle: "Failure!",
            message: "Error: <%= error.message %>",
            sound: "Beep",
          })(error);
          this.emit("end");
        },
      })
    )
    .pipe(
      data(function (file) {
        return icomoon;
      })
    )
    .pipe(twig())
    .pipe(gulp.dest(config.styleguide.dest))
    .pipe(browsersync.reload({ stream: true }));
  done();
});

gulp.task("markdown", function (done) {
  return gulp
    .src(config.markdown.files)
    .pipe(
      styledown({
        config: config.markdown.config,
        filename: "markdown.html",
      })
    )
    .pipe(gulp.dest(config.markdown.dest));
  done();
});

gulp.task("browserSync", (done) => {
  browsersync.init({
    proxy: config.proxy,
    open: true,
    reloadOnRestart: true,
    port: 3000,
    localOnly: true,
    injectChanges: true,
    online: true,
  });
  done();
});

// BrowserSync Reload
gulp.task("browserSyncReload", (done) => {
  browsersync.reload();
  done();
});
gulp.task("browserSyncStream", (done) => {
  browsersync.stream();
  done();
});

// Watch task.
gulp.task("watchFiles", (done) => {
  gulp.watch(config.css_fonts.file, gulp.series("generate_fonts"));
  gulp.watch(config.styleguide.srcWatch, gulp.series("styleguide"));
  gulp.watch(config.ckeditor.src, gulp.series("ckeditor"));
  gulp.watch(config.css.src, gulp.series("css", "css_rtl"));
  gulp.watch(
    config.css_components.watch,
    gulp.series("css_components", "css_components_rtl")
  );
  gulp.watch(
    config.css_vactory_module.file,
    gulp.series("css_vactory_module", "css_vactory_module_rtl")
  );
  gulp.watch(
    config.css_custom_module.file,
    gulp.series("css_custom_module", "css_custom_module_rtl")
  );
  gulp.watch(
    config.css_dynamic_field.file,
    gulp.series("css_dynamic_field", "css_dynamic_field_rtl")
  );
  gulp.watch(
    config.css_dynamic_field_default.file,
    gulp.series("css_dynamic_field_default", "css_dynamic_field_default_rtl")
  );
  gulp.watch(config.images.src, gulp.series("images", "browserSyncReload"));
  gulp.watch(config.js.src, gulp.series("js"));
  gulp.watch(config.jsplugins.src, gulp.series("jsplugins"));
  done();
});

gulp.task(
  "compile_style",
  gulp.series(
    "generate_fonts",
    "css",
    "css_rtl",
    "css_components",
    "css_components_rtl",
    "css_custom_module",
    "css_custom_module_rtl",
    "css_dynamic_field",
    "css_dynamic_field_rtl",
    "css_dynamic_field_default",
    "css_dynamic_field_default_rtl",
    "css_vactory_module",
    "css_vactory_module_rtl",
    "ckeditor"
  )
);
gulp.task(
  "vactory_module",
  gulp.series("css_vactory_module", "css_vactory_module_rtl")
);
gulp.task("build", gulp.series("compile_style", "js", "jsplugins"));
// Run drush to clear the theme registry.
gulp.task("drush", shell.task(["drush cr"]));
// Default Task
gulp.task("default", gulp.series("browserSync", "watchFiles"));
