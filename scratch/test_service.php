<?php

require __DIR__ . '/../vendor/autoload.php';

$service = new \App\Services\PdfParserService();
$file = 'C:/Users/agung windu/.gemini/antigravity/scratch/sistem-retribusi-red/public/uploads/1787019275_tesr.pdf';

$result = $service->extractData($file, 'Dinas Perhubungan', 'Agustus 2026');

echo "PARSER SERVICE RESULT ON TESR.PDF:\n";
print_r($result);
