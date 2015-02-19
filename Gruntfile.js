module.exports = function(grunt) {

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-exec');

  // Project configuration.
  grunt.initConfig({
    pkg : grunt.file.readJSON('package.json'),
    watch : {
      src : {
        files : ['src/**/*.php', 'tests/**/*.*'],
        tasks : ['exec']
      }
    },
    exec : {
      test : {
        cmd : [
          'clear',
          './vendor/bin/phpunit --colors --coverage-html test-coverage --bootstrap ./tests/bootstrap.php tests'
        ].join(' && ')
      }
    }
  });
};
