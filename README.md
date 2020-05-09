<p align="center">
    <h1 align="center">Food system demo</h1>
    <br>
</p>





DIRECTORY STRUCTURE
-------------------

      assets/modules/admin/Admin.php             Admin module file



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP >= 7.0



Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/basic/web/
~~~

### Run with Docker   
    
Start the container

    docker-compose up -d
    
You can then access the application through the following URL:

    http://127.0.0.1:8010


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```
