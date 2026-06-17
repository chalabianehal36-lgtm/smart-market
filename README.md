# 🛒 Smart Market — Plateforme E-Commerce

> Projet de fin d'études en Informatique — Application web e-commerce complète

🌐 **Site en ligne : [smartmaket.free.nf](https://smartmaket.free.nf)**

[![PHP](https://img.shields.io/badge/PHP-8.0-blue)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange)](https://mysql.com)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow)](https://developer.mozilla.org/fr/docs/Web/JavaScript)

---

## ✨ Fonctionnalités

| Fonctionnalité | Description |
|---|---|
| 🔐 Authentification | Inscription, connexion, sessions sécurisées |
| 🛍️ Catalogue produits | Affichage, recherche et filtrage par catégorie |
| 🛒 Panier d'achat | Ajout, modification, suppression d'articles |
| 💳 Paiement multi-étapes | Panier → Livraison → Paiement |
| 👤 Profil utilisateur | Modification des informations et mot de passe |
| 🌍 Multi-langues | Français, Anglais, Arabe (RTL) |
| 🌙 Mode sombre | Thème clair/sombre + personnalisation des couleurs |
| 📱 Responsive | Compatible mobile, tablette et desktop |

---

## 🛠️ Technologies utilisées

**Frontend**
- HTML5, CSS3 (glassmorphism, animations)
- JavaScript Vanilla (ES6+)
- Font Awesome 6, Google Fonts

**Backend**
- PHP 8 (API REST)
- MySQL 8 (transactions, prepared statements)

**Sécurité**
- `password_hash()` / `password_verify()` pour les mots de passe
- Sessions PHP sécurisées (`session_regenerate_id`)
- Requêtes préparées (protection contre SQL injection)
- Validation côté serveur

---

## 📁 Structure du projet

```
smart-market/
├── index.php              # Page d'accueil
├── products.html          # Catalogue produits
├── product.html           # Détail produit
├── cart.html              # Panier
├── payment.html           # Paiement
├── profile.html           # Profil utilisateur
├── login.html         # Connexion / Inscription
│
├── login.php              # API — Authentification
├── signup.php             # API — Inscription
├── getProducts.php        # API — Liste des produits
├── getProduct.php         # API — Détail produit
├── placeOrder.php         # API — Passer une commande
├── update_user.php        # API — Modifier le profil
├── update_password.php    # API — Modifier le mot de passe
├── get_user.php           # API — Données utilisateur
├── select.php             # API — Filtrage par catégorie
│
└── db.php                 # Configuration base de données
```

---

## 🗄️ Schéma de la base de données

```sql
users         (id, nom, prenom, email, password, phone, address)
products      (id, name, description, price, image, colors, stock, category_id)
categories    (id, name)
orders        (id, user_id, name, phone, address, total, status, created_at)
order_items   (id, order_id, product_id, quantity, price)
payments      (id, order_id, amount, status, payment_method, created_at)
```

---

## ⚙️ Installation locale

```bash
# 1. Cloner le dépôt
git clone https://github.com/chalabianehal36-lgtm/smart-market.git
cd smart-market

# 2. Configurer la base de données
cp db.php db.local.php
# Modifier db.local.php avec vos identifiants

# 3. Importer le schéma SQL
mysql -u root -p votre_base < schema.sql

# 4. Lancer un serveur local
php -S localhost:8000
```

---

## 👩‍💻 Auteur

**Nehal Chalabia** — Étudiante en Informatique  

📧 Email: chalabianehal36@gmail.com 

🌐 [Smart Market](https://smartmaket.free.nf)  

🌐 GitHub: https://github.com/chalabianehal36-lgtm

🚀 Project: https://github.com/chalabianehal36-lgtm/Smartmarket
---

© 2026 Smart Market | Projet Informatique
