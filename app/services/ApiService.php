<?php
class ApiService {

    private $chatbotUrl;
    private $similarProductsUrl;
    private $syncProductsUrl;
    private $apiToken;

    public function __construct() {
        $baseUrl = rtrim(CHATBOT_API_URL, '/');
        $this->chatbotUrl = $baseUrl . '/chat-simple';
        $this->similarProductsUrl = $baseUrl . '/similar-products';
        $this->syncProductsUrl = $baseUrl . '/sync-products';
        $this->apiToken = trim((defined('CHATBOT_API_TOKEN') ? CHATBOT_API_TOKEN : ''));
    }

    // POST to Chatbot endpoint
    public function sendMessageToChatbot($userMessage, $sessionId = 'default') {
        $sanitizedMessage = trim((string)$userMessage);
        if ($sanitizedMessage === '') {
            return ['error' => 'Message cannot be empty'];
        }
        if (strlen($sanitizedMessage) > 2000) {
            $sanitizedMessage = substr($sanitizedMessage, 0, 2000);
        }

        $sanitizedSessionId = preg_replace('/[^A-Za-z0-9_-]/', '_', (string)$sessionId);
        if ($sanitizedSessionId === '') {
            $sanitizedSessionId = 'default';
        }

        $data = [
            'query' => $sanitizedMessage,
            'session_id' => $sanitizedSessionId,
            'user_id' => 'web_user',
            'base_url' => BASE_URL
        ];
        $res = $this->postRequest($this->chatbotUrl, $data);
        if (isset($res['error'])) {
            return $this->fallbackChatResponse($sanitizedMessage, BASE_URL);
        }
        return $res;
    }

    // POST to Similar Products endpoint
    public function getSimilarProducts($productId) {
        $numericProductId = (int)$productId;
        if ($numericProductId <= 0) {
            return ['error' => 'Invalid product id'];
        }

        $data = ['product_id' => (string)$numericProductId];
        $res = $this->postRequest($this->similarProductsUrl, $data);
        if (isset($res['error'])) {
            return $this->fallbackSimilarProducts($numericProductId);
        }
        return $res;
    }

    private function fallbackSimilarProducts($productId) {
        try {
            require_once BASE_PATH . '/config/database.php';
            require_once BASE_PATH . '/app/models/Product.php';
            $database = new Database();
            $db = $database->connect();
            $productModel = new Product($db);
            $products = $productModel->getAllProductsForAI();
            
            $target = null;
            foreach ($products as $p) {
                if ((int)($p['id'] ?? 0) === $productId) {
                    $target = $p;
                    break;
                }
            }
            if (!$target || empty($products)) return ['similar_products' => []];
            
            $targetCat = strtolower(trim((string)($target['category'] ?? '')));
            $similar = [];
            foreach ($products as $p) {
                if ((int)($p['id'] ?? 0) === $productId) continue;
                $cat = strtolower(trim((string)($p['category'] ?? '')));
                if ($cat === $targetCat || empty($targetCat)) {
                    $similar[] = [
                        'id' => $p['id'] ?? 0,
                        'name' => $p['product name'] ?? 'Product',
                        'price' => $p['price'] ?? 0,
                        'image_url' => $p['image_url'] ?? ''
                    ];
                }
                if (count($similar) >= 4) break;
            }
            return ['similar_products' => $similar];
        } catch (Exception $e) {
            return ['similar_products' => []];
        }
    }

    private function fallbackChatResponse($query, $baseUrl) {
        $qLower = strtolower(trim($query));
        $cleanQ = preg_replace('/[^\w\s]/', '', $qLower);

        // 1. Greetings
        $greetings = ['hi', 'hello', 'hey', 'salam', 'aoa', 'assalamualaikum', 'how are you', 'whats up', 'hey how are you', 'hi there', 'hello there', 'kaise ho', 'kese ho'];
        if (in_array(trim($cleanQ), $greetings, true) || preg_replace('/\s+/', '', $cleanQ) === 'howareyou') {
            return ['response' => "👋 Hello! I am Stitch Smart's AI Assistant. I'm doing great, thank you! How can I help you find the perfect clothing or answer your questions today?"];
        }

        // 2. Custom FAQ/Policy checks
        if (preg_match('/(type|categories|products kis type|kya milta)/i', $qLower)) {
            return ['response' => "👕 **Our Product Categories & Types:** At Stitch Smart, we offer a wide variety of high-quality clothing across multiple categories:\n\n• **Men's Apparel:** Casual Shirts, T-Shirts, Activewear, Winter Wear/Jackets, and Denim Jeans/Pants.\n• **Women's Collection:** Western Dresses, Tops, Skirts, and Co-ord Sets.\n• **Kids & Infants:** Stylish Outfits, T-Shirts, Shorts, and Baby Accessories/Socks.\n• **Custom Design ('Design Yourself'):** Custom printed hoodies, crewnecks, shorts, and shirts made to order!\n\nYou can explore our complete catalog right here:\n**[Browse All Products]({$baseUrl}allproducts)**"];
        }
        if (preg_match('/(size|fitting|measurement|chart)/i', $qLower)) {
            return ['response' => "📏 **Sizes & Sizing Guide:** We offer a full range of sizes including XS, S, M, L, and XL across our men's, women's, and kids' collections! For infants and babies, we have specialized age-based sizing. Each product card shows the exact stock available per size. If you're unsure about fit, let me know which item you like and I'll check for you!"];
        }
        if (preg_match('/(pay|cod|cash on delivery|card|method)/i', $qLower)) {
            return ['response' => "💳 **Payment Methods:** We make shopping easy! We accept **Cash on Delivery (COD)** nationwide, as well as secure online payments via Credit/Debit Cards, JazzCash, EasyPaisa, and Direct Bank Transfer."];
        }
        if (preg_match('/(budget|cheap|affordable|discount|sale)/i', $qLower)) {
            return ['response' => "💰 **Budget & Best Value:** Looking for affordable picks? Our collection starts from as low as Rs. 199 for kids' accessories and socks, with stylish shirts and tops under Rs. 1000! Just tell me your budget (e.g., 'show me items below 1000' or 'under 2000') and I'll find the best matches!"];
        }
        if (preg_match('/(policy|return|exchange|refund)/i', $qLower)) {
            return ['response' => "🔄 **Return & Exchange Policy:** We want you to love your wardrobe! We offer a hassle-free **7-day return and exchange policy**. If an item doesn't fit or you're not satisfied, simply ensure it is unworn with original tags attached and reach out to our team for an exchange or refund."];
        }
        if (preg_match('/(custom|design|print|logo|art order)/i', $qLower)) {
            return ['response' => "🎨 **Customization & Art Orders:** YES! We specialize in custom apparel and printing! You can use our interactive **'Design Yourself'** feature on the website to upload your artwork, logos, or custom text and place an 'Art Order'. Our master tailors will craft it exactly to your specifications!"];
        }
        if (preg_match('/(shipping|delivery|track|dispatch|charge)/i', $qLower)) {
            return ['response' => "📦 **Shipping & Delivery:** We offer fast, reliable doorstep shipping nationwide! Standard delivery takes 3-5 business days. Best of all, **Free Shipping** is available on all orders over Rs. 5000!"];
        }
        if (preg_match('/(fabric|stuff|material|cotton|wash|quality)/i', $qLower)) {
            return ['response' => "🧵 **Fabric Quality & Care:** At Stitch Smart, we use premium-grade fabrics! Our summer apparel features breathable 100% combed cotton and lawn, while winter wear uses warm fleece, denim, and wool blends. We recommend gentle machine wash in cold water to preserve color and fit."];
        }
        if (preg_match('/(location|shop|timing|contact|phone|email|support)/i', $qLower)) {
            return ['response' => "📍 **Customer Support & Contact:** Our online support team is here for you Mon-Sat from 9:00 AM to 9:00 PM! You can reach us via email at `support@stitchsmart.pk` or call/WhatsApp our helpline for instant assistance."];
        }

        // 3. Product filtering from MySQL DB
        try {
            require_once BASE_PATH . '/config/database.php';
            require_once BASE_PATH . '/app/models/Product.php';
            $database = new Database();
            $db = $database->connect();
            $productModel = new Product($db);
            $products = $productModel->getAllProductsForAI();

            if (empty($products)) {
                return ['response' => "We have many fantastic products available right now! Check out our collection here:\n**[Browse All Products]({$baseUrl}allproducts)**"];
            }

            // Colors check
            $colors = ['black', 'white', 'red', 'blue', 'green', 'pink', 'purple', 'brown', 'yellow', 'gray', 'grey', 'peach', 'navy'];
            $askedColor = null;
            foreach ($colors as $c) {
                if (str_contains($qLower, $c)) {
                    $askedColor = $c;
                    break;
                }
            }

            // Price max check (under 2000, below 1500, etc.)
            $maxPrice = null;
            if (preg_match('/(?:below|under|less\s*than|less|cheaper\s*than|cheaper|smaller\s*than|smaller|lower\s*than|lower|within|upto|up\s*to|max|at\s*most|<|sasta|sasti|under\s*rs\.?|below\s*rs\.?)\s*(?:rs\.?|pkr|rupees)?\s*(\d+)/i', $qLower, $m)) {
                $maxPrice = (float)$m[1];
            }

            // Price min check
            $minPrice = null;
            if (preg_match('/(?:above|greater\s*than|greater|more\s*than|more|higher\s*than|higher|min|at\s*least|>|mehenga|above\s*rs\.?|greater\s*than\s*rs\.?)\s*(?:rs\.?|pkr|rupees)?\s*(\d+)/i', $qLower, $m)) {
                $minPrice = (float)$m[1];
            }

            // Gender check
            $isWomen = preg_match('/(girl|women|ladies|female)/i', $qLower);
            $isMen = preg_match('/(boy|men|male)/i', $qLower);
            $isKid = preg_match('/(kid|child|children)/i', $qLower);

            // Item types check
            $itemTypes = ['shirt', 'jacket', 'dress', 'skirt', 'pant', 'jeans', 'top', 't-shirt', 'socks'];
            $askedType = null;
            foreach ($itemTypes as $t) {
                if (str_contains($qLower, $t)) {
                    $askedType = $t;
                    break;
                }
            }

            $stopWords = ['the','and','for','show','me','some','any','have','do','you','is','there','what','are','price','cost','give','can','please','tell','about','of','in','on','with','a','an'];
            $userWords = array_filter(explode(' ', $cleanQ), function($w) use ($stopWords) {
                return strlen($w) > 2 && !in_array($w, $stopWords);
            });

            $matched = [];
            foreach ($products as $p) {
                $pName = (string)($p['name'] ?? 'Product');
                $pDesc = (string)($p['description'] ?? '');
                $pDetails = (string)($p['details'] ?? '');
                $pCat = (string)($p['category'] ?? '');
                
                $pText = strtolower(trim($pName . ' ' . $pDesc . ' ' . $pDetails . ' ' . $pCat));
                $pVal = (float)preg_replace('/[^\d.]/', '', (string)($p['price'] ?? 0));

                $keywordScore = 0;
                foreach ($userWords as $w) {
                    if (str_contains($pText, $w)) {
                        $keywordScore++;
                    }
                }

                // Filter flags
                $failedFilter = false;
                if ($askedColor && !str_contains($pText, $askedColor)) $failedFilter = true;
                if ($maxPrice !== null && $pVal > $maxPrice) $failedFilter = true;
                if ($minPrice !== null && $pVal < $minPrice) $failedFilter = true;
                if ($isWomen && !preg_match('/(girl|women|ladies|female)/i', $pText)) $failedFilter = true;
                if ($isMen && !preg_match('/(boy|men|male|mens)/i', $pText)) $failedFilter = true;
                if ($isKid && !preg_match('/(kid|child|children)/i', $pText)) $failedFilter = true;
                if ($askedType && !str_contains($pText, $askedType)) $failedFilter = true;

                // Match if filters pass AND (it has keyword matches OR we are just filtering by criteria)
                if (!$failedFilter && ($keywordScore > 0 || empty($userWords) || $askedColor || $maxPrice !== null || $minPrice !== null || $isWomen || $isMen || $isKid || $askedType)) {
                    $p['score'] = $keywordScore;
                    $matched[] = $p;
                }
            }

            // Sort by keyword score descending
            usort($matched, function($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            // If match found
            if (!empty($matched)) {
                $reply = "✨ **Found " . count($matched) . " matching products for you!**\n\n";
                $count = 0;
                foreach ($matched as $m) {
                    $id = (int)($m['id'] ?? 0);
                    $name = trim((string)($m['name'] ?? 'Product'));
                    $price = number_format((float)preg_replace('/[^\d.]/', '', (string)($m['price'] ?? 0)));
                    $cat = trim((string)($m['category'] ?? 'General'));
                    $qty = (int)($m['quantity'] ?? 0);
                    $stockText = $qty > 0 ? "✅ **{$qty} in stock**" : "❌ **Out of stock**";
                    
                    $reply .= "• **[{$name}]({$baseUrl}product_show?id={$id})** - **Rs. {$price}** (*{$cat}*) | {$stockText}\n";
                    $count++;
                    if ($count >= 5) break;
                }
                if (count($matched) > 5) {
                    $reply .= "\nPlus **" . (count($matched) - 5) . " more items**! You can explore them all on our catalog:\n";
                } else {
                    $reply .= "\nClick on any product above to view details, pick your size, and add to cart:\n";
                }
                $reply .= "**[Browse All Products]({$baseUrl}allproducts)**";
                return ['response' => $reply];
            }

            // If strict filters found no direct match, return general helpful matches
            if ($askedColor || $maxPrice !== null || $askedType || !empty($userWords)) {
                return ['response' => "I couldn't find an exact item matching all your criteria in stock, but we have fantastic options across all categories!\n\nCheck out our latest collection here:\n**[Browse All Products]({$baseUrl}allproducts)**"];
            }

            return ['response' => "I would be happy to help you find the right product! You can ask me for recommendations by price (e.g. *'under 2000'*), by category (*'men shirts'*, *'women dresses'*), or by color (*'something blue'*). Or explore our full catalog:\n**[Browse All Products]({$baseUrl}allproducts)**"];
        } catch (Exception $e) {
            return ['response' => "I am happy to assist! You can browse all our premium collections directly right here:\n**[Browse All Products]({$baseUrl}allproducts)**"];
        }
    }

    // Sync all products to chatbot FAISS index automatically (fire-and-forget, non-blocking)
    public static function syncProduct($unused = null) {
        // Load all products from DB
        require_once BASE_PATH . '/config/database.php';
        require_once BASE_PATH . '/app/models/Product.php';

        $database = new Database();
        $db = $database->connect();
        $productModel = new Product($db);
        $products = $productModel->getAllProductsForAI();

        if (empty($products)) {
            return;
        }

        $baseUrl = rtrim(CHATBOT_API_URL, '/');
        $syncUrl = $baseUrl . '/sync-products';
        $headers = ['Content-Type: application/json', 'Accept: application/json'];
        if (!empty(CHATBOT_API_TOKEN)) {
            $headers[] = 'Authorization: Bearer ' . CHATBOT_API_TOKEN;
        }

        $ch = curl_init($syncUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['products' => $products]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Fire-and-forget: set a tiny timeout so we don't block.
        // The chatbot server will still receive and process the full request.
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 500);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_exec($ch);

        // Ignore any response — chatbot updates asynchronously in the background
    }

    // Generic POST function
    private function postRequest($url, $data) {
        $parsedUrl = parse_url($url);
        if (empty($parsedUrl['scheme']) || empty($parsedUrl['host'])) {
            return ['error' => 'Invalid chatbot endpoint'];
        }
        if (!in_array($parsedUrl['scheme'], ['http', 'https'], true)) {
            return ['error' => 'Unsupported chatbot endpoint scheme'];
        }

        $headers = ['Content-Type: application/json', 'Accept: application/json'];
        if (!empty($this->apiToken)) {
            $headers[] = 'Authorization: Bearer ' . $this->apiToken;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if(curl_errno($ch)){
            $error = curl_error($ch);

            return ['error' => $error];
        }


        if ($httpCode < 200 || $httpCode >= 300) {
            return ['error' => 'Chatbot endpoint returned HTTP ' . $httpCode];
        }

        if ($response === false || $response === null) {
            return ['error' => 'Empty chatbot response'];
        }

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'Unable to parse chatbot response'];
        }
        if (!is_array($decoded)) {
            return ['error' => 'Unexpected chatbot response format'];
        }

        return $decoded;
    }
}
?>