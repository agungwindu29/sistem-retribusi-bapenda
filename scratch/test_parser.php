<?php

function parsePdfRawText($filePath) {
    if (!file_exists($filePath)) return '';
    $content = file_get_contents($filePath);
    $text = '';

    // Match all PDF streams
    preg_match_all('/stream[\r\n]+(.*?)[\r\n]+endstream/s', $content, $matches);
    foreach ($matches[1] as $stream) {
        $decompressed = @gzuncompress($stream);
        if ($decompressed === false) {
            $decompressed = @gzinflate($stream);
        }
        $streamData = ($decompressed !== false) ? $decompressed : $stream;

        // Match all parenthesized string tokens: (text)
        preg_match_all('/\((.*?)\)/s', $streamData, $strMatches);
        if (!empty($strMatches[1])) {
            foreach ($strMatches[1] as $token) {
                // Ignore metadata tokens like /P, /GS8, /MCID
                if (!preg_match('/^[\/\\\]/', $token)) {
                    $text .= $token;
                }
            }
            $text .= "\n";
        }
    }

    return $text;
}

$file = 'C:/Users/agung windu/.gemini/antigravity/scratch/sistem-retribusi-red/public/uploads/1787019275_tesr.pdf';
$extracted = parsePdfRawText($file);
echo "RAW EXTRACTED TEXT:\n" . $extracted . "\n";
