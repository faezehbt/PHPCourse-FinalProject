<?php 


# 1 Verify PHOTO
function verifyPhoto(array $photo){
    $type = pathinfo($photo['name'] , PATHINFO_EXTENSION);
    $type = strtolower($type);


    #   Type
    if(!in_array($type,['jpg' , 'jpeg' , 'png' , 'webp' , 'gif'])){
        $error[] =  "***فرمت عکس باید jpg، jpeg و یا png باشد.";
    }

    #   Size
    if($photo['size'] > 5*1024*1024){
        $error[] =  "***حجم عکس باید کمتر از 5 مگابایت باشد.";
    }


    return $error; // خطاها را به صورت آرایه ای از پیام ها می دهد

}


# 2 Generate Photo Name
function namePhoto(int $id): string {
    $md5 = md5($id);
    return "profile-" . substr($md5 , 0 , 14) . $id . substr($md5 , 20 , 8) . ".png";
}


# 3 Resize & Upload Photo
function uploadPhoto(string $photo , string $savePath, $newSize = 200 ){

    list($w1 , $h1 , $type) = getimagesize($photo);

    if($w1 <= $newSize && $h1 <= $newSize)
        return move_uploaded_file($photo , $savePath);
    

    // Define source
    switch($type){
        case IMAGETYPE_JPEG :
            case IMG_JPG :
                $src = imagecreatefromjpeg($photo);
                break;
        case IMAGETYPE_PNG :
            $src = imagecreatefrompng($photo);
            break;
        case IMAGETYPE_WEBP :
            $src = imagecreatefromwebp($photo);
            break;
        case IMAGETYPE_GIF :
            $src = imagecreatefromgif($photo);
            break;
        default:
            return false;
    }

    $ratio = $w1/$h1;   // نسبت طول و عرض را محاسبه میکنیم تا با استفاده از آن هنگام تغییر ابعاد تصویر به هم نریزد
    
    if($ratio > 1){     // اگر عرض بزرگتر از طول باشد
        $w2 = $newSize;
        $h2 = $newSize / $ratio;
    }
    else {
        $h2 = $newSize; 
        $w2 = $newSize * $ratio;
    }

    $thumb = imagecreatetruecolor(round($w2) , round($h2));

    imagecopyresized($thumb , $src , 0,0,0,0 , $w2 , $h2 , $w1 , $h1);
    
    return imagepng($thumb , $savePath);

}

