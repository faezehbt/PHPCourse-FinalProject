<?php

    function addUser(object $conn , string $table , int $num){

        for($i =1 ; $i <= $num ; $i++){
            $username = "test-user$i";
            $password = "test-user$i-123";
            $email = "test-user$i@gmail.com";
            $res = $conn -> prepare("INSERT INTO `$table`
                                    (`username`,`password`,`email`,`mobile`) VALUES
                                    ('$username','$password','$email','09120123456')");
            if(!$res -> execute())  die("عملیات اضافه کردن کاربر با مشکل مواجه شد");

        }

        

    }


?>