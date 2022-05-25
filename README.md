# MAX'Is

## 開發前環境設定

1. 安裝 composer 依賴套件

    ```bash
    composer install
    ```

2. 設定.env
   將.env.example 複製成 .env 並修改與資料庫連線

3. 設定加密的 APP_KEY

    ```bash=
    php artisan key:generate
    ```

4. 設定資料庫
   在 MySQL 新增資料庫

5. Migration 和 Seeding 建立資料表結構

    ```bash
    # 遷移資料表
    php artisan migrate

    # 填充測試資料
    php artisan db:seed
    ```

## 上線環境設定

1. 安裝 compsoer 排除 dev 項目

```bash
composer install --optimize-autoloader --no-dev
```

2. `.env`設定轉為線上並且關閉錯誤提示

```php
APP_NAME=專案名稱
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://正式網址
```

3. 設定快取

```bash
php artisan config:cache

#　下次更新程式記得更新config
php artisan config:clear
```

4. Composer 緩存

```bash
composer dumpautoload -o
# 每次更新compsoer install 後，都要再執行一次
```

5. 建立 keygen

```bash
php artisan key:generate
```

6. 執行

```bash
# 遷移資料表
php artisan migrate

# 填充資料
php artisan db:seed
```

## 障礙排除

-   清除快取

```bash
php artisan config:clear
```

-   migrate 指令

```bash
# 還原 --steph 此參數為後退多少版本
php artisan migrate:rollback
php artisan migrate:rollback --step=5

# 重置所有migration
php artisan migrate:refresh

# 重置所有migration，並填充資料
php artisan migrate:refresh --seed
```
