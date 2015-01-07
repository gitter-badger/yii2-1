module.exports = function(grunt) {

    var app = 'app-frontend/';
    var appJs = app + 'js/';
    var appCss = app + 'css/';
    var bower = 'vendor/bower/';

    var dist = 'web/dist/';
    var distJs = dist + 'js/';
    var distCss = dist + 'css/';

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {
            main: {
                src: [
                    bower + 'jquery/dist/jquery.js',
                    bower + 'bootstrap/dist/js/bootstrap.min.js',
                    bower + 'jquery.easing/js/jquery.easing.js',
                    bower + 'jquery.scrollTo/jquery.scrollTo.min.js',
                    appJs + 'home/wow.min.js',
                    appJs + 'home/main.js'
                ],
                dest: distJs + 'main.js'
            }
        },
        concat_css: {
            main: {
                src: [
                    bower + 'bootstrap/dist/css/bootstrap.min.css',
                    appCss + "home/*.css"
                ],
                dest: distCss + "main.css"
            }
        },
        cssmin: {
            add_banner: {
                options: {
                    banner: '/* <%= pkg.name %> | v<%= pkg.version %> | <%= pkg.author %> : <%= grunt.template.today("dd.mm.yyyy") %> */'
                },
                files: {
                    'web/dist/css/main.min.css': [ 'web/dist/css/main.css']
                }
            }
        },
        uglify: {
            options: {
                mangle   : false,
                banner: '/* <%= pkg.name %> | v<%= pkg.version %> | <%= pkg.author %> : <%= grunt.template.today("dd.mm.yyyy") %>*/\n'
            },
            builds: {
                files: {
                    'web/dist/js/main.min.js': [
                        distJs + 'main.js'
                    ]
                }
            }
        },
        watch: {
            // , 'uglify', 'cssmin'
            scripts: {
                files: ['app-frontend/js/**/*.js', 'app-frontend/css/**/*.css'],
                tasks: ['concat', 'concat_css', 'uglify', 'cssmin' ],
                options: {
                    spawn: false
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-concat-css');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', [
        'concat',
        'concat_css',
        'cssmin',
        'uglify',
        'watch'
    ]);

};