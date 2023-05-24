<?php


    function pagination(int $pageCount = 1 , int $selectedPage = 1 , string $baseLink) {
       

       
        $thirdLastPage = $pageCount - 2;

        if($pageCount >= 8){
            $dot_flag = false;
            for($i=1 ; $i <= $pageCount; $i++){
                if  (
                        ($i<=3) ||
                        ($i >= $thirdLastPage) ||
                        (($i >= $selectedPage-1) && ($i <= $selectedPage+1))
                    ){
                        $color = $i == $selectedPage ? 'btn-light' : ' btn-primary';
                        echo "  <a  href='$baseLink?page=$i' class='btn $color'>$i</a>";
                        $dot_flag = true; 
                    }
                else if($dot_flag){
                    echo "...";
                    $dot_flag = false;
                }
            }            
        }
        else if($pageCount < 8){
            for($i=1 ; $i <= $pageCount; $i++){

                $color = $i == $selectedPage ? 'btn-light' : ' btn-primary';
                echo "  <a  href='$baseLink?page=$i' class='btn $color'>$i</a>";
            

            }
        }
        
        
        echo '<br>';

    }


?>