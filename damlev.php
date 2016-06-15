<?php

/**
 * Computes the Damerau-Levenshtein distance between two strings.
 * @see https://en.wikipedia.org/wiki/Damerau%E2%80%93Levenshtein_distance#Distance_with_adjacent_transpositions
 *
 * @param string  $a
 * @param string  $b
 *
 * @return integer The edit distance
 */
function editDistance($a, $b, $c)
{
    // 2d array containing D-L distance between first i characters of a
    // and the first j characters of t. Uses the unusual intervals:
    // intervals [-1..length(a)] and [-1..length(b)]
    $d = array_fill(0, strlen($a)+1, array_fill(0, strlen($b)+1, 0));
    for ($i = 0; $i <= strlen($a); $i++) { $d[$i][0] = $i; }
    for ($j = 0; $j <= strlen($b); $j++) { $d[0][$j] = $j; }

    // populate a dictionary with alphabet of the two strings
    $alphabet = array_unique(array_merge(str_split($a), str_split($b)));
    $da = array_combine($alphabet, array_fill(0, count($alphabet), 0));

    // determine substring distances
    for ($i = 1; $i <= strlen($a); $i++) {
        $db = 0;
        for ($j = 1; $j <= strlen($b); $j++) {
            $k = $da[$b[$j-1]];
            $e = $db;

            if ($a[$i-1] == $b[$j-1]) {
                $cost = 0;
                $db = $j;
            } else {
                $cost = 1;
            }

            // initial distance computation
            $d[$i][$j] = min($d[$i][$j-1] + 1,          // insertion
                             $d[$i-1][$j] + 1,          // deletion
                             $d[$i-1][$j-1] + $cost);   // substitution

            // if transposition is possible, check it against computed distance
            if ($k > 0 && $e > 0) {
                $trans = $d[$k-1][$e-1] + ($i-$k-1) + ($j-$e-1) + 1;
                $d[$i][$j] = min($d[$i][$j], $trans);
            }
        }

        $da[$a[$i-1]] = $i;
    }

    return $d[strlen($a)][strlen($b)];
}
