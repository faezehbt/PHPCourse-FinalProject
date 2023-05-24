<?php



    function CountTableRows(object $conn , string $table): int {
        
        $res = $conn -> prepare("SELECT COUNT(*) as row_count FROM `$table`");
        if(!$res->execute()) die("درخواست شما به دیتابیس با مشکل مواجه شد");
        $count = $res -> fetch();

        return $count['row_count'];       


    }



?>