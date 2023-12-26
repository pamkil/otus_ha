Запуск docker машин для разработки
---
Запуск docker машин

```
./dstart.sh
```

___
Для остановки docker машин

```
./ddown.sh
```


How to generate JWT RS256 key
-

```
cd api/runtime
ssh-keygen -t rsa -b 4096 -m PEM -f jwtRS256.key
```

# Don't add passphrase (Генерировать ключи без задания пароля)

```
openssl rsa -in jwtRS256.key -pubout -outform PEM -out jwtRS256.key.pub
cat jwtRS256.key
cat jwtRS256.key.pub
```