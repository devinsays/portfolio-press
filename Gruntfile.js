'use strict';

// Packages
const fiberLibrary = require('fibers');
const sassLibrary = require('node-sass');

module.exports = function(grunt) {

	// load all tasks
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			files: ['scss/*.scss'],
			tasks: 'sass',
			options: {
				livereload: true,
			},
		},
		sass: {
			default: {
				options : {
					implementation: sassLibrary,
					fiber: fiberLibrary,
					style : 'expanded',
					sourceMap: true
				},
				files: {
					'style.css': 'scss/style.scss',
				}
			}
		},
		postcss: {
			options: {
				map: true,
				processors: [
					require('autoprefixer-core')({browsers: 'last 2 versions'}),
				]
			},
			files: {
				'style.css':'style.css'
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
			options: {
				mangle: {
					reserved: ['jQuery']
				},
				drop_console: true
			},
			default: {
				files: {
					'js/combined-min.js' : 'js/combined-min.js'
				}
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
					pot.headers['report-msgid-bugs-to'] = 'https://wptheming.com/';
					pot.headers['language'] = 'en_US';
					return pot;
					}
				}
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
		},
		replace: {
			styleVersion: {
				src: [
					'scss/style.scss',
				],
				overwrite: true,
				replacements: [{
					from: /Version:.*$/m,
					to: 'Version: <%= pkg.version %>'
				}]
			},
			functionsVersion: {
				src: [
					'functions.php'
				],
				overwrite: true,
				replacements: [ {
					from: /^define\( 'PORTFOLIO_VERSION'.*$/m,
					to: 'define( \'PORTFOLIO_VERSION\', \'<%= pkg.version %>\' );'
				} ]
			},
		}
	});

	grunt.registerTask( 'default', [
		'sass',
		'postcss',
	]);

	grunt.registerTask( 'release', [
		'replace',
		'sass',
		'postcss',
		'concat',
		'uglify',
		'makepot',
		'cssjanus'
	]);

};
