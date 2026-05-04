	
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_option('site_name', 'DocedFrame'); ?></title>
    
    <!-- Ana CSS -->
    <link rel="stylesheet" href="/themes/default/assets/css/style.css">
    
    <!-- Ana JS -->
    <script src="/themes/default/assets/js/main.js" defer></script>
</head>
<body>

<header class="main-nav" id="mainNav">
    <div class="nav-container">
        <div class="nav-left">
            <a href="<?php echo home_url(); ?>" class="logo-wrapper">
                <div class="logo-icon"><span>D</span></div>
                <span class="logo-text"><?php echo get_option('site_name', 'DocedFrame'); ?></span>
            </a>
           

            <span class="divider"></span>
            
            <ul class="nav-menu" id="navMenu">
                <?php
                try {
                    $menuModel = new \App\Models\Menu();
                    $menu = $menuModel->getByLocation('primary');
                    
                    if ($menu && !empty($menu['items'])):
                        foreach ($menu['items'] as $item):
                            $hasChildren = isset($item['children']) && !empty($item['children']);
                ?>
                <li class="nav-item <?php echo $hasChildren ? 'dropdown' : ''; ?>">
                    <?php if ($hasChildren): ?>
                    <button class="nav-link">
                        <?php echo htmlspecialchars($item['title']); ?>
                        <svg class="chevron-icon" viewBox="0 0 24 24" fill="none">
                            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </button>
                    <ul class="dropdown-menu">
                        <?php foreach ($item['children'] as $child): ?>
                        <li><a href="<?php echo $child['url']; ?>"><?php echo htmlspecialchars($child['title']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <a href="<?php echo $item['url']; ?>" class="nav-link"><?php echo htmlspecialchars($item['title']); ?></a>
                    <?php endif; ?>
                </li>
                <?php 
                        endforeach;
                    endif;
                } catch (Exception $e) {}
                ?>
            </ul>
        </div>

        <?php
        $isLoggedIn = \Core\Auth\Auth::check();
        $userName = '';
        $userEmail = '';
        $userInitial = 'G';
        
        if ($isLoggedIn) {
            $user = \Core\Auth\Auth::user();
            if ($user) {
                $userName = $user['display_name'] ?? '';
                $userEmail = $user['email'] ?? '';
                $userInitial = !empty($userName) ? strtoupper(substr($userName, 0, 1)) : 'G';
            }
        }
        ?>

        <div class="user-actions">
            <?php if ($isLoggedIn): ?>
            <!-- Sepet -->
            <div class="cart-dropdown" id="cartDropdown">
                <button class="cart-btn" id="cartBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span class="cart-count" id="cartCount">0</span>
                </button>
                <div class="cart-menu" id="cartMenu">
                    <div class="cart-header">
                        <h4>Sepetim</h4>
                        <button class="cart-close-btn" id="cartCloseBtn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                        </button>
                    </div>
                    <div class="cart-items" id="cartItems">
                        <div class="cart-empty"><p>Sepetiniz boş</p></div>
                    </div>
                    <div class="cart-footer">
                        <div class="cart-total"><span>Toplam:</span><strong id="cartTotal">$0</strong></div>
                        <button class="cart-checkout" id="cartCheckout">Sepeti Onayla</button>
                    </div>
                </div>
            </div>

            <!-- Hesap Dropdown -->
            <div class="account-dropdown" id="accountDropdown">
                <button class="account-btn" id="accountBtn">
                    <div class="account-avatar" id="accountAvatar"><?php echo $userInitial; ?></div>
                    <span class="account-name" id="accountName"><?php echo htmlspecialchars($userName); ?></span>
                    <svg class="chevron-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </button>
                <div class="account-menu" id="accountMenu">
                    <div class="account-profile">
                        <div class="profile-avatar" id="profileAvatar"><?php echo $userInitial; ?></div>
                        <div class="profile-info">
                            <div class="profile-name" id="profileName"><?php echo htmlspecialchars($userName); ?></div>
                            <div class="profile-email" id="profileEmail"><?php echo htmlspecialchars($userEmail); ?></div>
                        </div>
                    </div>
                    <ul class="account-links">
                        <li><a href="/profil"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Profilim</a></li>
                        <li><a href="/siparisler"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>Siparişlerim</a></li>
                        <li><a href="/sepet"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>Sepetim</a></li>
                    </ul>
                    <div class="account-divider"></div>
                    <ul class="account-links">
                        <li><a href="/df-admin/logout"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Çıkış Yap</a></li>
                    </ul>
                </div>
            </div>
            <?php else: ?>
            <button class="btn-outline" id="signupBtn">Hesap oluştur</button>
            <button class="btn-primary" id="loginBtn">Giriş yap</button>
            <?php endif; ?>
        </div>

        <button class="hamburger" id="hamburgerBtn">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<!-- Sepet Modal -->
<div class="cart-modal" id="cartModal">
    <div class="cart-modal-content">
        <div class="cart-modal-header">
            <h3>Sepete Eklendi</h3>
            <button class="cart-modal-close" id="cartModalClose">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="cart-modal-body">
            <div class="cart-product-info">
                <img id="cartProductImage" src="">
                <div>
                    <h4 id="cartProductName"></h4>
                    <p id="cartProductPrice"></p>
                </div>
            </div>
            <p class="cart-success-message">Ürün sepete başarıyla eklendi!</p>
        </div>
        <div class="cart-modal-footer">
            <button class="btn-continue" id="cartContinueBtn">Alışverişe Devam Et</button>
            <button class="btn-view-cart" id="cartViewBtn">Sepete Git</button>
        </div>
    </div>
</div>

<main class="site-main">