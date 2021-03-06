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
7>Search: GET http://localhost/api/nft/search/{search_string}
8>get by id : GET http://localhost/api/nft/get-id/{id}

9> GET http://localhost/api/nft/get-nft-not-in-album
10> POST http://localhost/api/nft/update-album 
{
    "nft_ids": [1,2],
    "ablum_id": 2
}
10> PUT: api/nft/get-nft-by-tokenid-ablum-null
{
    "token_ids": [1,2,3,4]
}
```
```
Album:
1>Index: GET: http://localhost/api/album/index
2>Show: GET: http://localhost/api/album/get/{id}
3>Create: POST: http://localhost/api/album/create - Với dữ liệu gửi kèm là chuỗi JSON: {"name":"","description":""}.
4>Delete: GET: http://localhost/api/album/delete/{id}
5>Get list album by metamask: http://localhost/api/album/get-by-metamask/{metamask_address}
```
```
Genre:
1>Index: GET: http://localhost/api/genre/index
2>Show: GET: http://localhost/api/genre/get/{id}
3>Create: POST: http://localhost/api/genre/create - Với dữ liệu gửi kèm là chuỗi JSON: {"name":"","description":""}.
4>Delete: GET: http://localhost/api/genre/delete/{id}
```
```
Transaction log:
1>Index: GET: http://localhost/api/transactionlog/index
2>Show: GET: http://localhost/api/transactionlog/get/{id}
3>Create: POST: http://localhost/api/transactionlog/create 
{
    "from": "",
    "to": "",
    "action": "",
    "ethPrice": "",
    "usdPrice": "",
    "tokenId": ""
}
4>Delete: GET: http://localhost/api/transactionlog/delete/{id}
5>update: Post: http://localhost/api/transactionlog/update/{id}
{
    "from": "",
    "to": "",
    "action": "",
    "ethPrice": "",
    "usdPrice": "",
    "tokenId": ""
}
6>: GET: http://localhost/api/transactionlog/get-tokenid/{tokenid}
6>: GET: http://localhost/api/transactionlog/get-address/{address}
```
```
User:
1>GET Find user by metamask_address or add : http://localhost/api/users/metamask/{metamask_address}, lưu metamask_address = name = request->metamask_address
2>POST update user: http://localhost/api/users/update/{metamask_address}
{
    "name": "",
    "description": "",
    "avatar_picture": "",
    "cover_picture": ""
}
3>PUT: list user by list address: http://localhost/api/users/get-list-user-by-address
{
    "address": ["hung", "0x59ea58BF0e42354759AB820Fc707FA5Ff42d13e1"]
}
```


```
Comments:
1> GET comment by NFT_ID: http://localhost/api/comments/nft/{nftId}
2> POST: create comment
{
    "nft_id": ,
    "metamask_address": "",
    "content": ""
}
3> POST: update comment: http://localhost/api/comments/update/4
{
    "content": ""
}
4> GET: Delete comment: http://localhost/api/comments/delete/{Id}


```
