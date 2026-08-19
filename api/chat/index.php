<?php
/**
 * POST /api/chat/index.php
 * Intelligent Hybrid Chatbot Engine for PARFY.ID
 * Powered by External AI with High-Intelligence Local Fallback Engine
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

// ========== CONFIGURATION ==========
define('PERPLEXITY_API_KEY', 'YOUR_PERPLEXITY_API_KEY');
define('PERPLEXITY_HOST', 'api.perplexity.ai');
define('PERPLEXITY_MODEL', 'sonar');

// ========== TIME & GREETING SETUP ==========
date_default_timezone_set('Asia/Jakarta');
$hour = (int) date('G');
if ($hour >= 5 && $hour < 11) {
    $timeGreeting = 'Selamat pagi';
} elseif ($hour >= 11 && $hour < 15) {
    $timeGreeting = 'Selamat siang';
} elseif ($hour >= 15 && $hour < 18) {
    $timeGreeting = 'Selamat sore';
} else {
    $timeGreeting = 'Selamat malam';
}

$data = getJsonBody();
$message = trim($data['message'] ?? '');
$userName = trim($data['userName'] ?? '');
$history = $data['history'] ?? [];

if (empty($message)) {
    jsonResponse(['error' => 'Pesan tidak boleh kosong'], 400);
}

$db = getDB();

// Fetch live products for catalog and recommendation engine
$products = [];
$res = $db->query("SELECT id, name, brand, category, price, stock, aroma, description, scent_category, sold FROM products ORDER BY sold DESC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $products[] = $row;
    }
}

// ========== LOCAL INTELLIGENT BOT ENGINE ==========
function generateSmartReply($userMessage, $products, $timeGreeting, $userName) {
    $msgLower = strtolower($userMessage);
    $salutation = $userName ? "Kak $userName" : "Kak";
    $prefix = "$timeGreeting $salutation! ";

    // 1. General Greetings & Small Talk
    if (preg_match('/\b(halo|hai|hi|hey|hello|pagi|siang|sore|malam|assalamualaikum|permisi|ping)\b/i', $msgLower)) {
        return "$prefix Ada yang bisa saya bantu hari ini? Saya bisa memberikan rekomendasi parfum sesuai aroma favorit, membantu info pemesanan, atau mengecek promo spesial untuk Anda! ✨";
    }

    if (preg_match('/\b(terima kasih|makasih|thanks|thank you|makasi|tengkyu|ok|oke|sip|mantap|keren)\b/i', $msgLower)) {
        return "Sama-sama $salutation! Senang bisa membantu. Jika ada pertanyaan seputar koleksi parfum lainnya, jangan ragu untuk tanya saya ya! 😊🌸";
    }

    // 2. Info Layanan & Transaksi
    if (preg_match('/(cara (pesan|beli|order|belanja)|gimana cara belinya)/i', $msgLower)) {
        return "Cara belanja di PARFY.ID sangat mudah $salutation:\n" .
               "1. Pilih parfum favorit Anda di menu katalog.\n" .
               "2. Klik **Beli Sekarang** atau masukkan ke **+ Keranjang**.\n" .
               "3. Masuk ke halaman **Keranjang** dan pilih alamat pengiriman.\n" .
               "4. Pilih ekspedisi pengiriman (JNE, POS, TIKI).\n" .
               "5. Lakukan pembayaran instan via Transfer Bank, QRIS, E-Wallet, atau Minimarket.";
    }

    if (preg_match('/(bayar|pembayaran|metode bayar|qris|transfer|bca|mandiri|bri|bni|gopay|ovo|dana|shopeepay|alfamart|indomaret)/i', $msgLower)) {
        return "PARFY.ID mendukung berbagai metode pembayaran otomatis & aman via Midtrans:\n" .
               "• **QRIS**: BCA, GoPay, OVO, Dana, LinkAja, ShopeePay\n" .
               "• **Virtual Account / Transfer Bank**: BCA, Mandiri, BNI, BRI, Permata\n" .
               "• **Minimarket**: Indomaret & Alfamart\n" .
               "Pembayaran akan terverifikasi secara otomatis dalam hitungan detik!";
    }

    if (preg_match('/(ongkir|kirim|ekspedisi|pengiriman|jne|tiki|pos|berapa hari|kurir)/i', $msgLower)) {
        return "Untuk pengiriman, PARFY.ID bekerja sama dengan ekspedisi terpercaya:\n" .
               "• **JNE** (Reguler / YES)\n" .
               "• **POS Indonesia** (Pos Reguler)\n" .
               "• **TIKI** (Reguler / ONS)\n" .
               "Ongkos kirim dihitung otomatis secara akurat berdasarkan kota tujuan saat Anda melakukan checkout.";
    }

    if (preg_match('/(asli|original|ori|palsu|garansi|authentic|kw)/i', $msgLower)) {
        return "Semua parfum di **PARFY.ID 100% Original & Authentic** bergaransi resmi. Kami bekerja sama langsung dengan distributor resmi dan brand lokal terpercaya seperti Mykonos & HMNS. Garansi uang kembali jika produk terbukti tidak asli!";
    }

    if (preg_match('/(promo|diskon|voucher|murah|potongan)/i', $msgLower)) {
        $promoList = [];
        foreach ($products as $p) {
            if ($p['price'] <= 200000 || in_array($p['id'], ['PRD001', 'PRD002', 'PRD008', 'PRD011', 'PRD014'])) {
                $promoList[] = $p;
            }
        }
        $reply = "Berikut beberapa parfum dengan **penawaran promo spesial** di PARFY.ID $salutation:\n";
        $count = 0;
        foreach ($promoList as $p) {
            if ($count >= 3) break;
            $formattedPrice = 'Rp ' . number_format($p['price'], 0, ',', '.');
            $reply .= "• [{$p['name']}](/coding web IMK/parfy-php/detail-produk?id={$p['id']})\n" .
                      "  Harga: **{$formattedPrice}** | Aroma: _{$p['aroma']}_\n";
            $count++;
        }
        $reply .= "\nKunjungi menu [Promo Spesial](/coding web IMK/parfy-php/kategori?notes=promo) untuk melihat seluruh daftar diskon!";
        return $reply;
    }

    if (preg_match('/(status|pesanan|lacak|resi|cek pesanan|order saya)/i', $msgLower)) {
        return "Untuk mengecek status pesanan dan nomor resi Anda, silakan buka menu [Pesanan Saya](/coding web IMK/parfy-php/pesanan). Semua riwayat dan nomor resi pengiriman akan tertera lengkap di sana!";
    }

    // 3. Specific Scent / Note Matching
    $matched = [];
    $keywords = [
        'vanilla' => ['vanilla', 'sweet', 'manis', 'gourmand', 'kue', 'caramel', 'karamel'],
        'woody' => ['woody', 'kayu', 'oud', 'gaharu', 'sandalwood', 'cedarwood', 'earthy', 'maskulin'],
        'fresh' => ['fresh', 'segar', 'aquatic', 'laut', 'air', 'citrus', 'lemon', 'bergamot', 'mint', 'siang'],
        'floral' => ['floral', 'bunga', 'rose', 'mawar', 'jasmine', 'melati', 'blossom', 'feminin'],
        'fruity' => ['fruity', 'buah', 'peach', 'berry', 'strawberry', 'apple', 'apel', 'manis segar'],
        'coffee' => ['kopi', 'coffee', 'espresso', 'cappuccino'],
        'spicy' => ['spicy', 'rempah', 'cinnamon', 'pepper', 'hangat'],
        'pria' => ['cowok', 'pria', 'laki', 'pria', 'maskulin', 'ganteng'],
        'wanita' => ['cewek', 'wanita', 'perempuan', 'feminin', 'cantik', 'anggun'],
        'tahan lama' => ['tahan lama', 'awet', 'seharian', 'long lasting', 'kuat', 'sillage'],
        'kantor' => ['kantor', 'kerja', 'meeting', 'formal', 'elegan', 'rapat'],
        'kencan' => ['kencan', 'date', 'pacaran', 'romantis', 'malam', 'dinner', 'hangout']
    ];

    $matchedCategory = null;
    foreach ($keywords as $cat => $words) {
        foreach ($words as $word) {
            if (strpos($msgLower, $word) !== false) {
                $matchedCategory = $cat;
                break 2;
            }
        }
    }

    // Filter products matching user keywords or brand/name
    foreach ($products as $p) {
        $pName = strtolower($p['name']);
        $pBrand = strtolower($p['brand']);
        $pAroma = strtolower($p['aroma']);
        $pDesc = strtolower($p['description']);
        $pCat = strtolower($p['category']);

        $score = 0;
        // Direct product name match
        if (strpos($msgLower, 'stilettos') !== false && strpos($pName, 'stilettos') !== false) $score += 10;
        if (strpos($msgLower, 'baby love') !== false && strpos($pName, 'baby love') !== false) $score += 10;
        if (strpos($msgLower, 'orgsm') !== false && strpos($pName, 'orgsm') !== false) $score += 10;
        if (strpos($msgLower, 'alpha') !== false && strpos($pName, 'alpha') !== false) $score += 10;
        if (strpos($msgLower, 'moroccan') !== false && strpos($pName, 'moroccan') !== false) $score += 10;
        if (strpos($msgLower, 'pink beach') !== false && strpos($pName, 'pink beach') !== false) $score += 10;
        if (strpos($msgLower, 'utopia') !== false && strpos($pName, 'utopia') !== false) $score += 10;
        if (strpos($msgLower, 'eos') !== false && strpos($pName, 'eos') !== false) $score += 10;
        if (strpos($msgLower, 'farhampton') !== false && strpos($pName, 'farhampton') !== false) $score += 10;

        // Brand match
        if (strpos($msgLower, 'mykonos') !== false && strpos($pBrand, 'mykonos') !== false) $score += 3;
        if (strpos($msgLower, 'hmns') !== false && strpos($pBrand, 'hmns') !== false) $score += 3;

        // Keyword matches
        if ($matchedCategory) {
            foreach ($keywords[$matchedCategory] as $w) {
                if (strpos($pAroma, $w) !== false || strpos($pDesc, $w) !== false || strpos($pCat, $w) !== false) {
                    $score += 2;
                }
            }
        }

        if ($score > 0) {
            $matched[] = ['product' => $p, 'score' => $score];
        }
    }

    // Sort by score
    usort($matched, function($a, $b) {
        return $b['score'] - $a['score'];
    });

    if (!empty($matched)) {
        $recommendations = array_slice($matched, 0, 3);
        $reply = "Berikut rekomendasi parfum terbaik yang cocok untuk Anda $salutation:\n\n";
        foreach ($recommendations as $item) {
            $p = $item['product'];
            $formattedPrice = 'Rp ' . number_format($p['price'], 0, ',', '.');
            $reply .= "✨ **[{$p['name']}](/coding web IMK/parfy-php/detail-produk?id={$p['id']})**\n" .
                      "• **Brand**: {$p['brand']} ({$p['category']})\n" .
                      "• **Harga**: {$formattedPrice}\n" .
                      "• **Aroma**: {$p['aroma']}\n\n";
        }
        $reply .= "Silakan klik nama parfum di atas untuk melihat detail lengkap atau melakukan pemesanan!";
        return $reply;
    }

    // 4. Default helpful guidance
    $topProducts = array_slice($products, 0, 3);
    $reply = "Halo $salutation, di PARFY.ID kami memiliki beragam pilihan parfum original terbaik:\n\n";
    foreach ($topProducts as $p) {
        $formattedPrice = 'Rp ' . number_format($p['price'], 0, ',', '.');
        $reply .= "• **[{$p['name']}](/coding web IMK/parfy-php/detail-produk?id={$p['id']})** ({$formattedPrice}) - _{$p['aroma']}_\n";
    }
    $reply .= "\nAnda bisa sebutkan aroma yang diinginkan (misal: *manis vanilla, segar laut, woody maskulin, atau floral feminin*) agar saya bisa merekomendasikan pilihan yang paling pas!";
    return $reply;
}

// ========== TRY CALLING PERPLEXITY AI FIRST ==========
function callPerplexity($messages) {
    $payload = json_encode([
        'model' => PERPLEXITY_MODEL,
        'messages' => $messages,
        'temperature' => 0.3,
        'max_tokens' => 800
    ]);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://' . PERPLEXITY_HOST . '/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . PERPLEXITY_API_KEY
        ],
        CURLOPT_TIMEOUT => 6
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($error || $statusCode !== 200) {
        return null;
    }

    $decoded = json_decode($response, true);
    return $decoded['choices'][0]['message']['content'] ?? null;
}

// 1. Attempt AI call with short timeout
$productContext = '';
foreach (array_slice($products, 0, 20) as $p) {
    $priceFormatted = 'Rp ' . number_format($p['price'], 0, ',', '.');
    $productContext .= "- [{$p['name']}](/coding web IMK/parfy-php/detail-produk?id={$p['id']}) ({$p['brand']}) | {$p['category']} | {$priceFormatted} | {$p['aroma']}\n";
}

$systemPrompt = "Kamu adalah Customer Service cerdas dari PARFY.ID, toko parfum online terpercaya di Indonesia. Waktu saat ini: $timeGreeting WIB. Nama pelanggan: " . ($userName ?: 'Kak') . ". Jawab ramah, informatif, gunakan format [Nama Produk](/coding web IMK/parfy-php/detail-produk?id=ID) saat menyebut produk.";

$messages = [
    ['role' => 'system', 'content' => $systemPrompt],
    ['role' => 'user', 'content' => $message]
];

$reply = callPerplexity($messages);

// 2. Fallback to Local AI Engine if cloud AI is unavailable
if (empty($reply)) {
    $reply = generateSmartReply($message, $products, $timeGreeting, $userName);
    $engine = 'PARFY AI Smart Engine (Local)';
} else {
    $engine = 'Perplexity AI (Cloud)';
}

// 3. Return Successful Response
jsonResponse([
    'status' => 'success',
    'reply' => $reply,
    'model' => $engine
]);
