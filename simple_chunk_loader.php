<?php
$linksArr = explode("\n", file_get_contents("list_links.txt"));
/*
 * If you want download with links from file, uncomment all $dlink lines and set comment $argv;
 * File will be downloaded to current directory;
 */
//foreach ($linksArr as $key => $dlink) {

    for ($i = 0; $i <= 2700; $i++) {

        if ($i % 270 == 0) {
            echo 'Download ' . $i / 270 . '0%' . PHP_EOL;
        }

        //if it needs reverse chunk like 000001;
        $countChunkPieces = 5;
        $countArr = str_split($i);
        $arrM =  array_fill(0, ($countChunkPieces - count($countArr)), 0);
        $iStr = implode(array_merge($arrM, $countArr)); //00001, 00012, 00122 etc

//        $dlink = $dlink . $i; // without end of link;
        //$dlink = $dlink . $i . "part_might_be_after_chunks_number"; //uncomment and replace if you need end link after chunks number;
        $media = @file_get_contents($argv[1]. $i . $argv[2]);
        //$media = @file_get_contents($dlink);
        if (!$media) {
            //echo "File not found";
        } else {
            file_put_contents("./" . $argv[3] . ".ts", $media, FILE_APPEND);
            //file_put_contents("./video_".$key.".ts", $media, FILE_APPEND);
        }
    }
//}