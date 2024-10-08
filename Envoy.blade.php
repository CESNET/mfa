@include('vendor/autoload.php')

@setup
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, 'envoy');

    try {
    $dotenv->load();
    $dotenv->required([
    'TARGET_SERVER', 'TARGET_USER', 'TARGET_DIR',
    'REPOSITORY',
    'APP_NAME', 'APP_ENV', 'APP_DEBUG', 'APP_URL',
    ])->notEmpty();
    } catch(Exception $e) {
    echo "Something went wrong:\n\n";
    echo "{$e->getMessage()} \n\n";
    exit;
    }

    $server = $_ENV['TARGET_SERVER'];
    $user = $_ENV['TARGET_USER'];
    $dir = $_ENV['TARGET_DIR'];

    $repository = $_ENV['REPOSITORY'];
    $branch = $branch ?? 'main';

    $app_name = $_ENV['APP_NAME'];
    $app_env = $_ENV['APP_ENV'];
    $app_debug = $_ENV['APP_DEBUG'];
    $app_url = $_ENV['APP_URL'];

    $destination = (new DateTime)->format('YmdHis');
    $symlink = 'current';
@endsetup

@servers(['web' => "$user@$server"])

@task('deploy', ['confirm' => true])
    echo "=> Install {{ $app_name }} into ~/{{ $dir }}/ at {{ $user }}"@"{{ $server }}..."

    echo "Check ~/{{ $dir }}/"
    if [ ! -d {{ $dir }} ]; then
    mkdir -p {{ $dir }}
    fi

    cd {{ $dir }}

    echo "Define variables"
    export URL=`wget -qO- https://api.github.com/repos/CESNET/mfa/releases/latest | grep browser_download_url |
    cut -d'"' -f4`
    export FILE=`basename $URL`
    export DIR=${FILE%.tar.gz}

    echo "Download source code"
    wget -q $URL

    echo "Extract source code"
    tar -xzf $FILE

    echo "Backup existing ~/{{ $dir }}/.env"
    if [ -f .env ]; then
    mv .env .env-$DIR.bak
    fi

    echo "Prepare new ~/{{ $dir }}/.env"
    if [ ! -f .env ]; then
    cp $DIR/.env.example .env
    fi

    echo "Update ~/{{ $dir }}/.env"
    sed -i "s%APP_NAME=.*%APP_NAME={{ $app_name }}%; \
    s%APP_ENV=.*%APP_ENV={{ $app_env }}%; \
    s%APP_DEBUG=.*%APP_DEBUG={{ $app_debug }}%; \
    s%APP_URL=.*%APP_URL={{ $app_url }}%" .env

    echo "Symlink ~/{{ $dir }}/.env"
    ln -s ../.env ~/{{ $dir }}/$DIR/.env

    echo "Check ~/{{ $dir }}/storage/ and fix permissions if necessary"
    if [ ! -d storage ]; then
    mv $DIR/storage .
    setfacl -Rm g:www-data:rwx,d:g:www-data:rwx storage
    else
    rm -rf $DIR/storage
    fi

    echo "Fix permissions to ~/{{ $dir }}/bootstrap/cache"
    setfacl -Rm g:www-data:rwx,d:g:www-data:rwx ~/{{ $dir }}/$DIR/bootstrap/cache

    echo "Symlink ~/{{ $dir }}/storage/"
    ln -s ../storage $DIR/storage

    echo "Unlink ~/{{ $dir }}/{{ $symlink }}"
    if [ -h {{ $symlink }} ]; then
    rm {{ $symlink }}
    fi

    echo "Symlink ~/{{ $dir }}/$DIR to ~/{{ $dir }}/{{ $symlink }}"
    ln -s $DIR {{ $symlink }}

    echo "Install composer dependencies"
    cd current
    composer install -q --no-dev --optimize-autoloader --no-ansi --no-interaction --no-progress --prefer-dist
    cd ..

    echo "Generate key"
    if [ `grep '^APP_KEY=' .env | grep 'base64:' | wc -l` -eq 0 ]; then
    cd current
    php artisan key:generate -q --no-ansi --no-interaction
    cd ..
    fi

    cd $DIR

    echo "Optimize"
    php artisan optimize:clear -q --no-ansi --no-interaction

    echo "Cache config"
    php artisan config:cache -q --no-ansi --no-interaction

    echo "Cache routes"
    php artisan route:cache -q --no-ansi --no-interaction

    echo "Cache views"
    php artisan view:cache -q --no-ansi --no-interaction

    echo "Reload PHP-FPM"
    sudo systemctl reload php8.3-fpm
@endtask

@task('cleanup')
    cd {{ $dir }}
    find . -maxdepth 1 -name "mfa*" | sort | head -n -6 | xargs rm -rf
    echo "Cleaned up all but the last 3 deployments."
@endtask
