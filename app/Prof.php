<?php


namespace App;

/**
 * Copied from inet to analyze search performance
 * @package App
 */
class Prof
{
    // Call this at each point of interest, passing a descriptive string
    public static function prof_flag($str)
    {
        global $prof_timing, $prof_names;
        $prof_timing[] = microtime(true);
        $prof_names[] = $str;
    }

    // Call this when you're done and want to see the results
    public static function prof_print()
    {
        $text = [];
        global $prof_timing, $prof_names;
        $size = count($prof_timing);
        for($i=0;$i<$size - 1; $i++)
        {
            $text[] = $prof_names[$i];
            $text[] = $prof_timing[$i+1]-$prof_timing[$i];
        }
        $text[] = $prof_names[$size-1];
        return $text;
    }
}