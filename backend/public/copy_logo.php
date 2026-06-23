<?php
$source = 'C:\\Users\\saous\\.gemini\\antigravity-ide\\brain\\4f3a4f9a-ac96-4cd5-b907-f297eb852f07\\media__1782252783184.png';
$dest = 'c:\\Users\\saous\\.gemini\\antigravity-ide\\scratch\\spanish-learning-platform\\frontend\\public\\ofppt_logo.png';
if (copy($source, $dest)) {
    echo "SUCCESS";
} else {
    echo "FAILED";
}
