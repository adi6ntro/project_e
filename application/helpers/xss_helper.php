<?php

function echo_secure($str){
    echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
