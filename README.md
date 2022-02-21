# 環境構築 / Build Environment


### 1. git clone
Ubuntu
```
cd ~
git clone git@github.com:yukiibe/laravel_sample_001.git
```

### 2. docker build
Ubuntu
```
cd ~/laravel_sample_001
docker-compose build
```

### 3. docker up
Ubuntu
```
cd ~/laravel_sample_001
docker-compose up
```

※docker起動後、コンテナ`laravel_sample_001_app`にアクセスし、下記を実行する。<br>
docker volume prune や docker system prune をしない限り再実行は必要ない。<br>
```
cd /var/www/vhosts/laravel-sample-001
php artisan migrate
php artisan storage:link
```
