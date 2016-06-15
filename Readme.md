# Damerau Levenshtein distance

Enclosed function computes the [Damerau Levenshtein distance](https://en.wikipedia.org/wiki/Damerau%E2%80%93Levenshtein_distance)
between two strings. It contains modifications for recognizing the transposition of adjacent characters.

```php
require_once('damlev.php');
$dist = editDistance('levenshtein', 'levenstein');
```
