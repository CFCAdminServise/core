<?php

namespace Deployer;

require 'recipe/symfony4.php';

set(
    'bin/php',
    function () {
        return '/usr/local/php74/bin/php';
    }
);

set(
    'bin/composer',
    function () {
        return '{{bin/php}} /home/cfcadmin/composer.phar';
    }
);

// Project name
set('application', 'cfc-admin');

// Project repository
set('repository', 'https://github.com/CFCAdminServise/core.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
add('shared_files', ['.env']);
//add('shared_dirs', []);

// Writable dirs by web server 
//add('writable_dirs', []);


// Hosts
host('cfcadmin.ftp.tools')
    ->stage('prod')
    ->set('branch', 'main')
    ->user('cfcadmin')
    ->set('deploy_path', '~/cfc-admin.org.ua/www');

// Tasks

task(
    'build',
    function () {
        run('cd {{release_path}} && build');
    }
);

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
//before('deploy:symlink', 'database:migrate');

