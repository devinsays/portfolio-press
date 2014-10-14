'use strict';
module.exports = function(grunt) {

	// load all tasks
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

    grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		autoprefixer: {
            options: {
				browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1', 'ie 9']
			},
			single_file: {
				src: 'style.css',
				dest: 'style.css'
			}
		},
		csscomb: {
	        release: {
	            options: {
	                config: '.csscomb.json'
	            },
	            files: {
	                'style.css': ['style.css'],
	            }
	        }
	    },
		concat: {
			release: {
		        src: [
		            'js/navigation.js',
		            'js/jquery.fitvids.js',
		        ],
		        dest: 'js/combined-min.js'
	        }
		},
		uglify: {
		    release: {
		        src: 'js/combined-min.js',
		        dest: 'js/combined-min.js'
		    }
		},
    	// https://www.npmjs.org/package/grunt-wp-i18n
	    makepot: {
	        target: {
	            options: {
	                domainPath: '/languages/', // Where to save the POT file.
	                potFilename: 'portfolio-press.pot', // Name of the POT file.
	                potHeaders: {
	                poedit: true, // Includes common Poedit headers.
                    'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
                },
		        type: 'wp-theme', // Type of project (wp-plugin or wp-theme).
		        updateTimestamp: false, // Update timestamp if there's no string changes.
		        processPot: function( pot, options ) {
					pot.headers['report-msgid-bugs-to'] = 'http://wptheming.com/';
		        	pot.headers['last-translator'] = 'WP-Translations (http://wp-translations.org/)';
		        	pot.headers['language-team'] = 'WP-Translations <wpt@wp-translations.org>';
		        	pot.headers['language'] = 'en_US';
		        	return pot;
					}
				}
			}
		},
		exec: {
			txpull: { // Pull Transifex translation - grunt exec:txpull
				cmd: 'tx pull -a --minimum-perc=90' // Percentage translated
			},
			txpush_s: { // Push pot to Transifex - grunt exec:txpush_s
				cmd: 'tx push -s'
			},
		},
		dirs: {
			lang: 'languages',
		},
		potomo: {
			dist: {
				options: {
					poDel: false // Set to true if you want to erase the .po
				},
				files: [{
					expand: true,
					cwd: '<%= dirs.lang %>',
					src: ['*.po'],
					dest: '<%= dirs.lang %>',
					ext: '.mo',
					nonull: true
				}]
			}
		},
		cssjanus: {
			theme: {
				options: {
					swapLtrRtlInUrl: false
				},
				files: [
					{
						src: 'style.css',
						dest: 'style-rtl.css'
					}
				]
			}
		}
	});

    grunt.registerTask( 'release', [
		'autoprefixer',
		'csscomb',
		'concat',
		'uglify',
		'makepot',
		'cssjanus'
	]);

    // Makepot and push it on Transifex task(s).
    grunt.registerTask( 'txpush', [
    	'makepot',
    	'exec:txpush_s'
    ]);

    // Pull from Transifex and create .mo task(s).
    grunt.registerTask( 'txpull', [
    	'exec:txpull',
    	'potomo'
    ]);

};