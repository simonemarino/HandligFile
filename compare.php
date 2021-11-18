<?php

ini_set('memory_limit', '16M');


$f1 = 'f1.txt';
$f2 = 'f2.txt';
$res = compare_files($f1, $f2);
if(!$res){
    echo "File not equals";
}else{
    echo "File equals";
}



function compare_files( string $sFileNameA, string $sFileNameB ) : ?bool{
    // Check File Exists
    $res = check_exists($sFileNameA, $sFileNameB);
    if (!is_null($res)){
        if(!CheckEqualsFile($sFileNameA, $sFileNameB)){
            return False;
        }else{
            return True;
        }
    }else{
        return NULL;
    }

    return False;
}

/**
 * @param string $sFileNameA
 * @param string $sFileNameB
 * @return array
 */
function CheckEqualsFile(string $sFileNameA, string $sFileNameB): bool
{

    $handle1 = fopen($sFileNameA, "r");
    $handle2 = fopen($sFileNameB, "r");
    if ($handle1 && $handle2) {

        $array_h1 = [];
        $array_h2 = [];
        while ($line = fgets($handle1)) {
            array_push($array_h1, md5($line));
        }
        $array_h1 = implode(",", $array_h1);
        $code_h1 = md5($array_h1);
        fclose($handle1);

        while ($line = fgets($handle2)) {
            // process the line read.
            array_push($array_h2, md5($line));
        }
        $array_h2 = implode(",", $array_h2);
        $code_h2 = md5($array_h2);
        fclose($handle2);

        if($code_h1 != $code_h2){
            return False;
        }else{
            return True;
        }

    } else {
        // Error opening
        echo False;
    }

}


/**
 * @param string $sFileNameA
 * @param string $sFileNameB
 * @return bool|null
 */
function check_exists(string $sFileNameA, string $sFileNameB): ?bool
{
    if (!file_exists($sFileNameA) && !file_exists($sFileNameB)) {
        //Both files do not exist
        return NULL;
    } else if (!file_exists($sFileNameA)) {
        //Exist only file :  $sFileNameB
        return NULL;
    } else if (!file_exists($sFileNameB)) {
        //Exist only file :  $sFileNameA
        return NULL;
    } else {
        //Both files exist
        return true;
    }
}

?>