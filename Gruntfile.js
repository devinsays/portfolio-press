'use strict';
module.exports = function(grunt) {

    grunt.initConfig({

    	// https://www.npmjs.org/package/grunt-wp-i18n
	    makepot: {
	        target: {
	            options: {
	                domainPath: '/languages/',    // Where to save the POT file.
	                potFilename: 'portfolio-press.pot',   // Name of the POT file.
	                type: 'wp-theme'  // Type of project (wp-plugin or wp-theme).
	            }
	        }
	    }

	});

	// load tasks
	grunt.loadNpmTasks( 'grunt-wp-i18n' );

	// register tasks
    grunt.registerTask('default', [
        'makepot'
    ]);

};