module.exports = function (grunt) {
    grunt.initConfig({
        sass: {
            dist: {
                files: {
                    '../../htdocs/css/main.css': '../sass/main.scss'
                }
            }
        },
        uglify: {
            dist: {
                files: {
                    '../../htdocs/js/main.min.js': ['../js/*.js']
                }
            }
        },
        watch: {
            css: {
                files: '../sass/**/*.scss',
                tasks: ['sass']
            },
            js: {
                files: '../js/**/*.js',
                tasks: ['uglify']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['sass', 'uglify', 'watch']);
};
