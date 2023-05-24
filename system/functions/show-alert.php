<?php


function showAlert(string $color , string $message): void {
    echo "  <div class=\"alert alert-$color\">
                <b>$message</b>
            </div>";
    
}