<?php

function parsePdfTextExact($filePath) {
    if (!file_exists($filePath)) return [];
    $content = file_get_contents($filePath);
    $textTokens = [];

    // Extract all PDF streams
    preg_match_all('/stream[\r\n]+(.*?)[\r\n]+endstream/s', $content, $matches);
    foreach ($matches[1] as $stream) {
        $decompressed = @gzuncompress($stream);
        if ($decompressed === false) {
            $decompressed = @gzinflate($stream);
        }
        $streamData = ($decompressed !== false) ? $decompressed : $stream;

        // Match all TJ arrays: [(...) ...] TJ
        preg_match_all('/\[(.*?)\]\s*TJ/s', $streamData, $tjMatches);
        foreach ($tjMatches[1] as $tjContent) {
            // Match all parenthesized strings inside TJ array: (text)
            preg_match_all('/\((.*?)\)/s', $tjContent, $strMatches);
            if (!empty($strMatches[1])) {
                $joinedToken = implode('', $strMatches[1]);
                // Clean unescaped slashes
                $joinedToken = str_replace(['\\.', '\\(', '\\)'], ['.', '(', ')'], $joinedToken);
                $textTokens[] = trim($joinedToken);
            }
        }
    }

    return array_filter($textTokens);
}

$file = 'C:/Users/agung windu/.gemini/antigravity/scratch/sistem-retribusi-red/public/uploads/1787019275_tesr.pdf';
$tokens = parsePdfTextExact($file);

echo "EXTRACTED PDF TOKENS:\n";
print_r($tokens);
