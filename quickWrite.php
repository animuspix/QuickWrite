<?php

    $targetCounter;

    $escapeArray = array("`", "|", "^", "*", "/", "~", "-", "<", ">", "+");
    $escapeCharCodes = array("&#96;", "&#124;", "&#94;", "&#42;", "&#47;", "&#126;", "&#45;", "&lt;", "&gt;", "&#43;");

    function target($charConvert) {
        
        global $escapeArray,
               $escapeCharCodes;
        
        for ($targetCounter = 0; $targetCounter < count($escapeArray); $targetCounter += 1)
            if ($charConvert === $escapeArray[$targetCounter]) {
                return $escapeCharCodes[$targetCounter];
                //return "e";
            }
    }

    function publisher($file) {
        
        $text = file_get_contents($file);
        $textArray = array();
        $textPusher;
        $textArrayCrawler;
        
        $postCrawler = 0;
        $italCount = 0;
        $underlineCount = 0;
        $boldCount = 0;
        $strikeCount = 0;
        $linkCount = 0;
        $linkTextCount = 0;
        $escapeCount = 0;
        $headerCount = 0;
        
        for ($textPusher = 0; $textPusher < strlen($text); $textPusher += 1) {

            $currentChar = substr($text, $textPusher, 1);

            if ($currentChar === "~") {
                $escapeCount += 1;   
            }

            if ($escapeCount === 0) {

                if ($currentChar === "^" and $linkCount === 0) {
                    array_push($textArray, "<a href='");
                    $linkCount += 1;

                } elseif ($currentChar === "`" and $linkCount === 1 and $linkTextCount === 0) {
                    array_push($textArray, "'>");
                    $linkTextCount += 1;

                } elseif ($currentChar === "`" and $linkCount === 1 and $linkTextCount === 1) {
                    array_push($textArray, "");

                } elseif ($currentChar === "^" and $linkCount === 1 and $linkTextCount === 1) {
                    array_push($textArray, "</a>");
                    $linkCount = 0;
                    $linkTextCount = 0;
                }

                if ($linkCount === 0) {
                    if ($currentChar === "/" and $italCount === 0) {
                        array_push($textArray, "<em>"); 
                        $italCount += 1;

                    } elseif ($currentChar === "/" and $italCount === 1){
                        array_push($textArray, "</em>");
                        $italCount = 0;
                    } 

                    if ($currentChar === "-" and $strikeCount === 0) {
                        array_push($textArray, "<strike>");
                        $strikeCount += 1;

                    } elseif ($currentChar === "-" and $strikeCount === 1) {
                        array_push($textArray, "</strike>");
                        $strikeCount = 0;
                    }

                    if ($currentChar === "_" and $underlineCount === 0) {
                        array_push($textArray, "<u>");
                        $underlineCount += 1;

                    } elseif ($currentChar === "_" and $underlineCount === 1) {
                        array_push($textArray, "</u>");
                        $underlineCount = 0;
                    }

                    if ($currentChar === "*" and $boldCount === 0) {
                        array_push($textArray, "<strong>");
                        $boldCount += 1;

                    } elseif ($currentChar === "*" and $boldCount === 1) {
                        array_push($textArray, "</strong>");
                        $boldCount = 0;
                    }

                    if ($currentChar === "|") {
                        array_push($textArray, "<br>");
                    }

                    if ($currentChar === "+") {
                        array_push($textArray, "<h3>");
                        $headerCount += 1;

                    } elseif ($currentChar === "+" and $headerCount === 1) {
                        array_push($textArray, "</h3>");
                        $headerCount = 0;
                    }
                }
            } elseif ($currentChar === "~" and $escapeCount > 1) {
                array_push($textArray, target($currentChar));

            } elseif ($currentChar !== "~" and $escapeCount >= 1) {
                array_push($textArray, target($currentChar));
                $escapeCount = 0;
            }

            if ($currentChar !== "_" and $currentChar !== "*" and $currentChar !== "/" and $currentChar !== "-" and $currentChar !== "`" and $currentChar !== "~" and $currentChar !== "|" and $currentChar !== "^" and $currentChar !== "<" and $currentChar !== ">") {
                array_push($textArray, $currentChar);
            }
        }

        echo "<p>";

        for ($textArrayCrawler = 0; $textArrayCrawler < count($textArray); $textArrayCrawler += 1) {
            echo $textArray[$textArrayCrawler] . "";
        }

        echo "</p>";
    }
?>