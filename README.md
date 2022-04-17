```
1. Install docker, docker-composer first
2. Clone source code
   $ git clone git@github.com:tatadongvanhung/nft_marketplace_main.git
3. Access the source code folder:
   $ cd ~/nft_marketplace_main
4. Run docker
   $ docker-compose up 
5. Open new tab, cd to nft_marketplace_main
   Run: $ cp .env.example .env
6. Execute Docker commands
   docker exec -it nftmarketplacemain-php /bin/sh
7. On docker container, run 
   - composer install
   - php artisan key:generate
   - php artisan migrate
   - php artisan db:seed
8. Access http://localhost/ with a browser to test

```
Author: Tran Hoang Giang && Dong Van Hung © 2022


API:
```
NFT:
1>Index: GET: http://localhost/api/nft/index
2>Show: GET: http://localhost/api/nft/get/{cid}
3>Create: POST: http://localhost/api/nft/create - Với dữ liệu gửi kèm là chuỗi JSON: {"cid":"","album_id":""}.
4>Delete: GET: http://localhost/api/nft/delete/{cid}
5>Get list by Album: GET http://localhost/api/nft/album-id/{albumID}
6>Get list by Genre: GET http://localhost/api/nft/genre-id/{genreID}
```
```
Album:
1>Index: GET: http://localhost/api/album/index
2>Show: GET: http://localhost/api/album/get/{id}
3>Create: POST: http://localhost/api/album/create - Với dữ liệu gửi kèm là chuỗi JSON: {"name":"","description":""}.
4>Delete: GET: http://localhost/api/album/delete/{id}
```
```
Genre:
1>Index: GET: http://localhost/api/genre/index
2>Show: GET: http://localhost/api/genre/get/{id}
3>Create: POST: http://localhost/api/genre/create - Với dữ liệu gửi kèm là chuỗi JSON: {"name":"","description":""}.
4>Delete: GET: http://localhost/api/genre/delete/{id}
```
