<?php

namespace CRDV\Model\Config;

abstract class config
{
   public static function getKey(){
     return "QG5H\]M#^Zm/\#\}Pyn@2q6_5G6pvHb_\'/";
   }

    public static function getKeyBase64(){
        return base64_encode(self::getKey());
    }
}