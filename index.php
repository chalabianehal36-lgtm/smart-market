<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after {
      margin: 0; padding: 0; box-sizing: border-box;
    }
    :root {
      --c1: #3b82f6;
      --c2: #10b981;
      --bg: #f0f9ff;
      --bg2: #e0f2fe;
      --surface: rgba(255,255,255,0.7);
      --surface2: rgba(255,255,255,0.4);
      --text: #0f172a;
      --text2: #475569;
      --border: rgba(255,255,255,0.5);
      --shadow: 0 8px 32px rgba(59,130,246,0.12);
      --radius: 20px;
    }
    body.dark {
      --bg: #0a0f1e;
      --bg2: #0d1526;
      --surface: rgba(15,23,42,0.85);
      --surface2: rgba(30,41,59,0.7);
      --text: #f1f5f9;
      --text2: #94a3b8;
      --border: rgba(255,255,255,0.08);
      --shadow: 0 8px 32px rgba(0,0,0,0.4);
    }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, var(--bg2), var(--bg));
      color: var(--text);
      min-height: 100vh;
      transition: background 0.4s, color 0.4s;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      background: var(--surface);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 32px;
      height: 64px;
      position: sticky;
      top: 0;
      z-index: 1000;
      transition: background 0.4s;
    }
    .logo {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 22px;
      font-weight: 700;
      background: linear-gradient(135deg, var(--c1), var(--c2));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      flex-shrink: 0;
    }
    .nav-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .search-box {
      position: relative;
      display: flex;
      align-items: center;
    }
    .search-box input {
      width: 200px;
      padding: 8px 36px 8px 14px;
      border-radius: 50px;
      border: 1.5px solid var(--border);
      background: var(--surface2);
      backdrop-filter: blur(8px);
      font-size: 13px;
      color: var(--text);
      font-family: 'Inter', sans-serif;
      transition: 0.3s;
      outline: none;
    }
    .search-box input::placeholder { color: var(--text2); }
    .search-box input:focus {
      width: 240px;
      border-color: var(--c1);
      box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
    }
    .search-box .search-icon {
      position: absolute;
      right: 11px;
      font-size: 14px;
      opacity: 0.5;
      pointer-events: none;
    }
    .nav-btn {
      background: var(--surface2);
      border: 1.5px solid var(--border);
      padding: 7px 14px;
      border-radius: 50px;
      cursor: pointer;
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      font-weight: 500;
      color: var(--text);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: 0.2s;
      white-space: nowrap;
      flex-shrink: 0;
    }
    .nav-btn:hover {
      background: var(--surface);
      border-color: var(--c1);
      color: var(--c1);
    }
    .cart-btn {
      background: linear-gradient(135deg, var(--c1), var(--c2));
      color: white !important;
      border-color: transparent !important;
      font-weight: 600;
    }
    .cart-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(59,130,246,0.35);
      color: white !important;
    }
    select.nav-btn {
      appearance: none;
      padding-right: 18px;
      cursor: pointer;
    }

    /* زر accueil النشط في الموبايل */
    .nav-btn.active-page {
      background: linear-gradient(135deg, var(--c1), var(--c2));
      color: white !important;
      border-color: transparent !important;
      font-weight: 600;
    }
    .nav-btn.active-page:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(59,130,246,0.35);
      color: white !important;
    }

    /* Hamburger */
    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      padding: 6px;
      border-radius: 8px;
      background: var(--surface2);
      border: 1.5px solid var(--border);
    }
    .hamburger span {
      display: block; width: 20px; height: 2px;
      background: var(--text); border-radius: 2px;
      transition: 0.3s;
    }
    .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    .hamburger.open span:nth-child(2) { opacity: 0; }
    .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* Mobile menu */
    .mobile-menu {
      display: none;
      position: fixed;
      top: 64px;
      left: 0; right: 0;
      background: var(--surface);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
      padding: 16px;
      z-index: 999;
      flex-direction: column;
      gap: 10px;
    }
    .mobile-menu.open { display: flex; }
    .mobile-menu .search-box { width: 100%; }
    .mobile-menu .search-box input { width: 100% !important; }
    .mobile-menu .nav-btn { justify-content: center; text-align: center; }
    .mobile-menu-row {
      display: flex;
      gap: 8px;
    }
    .mobile-menu-row .nav-btn { flex: 1; justify-content: center; }

    /* ===== HERO ===== */
    .hero {
      background: linear-gradient(135deg, var(--c1) 0%, #6366f1 50%, var(--c2) 100%);
      padding: 80px 32px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 420px;
      position: relative;
      overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute;
      width: 600px; height: 600px;
      border-radius: 50%;
      background: rgba(255,255,255,0.07);
      top: -200px; right: -150px;
      pointer-events: none;
    }
    .hero::after {
      content: '';
      position: absolute;
      width: 400px; height: 400px;
      border-radius: 50%;
      background: rgba(255,255,255,0.05);
      bottom: -150px; left: -100px;
      pointer-events: none;
    }
    .hero-content {
      text-align: center;
      color: white;
      position: relative;
      z-index: 1;
      max-width: 600px;
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.25);
      padding: 6px 16px;
      border-radius: 50px;
      font-size: 13px;
      font-weight: 500;
      margin-bottom: 20px;
    }
    .hero h1 {
      font-family: 'Space Grotesk', sans-serif;
      font-size: clamp(30px, 5vw, 52px);
      font-weight: 700;
      line-height: 1.15;
      margin-bottom: 16px;
      text-shadow: 0 2px 20px rgba(0,0,0,0.15);
    }
    .hero p {
      font-size: clamp(15px, 2vw, 18px);
      opacity: 0.88;
      margin-bottom: 32px;
      line-height: 1.6;
    }
    .hero-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 14px 32px;
      border: none;
      border-radius: 50px;
      background: white;
      color: var(--c1);
      font-weight: 700;
      font-size: 15px;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: 0.3s;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .hero-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 18px 40px rgba(0,0,0,0.25);
    }

    /* ===== SECTIONS ===== */
    .section-title {
      font-family: 'Space Grotesk', sans-serif;
      text-align: center;
      margin: 56px 0 28px;
      font-size: clamp(22px, 3.5vw, 30px);
      font-weight: 700;
      color: var(--text);
    }
    .section-title span {
      background: linear-gradient(135deg, var(--c1), var(--c2));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* ===== CATEGORIES ===== */
    .categories {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      padding: 0 32px 48px;
    }
    .category-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      backdrop-filter: blur(12px);
      border-radius: var(--radius);
      padding: 32px 16px;
      text-align: center;
      cursor: pointer;
      transition: 0.3s;
      box-shadow: var(--shadow);
      position: relative;
      overflow: hidden;
    }
    .category-card::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, var(--c1), var(--c2));
      opacity: 0;
      transition: 0.3s;
      border-radius: var(--radius);
    }
    .category-card:hover::after { opacity: 0.06; }
    .category-card:hover {
      transform: translateY(-6px);
      border-color: var(--c1);
      box-shadow: 0 20px 50px rgba(59,130,246,0.18);
    }
    .category-icon {
      font-size: 40px;
      display: block;
      margin-bottom: 10px;
    }
    .cat-text {
      font-size: 15px;
      font-weight: 600;
      color: var(--text);
    }

    /* ===== PRODUCTS ===== */
    .products {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      padding: 0 32px 60px;
    }
    .product-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      backdrop-filter: blur(12px);
      border-radius: var(--radius);
      overflow: hidden;
      cursor: pointer;
      transition: 0.3s;
      box-shadow: var(--shadow);
      display: flex;
      flex-direction: column;
    }
    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 24px 56px rgba(59,130,246,0.2);
      border-color: rgba(59,130,246,0.35);
    }
    .product-img-wrap {
      position: relative;
      overflow: hidden;
    }
    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: 0.4s;
      display: block;
    }
    .product-card:hover img { transform: scale(1.06); }
    .badge {
      position: absolute;
      top: 12px; left: 12px;
      background: linear-gradient(135deg, #ef4444, #f97316);
      color: white;
      padding: 4px 10px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 11px;
      letter-spacing: 0.5px;
    }
    .fav {
      position: absolute;
      top: 10px; right: 10px;
      width: 34px; height: 34px;
      border-radius: 50%;
      background: rgba(255,255,255,0.85);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
      backdrop-filter: blur(4px);
      box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    }
    .fav:hover { transform: scale(1.15); }
    .fav.active { background: #fef2f2; }
    .product-info {
      padding: 16px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    .product-info h4 {
      font-size: 15px;
      font-weight: 600;
      color: var(--text);
      line-height: 1.3;
    }
    .product-info .price {
      font-size: 16px;
      font-weight: 700;
      color: var(--c2);
    }
    .product-info button {
      margin-top: auto;
      padding: 10px 16px;
      border: none;
      border-radius: 50px;
      background: linear-gradient(135deg, var(--c1), var(--c2));
      color: white;
      font-weight: 600;
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: 0.25s;
    }
    .product-info button:hover {
      opacity: 0.9;
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(59,130,246,0.35);
    }

    /* ===== FOOTER ===== */
    .footer {
      background: #0f172a;
      color: rgba(255,255,255,0.55);
      text-align: center;
      padding: 28px 20px;
      font-size: 13px;
      margin-top: 10px;
    }
    .footer strong {
      color: rgba(255,255,255,0.85);
      font-weight: 600;
    }

    /* ===== AVATAR / DROPDOWN ===== */
    .user-menu { position: relative; }
    .avatar-circle {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--c1), var(--c2));
      color: white;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: 14px;
      cursor: pointer;
      border: 2px solid rgba(255,255,255,0.5);
      flex-shrink: 0;
    }
    .dropdown {
      position: absolute;
      top: 46px; right: 0;
      background: var(--surface);
      backdrop-filter: blur(20px);
      border: 1.5px solid var(--border);
      padding: 12px;
      border-radius: 16px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.2);
      min-width: 160px;
      z-index: 9999;
    }
    /* في الموبايل تظهر الـ dropdown للأعلى لأن القائمة في الأسفل */
    .mobile-menu .dropdown {
      top: auto;
      bottom: 46px;
      right: 0;
      left: auto;
    }
    .dropdown p {
      padding: 4px 8px 8px;
      font-weight: 600;
      font-size: 14px;
      color: var(--text);
      border-bottom: 1px solid var(--border);
      margin-bottom: 6px;
    }
    .dropdown button {
      width: 100%;
      padding: 9px 12px;
      border: none;
      border-radius: 10px;
      background: transparent;
      color: var(--text);
      cursor: pointer;
      text-align: left;
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      font-weight: 500;
      transition: 0.2s;
      display: flex; align-items: center; gap: 8px;
    }
    .dropdown button:hover {
      background: rgba(59,130,246,0.1);
      color: var(--c1);
    }
    .hidden { display: none !important; }

    /* ===== RESPONSIVE ===== */

    /* Desktop */
    @media (min-width: 769px) {
      .hamburger { display: none !important; }
      .mobile-menu { display: none !important; }
      .products { grid-template-columns: repeat(4, 1fr); }
      .categories { grid-template-columns: repeat(4, 1fr); }
    }

    /* Tablet */
    @media (max-width: 1024px) {
      .products, .categories { grid-template-columns: repeat(2, 1fr); }
    }

    /* Mobile */
    @media (max-width: 768px) {
      .navbar { padding: 0 16px; }

      .navbar .search-box,
      .navbar #navHome,
      .navbar #navProducts,
      .navbar #authArea,
      .navbar #langSwitcher,
      .navbar .dark-toggle { display: none !important; }

      .navbar .cart-btn { display: flex !important; }

      .hamburger { display: flex !important; }

      .mobile-menu {
        display: none;
        position: fixed;
        top: 64px;
        left: 0; right: 0;
        background: var(--surface);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border);
        padding: 16px;
        z-index: 9999;
        flex-direction: column;
        gap: 12px;
        max-height: calc(100vh - 64px);
        overflow-y: auto;
      }
      .mobile-menu.open { display: flex; }

      .mobile-menu .search-box { display: flex !important; width: 100%; }
      .mobile-menu .search-box input { width: 100% !important; }

      .mobile-menu .nav-btn,
      .mobile-menu button,
      .mobile-menu select {
        width: 100%;
        justify-content: center;
      }

      .mobile-menu-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        width: 100%;
      }
      .mobile-menu-row .nav-btn,
      .mobile-menu-row button,
      .mobile-menu-row select {
        width: 100%;
        justify-content: center;
        text-align: center;
      }

      /* authAreaMobile: تأخذ العرض الكامل وتمركز المحتوى */
      #authAreaMobile {
        width: 100%;
        display: flex;
        justify-content: center;
      }
      #authAreaMobile .nav-btn {
        width: 100%;
        justify-content: center;
      }
      #authAreaMobile .user-menu {
        width: 100%;
        position: relative;
      }
      #authAreaMobile .avatar-circle {
        width: 100%;
        border-radius: 50px;
        height: 38px;
        font-size: 14px;
        gap: 8px;
        justify-content: center;
        border: 1.5px solid var(--border);
      }
      /* Dropdown في الموبايل يفتح للأعلى */
      #authAreaMobile .dropdown {
        position: absolute;
        bottom: 46px;
        top: auto;
        right: 0;
        left: 0;
        min-width: unset;
        width: 100%;
      }

      .hero { padding: 56px 20px; min-height: 340px; }

      .products, .categories {
        grid-template-columns: repeat(2, 1fr);
        padding-left: 16px;
        padding-right: 16px;
        gap: 14px;
      }
      .category-card { padding: 24px 12px; }
      .category-icon { font-size: 32px; }
    }

    /* Small phones */
    @media (max-width: 480px) {
      .products, .categories { grid-template-columns: 1fr; }
      .hero h1 { font-size: 26px; }
      .hero p { font-size: 15px; }
    }
  </style>
</head>
<body>

<!-- NAVBAR (Desktop) -->
<div class="navbar">
  <div class="logo">Smart Market</div>
  <div class="nav-right">
    <div class="search-box">
      <input type="text" id="searchInput" placeholder="Recherche...">
      <span class="search-icon">🔍</span>
    </div>
    <a href="index.php" class="nav-btn active-page" id="navHome">Accueil</a>
    <a href="products.html" class="nav-btn" id="navProducts">Produits</a>
    <div id="authArea"></div>
    <select id="langSwitcher" class="nav-btn" onchange="changeLanguage()">
      <option value="fr">🇫🇷 FR</option>
      <option value="en">🇬🇧 EN</option>
      <option value="ar">🇩🇿 AR</option>
    </select>
    <button onclick="toggleDarkMode()" class="nav-btn dark-toggle">🌙</button>
    <div class="cart nav-btn cart-btn" onclick="window.location.href='cart.html'">🛒 <span id="cartCount">0</span></div>
    <div class="hamburger" id="hamburger" onclick="toggleMobileMenu()">
      <span></span><span></span><span></span>
    </div>
  </div>
</div>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">

  <!-- البحث -->
  <div class="search-box">
    <input type="text" id="searchInputMobile" placeholder="Recherche...">
    <span class="search-icon">🔍</span>
  </div>

  <!-- سطر 1: Accueil (نشط) + Produits -->
  <div class="mobile-menu-row">
    <a href="index.php" class="nav-btn active-page" id="navHomeMobile">🏠 Accueil</a>
    <a href="products.html" class="nav-btn" id="navProductsMobile">📦 Produits</a>
  </div>

  <!-- سطر 2: Dark mode + Lang -->
  <div class="mobile-menu-row">
    <button onclick="toggleDarkMode()" class="nav-btn">🌙 Mode</button>
    <select id="langSwitcherMobile" class="nav-btn" onchange="changeLangMobile()">
      <option value="fr">🇫🇷 FR</option>
      <option value="en">🇬🇧 EN</option>
      <option value="ar">🇩🇿 AR</option>
    </select>
  </div>

  <!-- سطر 3: Auth (Connexion أو Avatar) + سلة عادية (بدون تلوين) -->
  <div class="mobile-menu-row">
    <div id="authAreaMobile"></div>
    <div class="nav-btn" onclick="window.location.href='cart.html'" style="justify-content:center;">
      🛒 <span id="cartCountMobile">0</span>
    </div>
  </div>

</div>

<!-- HERO -->
<div class="hero">
  <div class="hero-content">
    <div class="hero-badge">✨ <span>Marketplace Algérienne #1</span></div>
    <h1 id="heroTitle">Bienvenue sur Smart Market</h1>
    <p id="heroDesc">Marketplace intelligente multi-vendeurs</p>
    <button class="hero-btn" id="heroBtn">Explorer les Produits →</button>
  </div>
</div>

<!-- CATEGORIES -->
<h2 class="section-title" id="categoriesTitle">Nos <span>Catégories</span></h2>
<div class="categories">
  <div class="category-card">
    <span class="category-icon">💻</span>
    <span class="cat-text" data-key="electronique">Électronique</span>
  </div>
  <div class="category-card">
    <span class="category-icon">👕</span>
    <span class="cat-text" data-key="mode">Mode</span>
  </div>
  <div class="category-card">
    <span class="category-icon">🏠</span>
    <span class="cat-text" data-key="maison">Maison</span>
  </div>
  <div class="category-card">
    <span class="category-icon">🌿</span>
    <span class="cat-text" data-key="local">Produits Locaux</span>
  </div>
</div>

<!-- PRODUCTS -->
<h2 class="section-title" id="sectionTitle">Produits <span>Populaires</span></h2>
<div class="products">
  <div class="product-card" onclick="goToProduct('1')">
    <div class="product-img-wrap">
      <div class="badge">Nouveau</div>
      <div class="fav" onclick="event.stopPropagation();toggleFav(this)">🤍</div>
      <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8" alt="Laptop">
    </div>
    <div class="product-info">
      <h4 class="product-name" data-key="laptop">Ordinateur Portable</h4>
      <p class="price">120 000 DA</p>
      <button class="add-btn" onclick="event.stopPropagation();addCart('Ordinateur Portable',120000)">Ajouter au panier</button>
    </div>
  </div>
  <div class="product-card" onclick="goToProduct('5')">
    <div class="product-img-wrap">
      <div class="badge">Promo</div>
      <div class="fav" onclick="event.stopPropagation();toggleFav(this)">🤍</div>
      <img src="https://i.pinimg.com/1200x/58/01/02/580102109d76a8aa631cc584069916c4.jpg" alt="Watch">
    </div>
    <div class="product-info">
      <h4 class="product-name" data-key="watch">Smart Watch</h4>
      <p class="price">8 500 DA</p>
      <button class="add-btn" onclick="event.stopPropagation();addCart('Smart Watch',8500)">Ajouter au panier</button>
    </div>
  </div>
  <div class="product-card" onclick="goToProduct('3')">
    <div class="product-img-wrap">
      <div class="fav" onclick="event.stopPropagation();toggleFav(this)">🤍</div>
      <img src="https://i.pinimg.com/originals/4e/a5/c8/4ea5c8c480625906a692bafa65ba7aad.jpg" alt="Casque">
    </div>
    <div class="product-info">
      <h4 class="product-name" data-key="headset">Casque Audio</h4>
      <p class="price">6 700 DA</p>
      <button class="add-btn" onclick="event.stopPropagation();addCart('Casque Audio',6700)">Ajouter au panier</button>
    </div>
  </div>
  <div class="product-card" onclick="goToProduct('4')">
    <div class="product-img-wrap">
      <div class="fav" onclick="event.stopPropagation();toggleFav(this)">🤍</div>
      <img src="https://i.pinimg.com/1200x/26/be/56/26be56634ad9773c9d8f6315cac2cba7.jpg" alt="Phone">
    </div>
    <div class="product-info">
      <h4 class="product-name" data-key="phone">Smartphone</h4>
      <p class="price">15 000 DA</p>
      <button class="add-btn" onclick="event.stopPropagation();addCart('Smartphone',15000)">Ajouter au panier</button>
    </div>
  </div>
</div>

<div class="footer">© 2026 <strong>Smart Market</strong> | Computer Science Project</div>

<script>
const translations = {
  fr: {
    navHome:"Accueil", navProducts:"Produits", navLogin:"Connexion",
    heroTitle:"Bienvenue sur Smart Market", heroDesc:"Marketplace intelligente multi-vendeurs",
    heroBtn:"Explorer les Produits →", sectionTitle:"Produits <span>Populaires</span>",
    categoriesTitle:"Nos <span>Catégories</span>",
    laptop:"Ordinateur Portable", watch:"Montre Intelligente", headset:"Casque Audio", phone:"Smartphone",
    electronique:"Électronique", mode:"Mode", maison:"Maison", local:"Produits Locaux",
    addCart:"Ajouter au panier", searchPlaceholder:"Recherche...",
    profileBtn:"👤 Profil", logoutBtn:"🚪 Déconnexion"
  },
  en: {
    navHome:"Home", navProducts:"Products", navLogin:"Login",
    heroTitle:"Welcome to Smart Market", heroDesc:"Intelligent multi-vendor marketplace",
    heroBtn:"Explore Products →", sectionTitle:"<span>Popular</span> Products",
    categoriesTitle:"Browse <span>Categories</span>",
    laptop:"Laptop", watch:"Smart Watch", headset:"Headphones", phone:"Smartphone",
    electronique:"Electronics", mode:"Fashion", maison:"Home", local:"Local Products",
    addCart:"Add to Cart", searchPlaceholder:"Search...",
    profileBtn:"👤 Profile", logoutBtn:"🚪 Logout"
  },
  ar: {
    navHome:"الرئيسية", navProducts:"المنتجات", navLogin:"تسجيل الدخول",
    heroTitle:"مرحبًا بك في سمارت ماركت", heroDesc:"منصة ذكية متعددة البائعين",
    heroBtn:"← استكشاف المنتجات", sectionTitle:"المنتجات <span>الأكثر شهرة</span>",
    categoriesTitle:"تصفح <span>الفئات</span>",
    laptop:"حاسوب محمول", watch:"ساعة ذكية", headset:"سماعات", phone:"هاتف ذكي",
    electronique:"إلكترونيات", mode:"موضة", maison:"منزل", local:"منتجات محلية",
    addCart:"أضف إلى السلة", searchPlaceholder:"ابحث...",
    profileBtn:"👤 الملف الشخصي", logoutBtn:"🚪 تسجيل الخروج"
  }
};

function toggleMobileMenu() {
  document.getElementById('mobileMenu').classList.toggle('open');
  document.getElementById('hamburger').classList.toggle('open');
}

/* =============================================
   toggleMenu: يعمل لكل الـ dropdown في الصفحة
   نمرر id الـ dropdown المراد فتحه
   ============================================= */
function toggleMenu(dropdownId) {
  // إغلاق أي dropdown آخر مفتوح
  document.querySelectorAll('.dropdown').forEach(d => {
    if (d.id !== dropdownId) d.classList.add('hidden');
  });
  document.getElementById(dropdownId)?.classList.toggle('hidden');
}

function logout() {
  localStorage.removeItem("user");
  window.location.reload();
}

function goProfile() {
  window.location.href = "profile.html";
}

document.addEventListener("click", function(e) {
  // إغلاق كل الـ dropdowns عند الضغط خارجها
  if (!e.target.closest('.user-menu')) {
    document.querySelectorAll('.dropdown').forEach(d => d.classList.add('hidden'));
  }
  // إغلاق القائمة الجوالة
  if (!e.target.closest('.hamburger') && !e.target.closest('.mobile-menu')) {
    document.getElementById('mobileMenu').classList.remove('open');
    document.getElementById('hamburger').classList.remove('open');
  }
});

function applyLanguage(lang) {
  const t = translations[lang];
  document.getElementById("navHome").innerText = t.navHome;
  document.getElementById("navProducts").innerText = t.navProducts;
  const navHomeMob = document.getElementById("navHomeMobile");
  const navProdMob = document.getElementById("navProductsMobile");
  if (navHomeMob) navHomeMob.innerText = "🏠 " + t.navHome;
  if (navProdMob) navProdMob.innerText = "📦 " + t.navProducts;
  document.getElementById("heroTitle").innerText = t.heroTitle;
  document.getElementById("heroDesc").innerText = t.heroDesc;
  document.getElementById("heroBtn").innerHTML = t.heroBtn;
  document.getElementById("sectionTitle").innerHTML = t.sectionTitle;
  document.getElementById("categoriesTitle").innerHTML = t.categoriesTitle;
  document.getElementById("searchInput").placeholder = t.searchPlaceholder;
  const mob = document.getElementById("searchInputMobile");
  if (mob) mob.placeholder = t.searchPlaceholder;
  document.querySelectorAll(".product-name").forEach(el => {
    el.innerText = t[el.dataset.key] || el.innerText;
  });
  document.querySelectorAll(".add-btn").forEach(el => { el.innerText = t.addCart; });
  document.querySelectorAll(".cat-text").forEach(el => { el.innerText = t[el.dataset.key] || el.innerText; });
  document.body.setAttribute("dir", lang === "ar" ? "rtl" : "ltr");
}

function changeLanguage() {
  const lang = document.getElementById("langSwitcher").value;
  const mob = document.getElementById("langSwitcherMobile");
  if (mob) mob.value = lang;
  localStorage.setItem('lang', lang);
  applyLanguage(lang);
  updateAuthUI();
}

function changeLangMobile() {
  const lang = document.getElementById("langSwitcherMobile").value;
  document.getElementById("langSwitcher").value = lang;
  localStorage.setItem('lang', lang);
  applyLanguage(lang);
  updateAuthUI();
}

function toggleFav(el) {
  el.classList.toggle('active');
  el.innerText = el.classList.contains('active') ? '❤️' : '🤍';
  let favs = JSON.parse(localStorage.getItem("favs")) || [];
  let product = el.closest('.product-card').querySelector(".product-name").innerText;
  favs = favs.includes(product) ? favs.filter(p => p !== product) : [...favs, product];
  localStorage.setItem("favs", JSON.stringify(favs));
}

function addCart(name, price) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let existing = cart.find(item => item.name === name);
  if (existing) { existing.quantity += 1; }
  else { cart.push({ name, price, quantity: 1 }); }
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCount();
  showToast(name + " أُضيف إلى السلة 🛒");
}

function showToast(msg) {
  let toast = document.getElementById('toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'toast';
    toast.style.cssText = `
      position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(80px);
      background:linear-gradient(135deg,#3b82f6,#10b981);color:white;
      padding:12px 24px;border-radius:50px;font-size:14px;font-weight:600;
      box-shadow:0 10px 30px rgba(0,0,0,0.2);z-index:9999;
      transition:transform 0.35s cubic-bezier(0.34,1.56,0.64,1);
      font-family:'Inter',sans-serif;white-space:nowrap;
    `;
    document.body.appendChild(toast);
  }
  toast.innerText = msg;
  toast.style.transform = 'translateX(-50%) translateY(0)';
  setTimeout(() => { toast.style.transform = 'translateX(-50%) translateY(80px)'; }, 2800);
}

function updateCartCount() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let total = cart.reduce((s, i) => s + i.quantity, 0);
  document.getElementById('cartCount').innerText = total;
  const mob = document.getElementById('cartCountMobile');
  if (mob) mob.innerText = total;
}

function updateAuthUI() {
  const user = JSON.parse(localStorage.getItem("user"));
  const lang = localStorage.getItem('lang') || 'fr';
  const t = translations[lang];

  // Desktop auth area
  const desktopArea = document.getElementById("authArea");
  if (desktopArea) {
    if (user) {
      let letter = user.name.charAt(0).toUpperCase();
      desktopArea.innerHTML = `
        <div class="user-menu">
          <div class="avatar-circle" onclick="toggleMenu('dropdownDesktop')">${letter}</div>
          <div id="dropdownDesktop" class="dropdown hidden">
            <p>${user.name}</p>
            <button onclick="goProfile()">${t.profileBtn}</button>
            <button onclick="logout()">${t.logoutBtn}</button>
          </div>
        </div>`;
      const avatar = desktopArea.querySelector('.avatar-circle');
      if (avatar) avatar.style.background = localStorage.getItem("avatarTheme") || "linear-gradient(135deg,#3b82f6,#10b981)";
    } else {
      desktopArea.innerHTML = `<a href="login.html" class="nav-btn">${t.navLogin}</a>`;
    }
  }

  // Mobile auth area
  const mobileArea = document.getElementById("authAreaMobile");
  if (mobileArea) {
    if (user) {
      let letter = user.name.charAt(0).toUpperCase();
      // نعرض اسم المستخدم + حرفه مع dropdown يفتح داخل القائمة
      mobileArea.innerHTML = `
        <div class="user-menu" style="width:100%;position:relative;">
          <div class="avatar-circle"
               onclick="toggleMenu('dropdownMobile')"
               style="width:100%;border-radius:50px;height:38px;font-size:14px;gap:8px;">
            ${letter} ${user.name}
          </div>
          <div id="dropdownMobile" class="dropdown hidden">
            <p>${user.name}</p>
            <button onclick="goProfile()">${t.profileBtn}</button>
            <button onclick="logout()">${t.logoutBtn}</button>
          </div>
        </div>`;
      const avatar = mobileArea.querySelector('.avatar-circle');
      if (avatar) avatar.style.background = localStorage.getItem("avatarTheme") || "linear-gradient(135deg,#3b82f6,#10b981)";
    } else {
      mobileArea.innerHTML = `<a href="login.html" class="nav-btn" style="width:100%;justify-content:center;">${t.navLogin}</a>`;
    }
  }
}

function toggleDarkMode() {
  document.body.classList.toggle("dark");
  localStorage.setItem("darkMode", document.body.classList.contains("dark") ? "true" : "false");
}

function goToProduct(id) { window.location.href = "product.html?id=" + id; }

window.addEventListener('DOMContentLoaded', () => {
  const savedC1 = localStorage.getItem('themeC1') || '#3b82f6';
  const savedC2 = localStorage.getItem('themeC2') || '#10b981';
  document.documentElement.style.setProperty('--c1', savedC1);
  document.documentElement.style.setProperty('--c2', savedC2);
  if (localStorage.getItem("darkMode") === "true") document.body.classList.add("dark");
  const lang = localStorage.getItem('lang') || 'fr';
  document.getElementById("langSwitcher").value = lang;
  const mob = document.getElementById("langSwitcherMobile");
  if (mob) mob.value = lang;
  applyLanguage(lang);
  updateCartCount();
  updateAuthUI();

  document.getElementById("heroBtn").onclick = () => { window.location.href = "products.html"; };
  document.querySelectorAll(".category-card").forEach(card => {
    card.addEventListener("click", () => {
      const key = card.querySelector(".cat-text").dataset.key;
      window.location.href = `products.html?category=${key}`;
    });
  });

  function setupSearch(inputId) {
    const inp = document.getElementById(inputId);
    if (inp) {
      inp.addEventListener("keypress", e => {
        if (e.key === "Enter" && inp.value.trim()) {
          window.location.href = "products.html?search=" + encodeURIComponent(inp.value.trim());
        }
      });
    }
  }
  setupSearch("searchInput");
  setupSearch("searchInputMobile");
});
</script>
</body>
</html>
