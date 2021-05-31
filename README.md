# kakanai-kadai

## 手順

1. 「Use this template」からリポジトリをコピー

![image](https://user-images.githubusercontent.com/52206492/119965548-5a664580-bfe5-11eb-809e-b6b7324f798c.png)

2. リポジトリ名を「kakanai-kada-氏名」にしてaboutに「カカナイ課題 氏名」を記載

![image](https://user-images.githubusercontent.com/52206492/119966075-e7a99a00-bfe5-11eb-91e2-71069e58c966.png)

3. 作成したリポジトリをローカルにクローンして作業を行う

![image](https://user-images.githubusercontent.com/52206492/119966351-30615300-bfe6-11eb-98c8-4f59eed3f2ee.png)


## Dockerでの起動

未対応

---
## ローカルで起動

### Composerのインストール

```bash
$ composer install
```

### npmのインストール

```bash
$ npm install
```

### データベースとユーザの作成

```bash
$ mysql -u root -p****
create database kakanai_kadai;
grant all privileges on kakanai_kadai.* to kakanai_kadai@localhost identified by 'secret';
exit
```

### テーブルの作成

```bash
$ php artisan migrate --seed
```

### API認証

```bash
$ php artisan passport:install
```

### ビルド

```bash
$ npm run watch
```

```bash
$ php artisan serve
Laravel development server started: <http://127.0.0.1:8000>
```

![image](https://user-images.githubusercontent.com/52206492/98334880-3b9f6200-2047-11eb-9e03-c4e6dd34bd23.png)

ブラウザにて http://127.0.0.1:8000 へアクセス

---
