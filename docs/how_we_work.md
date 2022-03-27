## Run on localhost

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
   - php artisan migrates
   - php artisan db:seed
8. Access http://localhost/ with a browser to test

```
