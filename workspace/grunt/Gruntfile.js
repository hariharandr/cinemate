const sass = require("node-sass");
module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON("package.json"),
        concat: {
            options: {
                sourceMap: true,
            },
            dist: {
                src: ["../js/*.js", "../js/**/*.js"],
                dest: "../../htdocs/js/app.js",
            },
        },

        uglify: {
            options: {
                mangle: false,
                compress: false,
                beautify: false,
                sourceMap: true,
                sourceMapIncludeSources: true,
                sourceMapIn: "../../htdocs/js/app.js.map",
            },
            build: {
                files: {
                    "../../htdocs/js/app.min.js": ["../../htdocs/js/app.js"],
                },
            },
        },

        sass: {
            options: {
                style: "compressed",
                sourceMap: true,
                implementation: sass,
                includePaths: ["node_modules"],
            },
            dist: {
                files: {
                    "../../htdocs/css/app.css": "../sass/app.scss",
                },
            },
        },

        watch: {
            scripts: {
                files: ["../js/*.js", "../js/**/*.js"],
                tasks: ["concat:dist", "uglify:build"],
            },
            css: {
                files: [
                    "../sass/**/*.scss",
                    "../sass/**/*.sass",
                ],
                tasks: ["sass"],
                options: {
                    debounceDelay: 300,
                    spawn: false,
                },
            },
            configFiles: {
                files: ["Gruntfile.js"],
                options: {
                    reload: true,
                    spawn: true,
                },
            },
        },
    });

    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-contrib-concat");
    grunt.loadNpmTasks("grunt-sass");
    grunt.loadNpmTasks("grunt-contrib-uglify");
    grunt.registerTask("default", [
        "sass",
        "concat",
        "uglify",
        "watch",
    ]);
    grunt.registerTask("build", [
        "sass",
        "concat",
        "uglify",
    ]);
};

/* EOF */
