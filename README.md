Open SQL tab in phpmyadmin and run the below Store Procedure. And use **CALL user_login(?,?)** in PHP file just to call the store procedure.

```
DELIMITER //
CREATE PROCEDURE user_login(IN user_id VARCHAR(100), IN pass VARCHAR(100))
BEGIN
     SELECT * FROM registration WHERE email=`user_id` AND password=`pass` LIMIT 1;
END //
DELIMITER ;
```
