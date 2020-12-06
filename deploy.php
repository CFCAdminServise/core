<?php

namespace Deployer;

require 'recipe/symfony4.php';

set(
    'bin/php',
    function () {
        return '/opt/cpanel/ea-php74/root/usr/bin/php -c /home/c76434/php.ini';
    }
);

set(
    'bin/composer',
    function () {
        return '{{bin/php}} /home/c76434/composer.phar';
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
host('77.120.107.185')
    ->port(20022)
    ->stage('prod')
    ->identityFile('~/id_rsa.pub')
    ->set('branch', 'main')
    ->user('c76434')
    ->set('deploy_path', '~/public_html/cfc-admin.site');

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

