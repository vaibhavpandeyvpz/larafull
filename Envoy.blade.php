@include('vendor/autoload.php')

@setup
    (new Dotenv\Dotenv(__DIR__))->load();
    $release = date('YmdHis');
    $host = env('ENVOY_HOST');
    $user = env('ENVOY_USER', 'envoy');
    $root = env('ENVOY_ROOT', '/home/'.$user);
    $remote = env('ENVOY_REMOTE');
@endsetup

@servers(['web' => "$user@$host"])

@task('cleanup')
    echo 'Cleaning up older releases.'
    cd {{ $root }}/releases
    ls -t | tail -n +8 | xargs rm -Rf
@endtask

@task('down')
    echo 'Bringing application into maintenance mode.'
    cd {{ $root }}
    if [ -d current ]; then
        cd current
        php artisan down
    fi
@endtask

@task('fetch')
    echo 'Updating code from {{ $remote }}.'
    cd {{ $root }}/repository
    git fetch origin master:master --force --quiet
    GIT_WORK_TREE={{ $root }}/releases/{{ $release }} git checkout master --force --quiet
    git rev-parse --verify HEAD > {{ $root }}/storage/COMMIT
@endtask

@task('update')
    echo 'Installing dependencies and building release.'
    cd {{ $root }}/releases/{{ $release }}
    rm -rf storage
    ln -s {{ $root }}/storage storage
    composer install --quiet --no-dev --prefer-dist
    rm -f .env
    ln -s {{ $root }}/.env .env
    php artisan config:cache
    php artisan migrate --force
    if [ ! -f storage/oauth-private.key ]; then
        php artisan passport:install
    fi
@endtask

@task('setup')
    echo 'Preparing prerequisites.'
    cd {{ $root }}
    if [ ! -d repository ]; then
        ssh-keyscan -H bitbucket.org >> ~/.ssh/known_hosts
        ssh-keyscan -H github.com >> ~/.ssh/known_hosts
        git clone {{ $remote }} repository --depth 1 --bare
    fi
    if [ ! -d storage ]; then
        mkdir -p storage/app/public \
            storage/framework/cache \
            storage/framework/sessions \
            storage/framework/testing \
            storage/framework/views \
            storage/logs
    fi
    mkdir -p {{ $root }}/releases/{{ $release }}
@endtask

@task('up')
    echo 'Bringing application back to live.'
    cd {{ $root }}
    cd current
    php artisan up
@endtask

@task('link')
    echo 'Updating deployed app with new release.'
    cd {{ $root }}
    rm -f current
    ln -s {{ $root }}/releases/{{ $release }} current
    sudo systemctl restart php7.2-fpm
@endtask

@story('deploy')
    down
    setup
    fetch
    update
    link
    cleanup
    up
@endstory
