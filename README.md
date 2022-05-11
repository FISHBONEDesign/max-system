# MAX'Is

## 開發前環境設定

1. 安裝composer 依賴套件
    ```bash
    composer instal
    ```

2. 設定.env
    將.env.example 複製成 .env並修改與資料庫連線

3. 設定加密的APP_KEY
    ```bash=
    php artisan key:generate
    ```

4. 設定資料庫
    在MySQL新增資料庫

5. Migration 和 Seeding 建立資料表結構
    ```bash
    // 遷移資料表
    php artisan migrate
    
    // 填充測試資料
    php artisan db:seed
    ```

## 障礙排除

- 清除快取

```bash
php artisan comfig:clear
```