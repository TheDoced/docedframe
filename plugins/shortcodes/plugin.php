<?php

/**
 * Plugin Name: DocedFrame Shortcodes
 * Description: Kapsamlı kısa kod sistemi - 30+ shortcode
 * Version: 2.0
 * Author: DocedFrame
 */

namespace Plugin\Shortcodes;

class Shortcodes
{
    private static $shortcodes = [];
    
    public static function activate()
    {
        self::addToActivePlugins();
    }
    
    public static function deactivate()
    {
        self::removeFromActivePlugins();
    }
    
    public static function boot()
    {
        self::registerAllShortcodes();
        self::hookIntoPostContent();
    }
    
    private static function addToActivePlugins()
    {
        $active = get_option('active_plugins', '');
        $plugins = explode(',', $active);
        if (!in_array('shortcodes', $plugins)) {
            $plugins[] = 'shortcodes';
            set_option('active_plugins', implode(',', array_filter($plugins)));
        }
    }
    
    private static function removeFromActivePlugins()
    {
        $active = get_option('active_plugins', '');
        $plugins = explode(',', $active);
        $key = array_search('shortcodes', $plugins);
        if ($key !== false) {
            unset($plugins[$key]);
            set_option('active_plugins', implode(',', array_filter($plugins)));
        }
    }
    
    private static function registerAllShortcodes()
    {
        // Temel Shortcode'lar
        self::add('year', function() { return date('Y'); });
        self::add('site_name', function() { return get_option('site_name', 'DocedFrame'); });
        self::add('site_url', function() { return get_option('site_url', 'http://docedframe.td'); });
        
        // Buton Shortcode
        self::add('button', function($atts) {
            $url = $atts['url'] ?? '#';
            $text = $atts['text'] ?? 'Buton';
            $color = $atts['color'] ?? '#0073aa';
            return '<a href="' . htmlspecialchars($url) . '" style="background:' . $color . ';color:#fff;padding:10px 20px;text-decoration:none;border-radius:4px;display:inline-block;">' . htmlspecialchars($text) . '</a>';
        });
        
        // Alert Shortcode'lar
        self::add('alert', function($atts) {
            $type = $atts['type'] ?? 'info';
            $message = $atts['message'] ?? '';
            $colors = ['success' => '#d4edda', 'error' => '#f8d7da', 'warning' => '#fff3cd', 'info' => '#d1ecf1'];
            $color = $colors[$type] ?? '#d1ecf1';
            return '<div style="background:' . $color . ';padding:15px;border-radius:4px;margin:10px 0;border:1px solid #ddd;">' . htmlspecialchars($message) . '</div>';
        });
        
        self::add('success', function($atts, $content = null) {
            return '<div style="background:#d4edda;padding:15px;border-radius:4px;margin:10px 0;border:1px solid #c3e6cb;color:#155724;">' . ($content ?: '') . '</div>';
        });
        
        self::add('error', function($atts, $content = null) {
            return '<div style="background:#f8d7da;padding:15px;border-radius:4px;margin:10px 0;border:1px solid #f5c6cb;color:#721c24;">' . ($content ?: '') . '</div>';
        });
        
        self::add('warning', function($atts, $content = null) {
            return '<div style="background:#fff3cd;padding:15px;border-radius:4px;margin:10px 0;border:1px solid #ffeeba;color:#856404;">' . ($content ?: '') . '</div>';
        });
        
        self::add('info', function($atts, $content = null) {
            return '<div style="background:#d1ecf1;padding:15px;border-radius:4px;margin:10px 0;border:1px solid #bee5eb;color:#0c5460;">' . ($content ?: '') . '</div>';
        });
        
        // Tarih Shortcode
        self::add('current_date', function($atts) {
            $format = $atts['format'] ?? 'd.m.Y H:i:s';
            return date($format);
        });
        
        // Breadcrumb Shortcode
        self::add('breadcrumb', function($atts) {
            $separator = $atts['separator'] ?? '/';
            $home = $atts['home'] ?? 'Ana Sayfa';
            $currentUrl = trim($_SERVER['REQUEST_URI'], '/');
            $html = '<div style="margin:10px 0;"><a href="/">' . htmlspecialchars($home) . '</a>';
            if (!empty($currentUrl)) {
                $html .= ' ' . $separator . ' <span>' . htmlspecialchars($currentUrl) . '</span>';
            }
            $html .= '</div>';
            return $html;
        });
        
        // Posts Shortcode
        self::add('posts', function($atts) {
            $limit = isset($atts['limit']) ? (int)$atts['limit'] : 5;
            $type = $atts['type'] ?? 'post';
            
            try {
                $pdo = \Core\Database\Connection::getInstance()->getPdo();
                $stmt = $pdo->prepare("SELECT * FROM posts WHERE type = :type AND status = 'publish' ORDER BY created_at DESC LIMIT :limit");
                $stmt->bindValue(':type', $type);
                $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
                $stmt->execute();
                $posts = $stmt->fetchAll();
            } catch (\Exception $e) {
                return '<p>Veritabanı hatası</p>';
            }
            
            if (empty($posts)) {
                return '<p>Henüz yazı bulunmuyor.</p>';
            }
            
            $html = '<div class="sc-posts">';
            foreach ($posts as $post) {
                $html .= '<div style="margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #ddd;">';
                $html .= '<h3><a href="/yazi/' . $post['slug'] . '">' . htmlspecialchars($post['title']) . '</a></h3>';
                $html .= '<small>' . $post['created_at'] . '</small>';
                $html .= '<p>' . htmlspecialchars(substr(strip_tags($post['content']), 0, 150)) . '...</p>';
                $html .= '</div>';
            }
            $html .= '</div>';
            return $html;
        });
        
        // Gallery Shortcode
        self::add('gallery', function($atts) {
            $ids = $atts['ids'] ?? '';
            $columns = isset($atts['columns']) ? (int)$atts['columns'] : 3;
            
            if (empty($ids)) {
                return '<p>Galeri için resim ID\'leri gerekli.</p>';
            }
            
            $idsArray = explode(',', $ids);
            $colWidth = 100 / $columns;
            
            $html = '<div style="display:flex;flex-wrap:wrap;">';
            foreach ($idsArray as $id) {
                $html .= '<div style="width:' . $colWidth . '%;padding:5px;box-sizing:border-box;">';
                $html .= '<img src="/uploads/placeholder.jpg" style="width:100%;height:auto;background:#f0f0f0;padding:20px;text-align:center;box-sizing:border-box;" alt="Galeri Resmi">';
                $html .= '</div>';
            }
            $html .= '</div><div style="clear:both;"></div>';
            return $html;
        });
        
        // Code Shortcode
        self::add('code', function($atts, $content = null) {
            $language = $atts['language'] ?? 'php';
            $code = $content ?: '';
            return '<pre style="background:#f5f5f5;padding:15px;border-radius:4px;overflow-x:auto;"><code class="language-' . $language . '">' . htmlspecialchars($code) . '</code></pre>';
        });
        
        // Highlight Shortcode
        self::add('highlight', function($atts, $content = null) {
            $color = $atts['color'] ?? '#ffff00';
            return '<mark style="background:' . $color . ';">' . ($content ?: '') . '</mark>';
        });
        
        // Tooltip Shortcode
        self::add('tooltip', function($atts, $content = null) {
            $text = $atts['text'] ?? 'Açıklama';
            return '<span style="border-bottom:1px dotted #999;cursor:help;" title="' . htmlspecialchars($text) . '">' . ($content ?: 'Hover yap') . '</span>';
        });
        
        // Tabs Shortcode
        self::add('tabs', function($atts, $content = null) {
            return '<div class="sc-tabs" style="border:1px solid #ddd;">' . ($content ?: '') . '</div>';
        });
        
        self::add('tab', function($atts, $content = null) {
            $title = $atts['title'] ?? 'Tab';
            return '<div class="sc-tab" data-title="' . htmlspecialchars($title) . '" style="padding:15px;border-top:1px solid #ddd;">' . ($content ?: '') . '</div>';
        });
        
        // Accordion Shortcode
        self::add('accordion', function($atts, $content = null) {
            return '<div class="sc-accordion">' . ($content ?: '') . '</div>';
        });
        
        self::add('accordion_item', function($atts, $content = null) {
            $title = $atts['title'] ?? 'Başlık';
            $id = 'accordion-' . uniqid();
            return '<div class="sc-accordion-item" style="margin-bottom:10px;border:1px solid #ddd;"><div class="sc-accordion-title" style="padding:10px;background:#f5f5f5;cursor:pointer;font-weight:bold;">' . htmlspecialchars($title) . '</div><div class="sc-accordion-content" style="padding:10px;display:none;">' . ($content ?: '') . '</div></div>';
        });
        
        // Iframe Shortcode
        self::add('iframe', function($atts) {
            $src = $atts['src'] ?? '';
            $width = $atts['width'] ?? '100%';
            $height = $atts['height'] ?? '400';
            if (empty($src)) return '<p>Iframe kaynağı gerekli.</p>';
            return '<iframe src="' . htmlspecialchars($src) . '" width="' . $width . '" height="' . $height . '" frameborder="0" allowfullscreen></iframe>';
        });
        
        // Countdown Shortcode
        self::add('countdown', function($atts) {
            $date = $atts['date'] ?? date('Y-m-d', strtotime('+1 month'));
            $format = $atts['format'] ?? 'days';
            $target = strtotime($date);
            $now = time();
            $diff = $target - $now;
            $days = floor($diff / (60 * 60 * 24));
            if ($format == 'days') return max(0, $days);
            if ($format == 'hours') return max(0, floor($diff / 3600));
            if ($format == 'minutes') return max(0, floor($diff / 60));
            return max(0, $days);
        });
        
        // User Info Shortcode
        self::add('user_info', function($atts) {
            $field = $atts['field'] ?? 'display_name';
            if (!isset($_SESSION['user_id'])) {
                return '<span>Ziyaretçi</span>';
            }
            $fields = ['display_name' => $_SESSION['user_name'] ?? '', 'email' => $_SESSION['user_email'] ?? ''];
            return $fields[$field] ?? '';
        });
        
        // Login Form Shortcode
        self::add('login_form', function() {
            if (isset($_SESSION['user_id'])) {
                return '<div style="background:#d4edda;padding:15px;border-radius:4px;">Zaten giriş yaptınız. <a href="/df-admin/logout">Çıkış yap</a></div>';
            }
            return '<div style="border:1px solid #ddd;padding:20px;border-radius:4px;">
                <form method="POST" action="/df-admin/login">
                    <div><label>E-posta:</label><br><input type="email" name="email" required style="width:100%;padding:8px;"></div>
                    <div><label>Şifre:</label><br><input type="password" name="password" required style="width:100%;padding:8px;"></div>
                    <div><button type="submit" style="margin-top:10px;padding:10px 20px;">Giriş Yap</button></div>
                </form>
            </div>';
        });
        
        // Register Form Shortcode
        self::add('register_form', function() {
            if (isset($_SESSION['user_id'])) {
                return '<div style="background:#d4edda;padding:15px;border-radius:4px;">Zaten üye oldunuz.</div>';
            }
            return '<div style="border:1px solid #ddd;padding:20px;border-radius:4px;">
                <form method="POST" action="">
                    <div><label>Ad Soyad:</label><br><input type="text" name="display_name" required style="width:100%;padding:8px;"></div>
                    <div><label>E-posta:</label><br><input type="email" name="email" required style="width:100%;padding:8px;"></div>
                    <div><label>Şifre:</label><br><input type="password" name="password" required style="width:100%;padding:8px;"></div>
                    <div><button type="submit" style="margin-top:10px;padding:10px 20px;">Kayıt Ol</button></div>
                </form>
            </div>';
        });
        
        // Logout URL Shortcode
        self::add('logout_url', function() {
            return '/df-admin/logout';
        });
        
        // Social Links Shortcode
        self::add('social_links', function($atts) {
            $html = '<div style="display:flex;gap:15px;">';
            if (isset($atts['facebook'])) $html .= '<a href="' . $atts['facebook'] . '" target="_blank">📘 Facebook</a>';
            if (isset($atts['twitter'])) $html .= '<a href="' . $atts['twitter'] . '" target="_blank">🐦 Twitter</a>';
            if (isset($atts['instagram'])) $html .= '<a href="' . $atts['instagram'] . '" target="_blank">📷 Instagram</a>';
            if (isset($atts['linkedin'])) $html .= '<a href="' . $atts['linkedin'] . '" target="_blank">🔗 LinkedIn</a>';
            $html .= '</div>';
            return $html;
        });
        
        // Random Text Shortcode
        self::add('random_text', function($atts) {
            $list = $atts['list'] ?? 'Metin1,Metin2,Metin3';
            $items = explode(',', $list);
            return trim($items[array_rand($items)]);
        });
        
        // Facebook Like Shortcode
        self::add('facebook_like', function() {
            return '<div style="background:#1877f2;color:#fff;padding:5px 10px;border-radius:4px;display:inline-block;">👍 Beğen</div>';
        });
        
        // Twitter Share Shortcode
        self::add('twitter_share', function($atts) {
            $text = $atts['text'] ?? 'Paylaş';
            $url = $atts['url'] ?? $_SERVER['REQUEST_URI'];
            return '<a href="https://twitter.com/intent/tweet?text=' . urlencode($text) . '&url=' . urlencode($url) . '" target="_blank" style="background:#1da1f2;color:#fff;padding:5px 10px;border-radius:4px;display:inline-block;text-decoration:none;">🐦 ' . htmlspecialchars($text) . '</a>';
        });
        
        // Shortcode Usage (dokümantasyon)
        self::add('shortcode_usage', function($atts) {
            $name = $atts['name'] ?? 'button';
            $usages = [
                'button' => '[button url="#" text="Buton" color="#0073aa"]',
                'alert' => '[alert type="success" message="Mesaj"]',
                'year' => '[year]',
                'site_name' => '[site_name]',
                'current_date' => '[current_date format="d.m.Y"]'
            ];
            return '<code>' . ($usages[$name] ?? 'Shortcode bulunamadı') . '</code>';
        });
    }
    
    private static function add($tag, $callback)
    {
        self::$shortcodes[$tag] = $callback;
    }
    
    private static function parse($content)
    {
        if (empty(self::$shortcodes)) {
            return $content;
        }
        
        foreach (self::$shortcodes as $tag => $callback) {
            // Kısa kodları ata
            $pattern = '/\[' . preg_quote($tag, '/') . '(.*?)\]/';
            $content = preg_replace_callback($pattern, function($matches) use ($callback) {
                $attrs = [];
                if (!empty($matches[1])) {
                    preg_match_all('/(\w+)=["\']([^"\']+)["\']/', $matches[1], $attrMatches);
                    if (!empty($attrMatches[1])) {
                        foreach ($attrMatches[1] as $i => $key) {
                            $attrs[$key] = $attrMatches[2][$i];
                        }
                    }
                }
                return call_user_func($callback, $attrs);
            }, $content);
            
            // Açılış-kapanış etiketli shortcode'lar
            $patternClosing = '/\[' . preg_quote($tag, '/') . '(.*?)\](.*?)\[\/' . preg_quote($tag, '/') . '\]/s';
            $content = preg_replace_callback($patternClosing, function($matches) use ($callback) {
                $attrs = [];
                if (!empty($matches[1])) {
                    preg_match_all('/(\w+)=["\']([^"\']+)["\']/', $matches[1], $attrMatches);
                    if (!empty($attrMatches[1])) {
                        foreach ($attrMatches[1] as $i => $key) {
                            $attrs[$key] = $attrMatches[2][$i];
                        }
                    }
                }
                $content = $matches[2] ?? '';
                return call_user_func($callback, $attrs, $content);
            }, $content);
        }
        return $content;
    }
    
    private static function hookIntoPostContent()
    {
        add_action('wp_head', function() {
            echo '<style>
                .sc-tabs { border: 1px solid #ddd; }
                .sc-tab { padding: 15px; border-top: 1px solid #ddd; }
                .sc-accordion-item { margin-bottom: 10px; border: 1px solid #ddd; }
                .sc-accordion-title { padding: 10px; background: #f5f5f5; cursor: pointer; font-weight: bold; }
                .sc-accordion-content { padding: 10px; display: none; }
                .sc-accordion-item.active .sc-accordion-content { display: block; }
            </style>';
        });
        
        add_action('wp_footer', function() {
            echo '<script>
                document.querySelectorAll(".sc-accordion-title").forEach(function(title) {
                    title.addEventListener("click", function() {
                        var item = this.closest(".sc-accordion-item");
                        item.classList.toggle("active");
                    });
                });
            </script>';
        });
        
        ob_start(function($buffer) {
            if (strpos($buffer, '[') !== false && strpos($buffer, ']') !== false) {
                $buffer = self::parse($buffer);
            }
            return $buffer;
        });
    }
}