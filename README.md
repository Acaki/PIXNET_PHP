### Installation
* Make sure you have `docker` installed.  
* If you are using windows powershell, replace any `"PWD"` with `${PWD}`.

* Initialize `composer` by
`docker run -it --rm -v "$PWD":/opt/project -w /opt/project acaki/php:7.4.3-dev composer install`


### Usage
##### Q3
* `docker run -it --rm -v "$PWD":/opt/project -w /opt/project acaki/php:7.4.3-dev php Q3/main.php`
* Paste your map input in the command prompt
* Type `end` to calculate result
* Type `exit` to terminate program  
  
![example](https://user-images.githubusercontent.com/10175554/78423240-9d55b300-7697-11ea-885e-1780c6622c27.png)

##### Q4
* `docker run -it --rm -v "$PWD":/opt/project -w /opt/project acaki/php:7.4.3-dev php vendor/phpunit/phpunit/phpunit Q4/tests`  
  
  
![example](https://user-images.githubusercontent.com/10175554/78423279-e0b02180-7697-11ea-808e-035af670bd1c.png)

