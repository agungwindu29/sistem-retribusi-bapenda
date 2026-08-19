<?php

$file = 'C:/Users/agung windu/.gemini/antigravity/scratch/sistem-retribusi-red/public/uploads/1787019275_tesr.pdf';
$content = file_get_contents($file);

echo "FILE SIZE: " . strlen($content) . "\n";

// Decompress zlib streams if any
$streams = [];
preg_match_all('/stream[\r\n]+(.*?)[\r\n]+endstream/s', $content, $matches);

echo "STREAMS FOUND: " . count($matches[1]) . "\n";

foreach ($matches[1] as $i => $stream) {
    $decompressed = @gzuncompress($stream);
    if ($decompressed !== false) {
        echo "--- STREAM $i (DECOMPRESSED) ---\n";
        echo substr($decompressed, 0, 500) . "\n";
    } else {
        echo "--- STREAM $i (RAW) ---\n";
        echo substr($stream, 0, 200) . "\n";
    }
}
