<?php


namespace SecureNative\sdk;

use Patchwork;
use Arrays;
//use Patchwork\R;
use function Patchwork\{redefine, relay, getMethod};
//require '../vendor/antecedent/patchwork/Patchwork.php';


class Agent
{

    public static function changeClassMethod($methodToReplace, $newMethod)
    {
        redefine($methodToReplace, $newMethod);
    }

    public static function getDependencies($path){
        $strJsonFileContents = file_get_contents($path);
        $decoded = json_decode($strJsonFileContents, true);
        $dep = "";
        if(array_key_exists("require",$decoded)){
            foreach ($decoded["require"] as $key => $value)
                $dep = $dep."\n".$key."-".$value;
        }
        return $dep;
    }

}