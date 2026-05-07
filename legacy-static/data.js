/* ============================================
   DATA LAYER — Hierarchical Categories + Products
   ============================================ */

const STORAGE_KEYS = {
    categories: 'rilas_categories_v2',
    products: 'rilas_products_v2',
    cart: 'rilas_cart',
    orders: 'rilas_orders'
};

/* ---------- Default Categories (Hierarchical) ---------- */
const DEFAULT_CATEGORIES = [
    {
        id: 'cat-1', name: 'Mobilier de Bureau', icon: '🪑', color: '#6c5ce7',
        subcategories: [
            { id: 'sub-1-1', name: 'Bureaux' },
            { id: 'sub-1-2', name: 'Sièges et Fauteuils' },
            { id: 'sub-1-3', name: 'Tables de Réunion' },
            { id: 'sub-1-4', name: 'Meubles de Rangement' },
            { id: 'sub-1-5', name: "Mobilier D'accueil" },
            { id: 'sub-1-6', name: 'Tables hautes et Tabourets' },
            { id: 'sub-1-7', name: 'Accessoires Aménagement' }
        ]
    },
    {
        id: 'cat-2', name: 'Papeterie', icon: '📄', color: '#00b894',
        subcategories: [
            { id: 'sub-2-1', name: 'Papiers Blancs et Ivoires' },
            { id: 'sub-2-2', name: 'Papiers Couleurs' },
            { id: 'sub-2-3', name: 'Papiers Photo' },
            { id: 'sub-2-4', name: 'Papiers Art Graphique' },
            { id: 'sub-2-5', name: 'Cartes de Correspondance' },
            { id: 'sub-2-6', name: 'Courrier' },
            { id: 'sub-2-7', name: 'Etiquettes et Papier Listing' },
            { id: 'sub-2-8', name: "Travaux d'Impression" }
        ]
    },
    {
        id: 'cat-3', name: 'Fourniture de Bureau', icon: '✏️', color: '#e17055',
        subcategories: [
            { id: 'sub-3-1', name: 'Ecriture & Correction' },
            { id: 'sub-3-2', name: 'Archivage' },
            { id: 'sub-3-3', name: 'Classement' },
            { id: 'sub-3-4', name: 'Cahiers, Blocs et Notes' },
            { id: 'sub-3-5', name: 'Présentation et Communication' },
            { id: 'sub-3-6', name: 'Agendas et Calendriers' },
            { id: 'sub-3-7', name: 'Accessoires et Rangement' },
            { id: 'sub-3-8', name: 'Machines de Bureau' },
            { id: 'sub-3-9', name: 'Cachets et Dateurs' },
            { id: 'sub-3-10', name: 'Petite Fourniture' },
            { id: 'sub-3-11', name: 'Librairie' }
        ]
    },
    {
        id: 'cat-4', name: 'Informatique & Accessoires', icon: '💻', color: '#0984e3',
        subcategories: [
            { id: 'sub-4-1', name: 'Ordinateurs et Serveurs' },
            { id: 'sub-4-2', name: 'Écrans' },
            { id: 'sub-4-3', name: 'Périphériques' },
            { id: 'sub-4-4', name: 'Imprimantes et Multifonctions' },
            { id: 'sub-4-5', name: 'Sauvegarde' },
            { id: 'sub-4-6', name: 'Accessoires Informatiques' },
            { id: 'sub-4-7', name: 'Réseau' },
            { id: 'sub-4-8', name: 'Logiciels' },
            { id: 'sub-4-9', name: 'Vidéoprojection' },
            { id: 'sub-4-10', name: 'Smartphones et Tablettes' },
            { id: 'sub-4-11', name: 'Boutique Apple' },
            { id: 'sub-4-12', name: 'Téléphonie et Télécopie' },
            { id: 'sub-4-13', name: 'Visioconférence' }
        ]
    },
    {
        id: 'cat-5', name: 'Cartouches & Toners', icon: '🖨️', color: '#fdcb6e',
        subcategories: [
            { id: 'sub-5-1', name: "Cartouches Jet d'Encre" },
            { id: 'sub-5-2', name: 'Toner Imprimantes Laser' },
            { id: 'sub-5-3', name: 'Toner Photocopieurs' },
            { id: 'sub-5-4', name: 'Calculatrices et Caisses' },
            { id: 'sub-5-5', name: 'Imprimantes Matricielles' },
            { id: 'sub-5-6', name: 'Télécopieurs et Fax' },
            { id: 'sub-5-7', name: 'Imprimantes Tickets et Badges' },
            { id: 'sub-5-8', name: 'Consommables Compatibles' }
        ]
    },
    {
        id: 'cat-6', name: 'Services Généraux', icon: '🧹', color: '#e84393',
        subcategories: [
            { id: 'sub-6-1', name: 'Hygiène' },
            { id: 'sub-6-2', name: 'Entretien et Sanitaires' },
            { id: 'sub-6-3', name: 'Manutention et Outillage' },
            { id: 'sub-6-4', name: 'Emballage' },
            { id: 'sub-6-5', name: 'Sécurité des Biens et Locaux' },
            { id: 'sub-6-6', name: 'Petit Électro et Électricité' },
            { id: 'sub-6-7', name: 'Alimentation et Réception' },
            { id: 'sub-6-8', name: 'Prévention sur Lieu de Travail' },
            { id: 'sub-6-9', name: "Traitement de l'Air" },
            { id: 'sub-6-10', name: 'Espace Commerçant' },
            { id: 'sub-6-11', name: 'EPI (Protection Individuelle)' },
            { id: 'sub-6-12', name: 'Vêtements de Travail' },
            { id: 'sub-6-13', name: 'Tableaux Décoratifs' }
        ]
    },
    {
        id: 'cat-7', name: 'Bonnes Affaires', icon: '🏷️', color: '#d63031',
        subcategories: [
            { id: 'sub-7-1', name: 'Fourniture de Bureau' },
            { id: 'sub-7-2', name: 'Papier' },
            { id: 'sub-7-3', name: 'Services Généraux' },
            { id: 'sub-7-4', name: 'Machines de Bureau' },
            { id: 'sub-7-5', name: 'Informatique' },
            { id: 'sub-7-6', name: 'Mobilier de Bureau' }
        ]
    }
];

/* ---------- Default Products ---------- */
const DEFAULT_PRODUCTS = [
    { id:'p-1', name:'Bureau de Direction Luxe', category:'cat-1', subcategory:'sub-1-1', price:2499.99, quantity:8, description:'Bureau de direction en bois massif avec finition premium.', image:'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=400&h=400&fit=crop' },
    { id:'p-2', name:'Fauteuil Ergonomique Pro', category:'cat-1', subcategory:'sub-1-2', price:599.99, quantity:25, description:'Fauteuil ergonomique avec soutien lombaire réglable et accoudoirs 4D.', image:'https://images.unsplash.com/photo-1592078615290-033ee584e267?w=400&h=400&fit=crop' },
    { id:'p-3', name:'Table de Réunion Ovale', category:'cat-1', subcategory:'sub-1-3', price:1299.99, quantity:5, description:'Table de réunion 10 personnes, design moderne.', image:'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&h=400&fit=crop' },
    { id:'p-4', name:'Armoire de Rangement', category:'cat-1', subcategory:'sub-1-4', price:449.99, quantity:15, description:'Armoire métallique 2 portes avec serrure.', image:'https://images.unsplash.com/photo-1595428774223-ef52624120d2?w=400&h=400&fit=crop' },
    { id:'p-5', name:'Ramette Papier A4 Blanc', category:'cat-2', subcategory:'sub-2-1', price:4.99, quantity:500, description:'Ramette 500 feuilles papier blanc 80g/m² A4.', image:'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=400&h=400&fit=crop' },
    { id:'p-6', name:'Papier Couleur Pastel', category:'cat-2', subcategory:'sub-2-2', price:8.99, quantity:200, description:'Ramette 250 feuilles couleurs pastels assorties.', image:'https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=400&h=400&fit=crop' },
    { id:'p-7', name:'Enveloppes Commerciales x100', category:'cat-2', subcategory:'sub-2-6', price:12.99, quantity:150, description:'Lot de 100 enveloppes blanches auto-adhésives avec fenêtre.', image:'https://images.unsplash.com/photo-1579751626657-72bc17010498?w=400&h=400&fit=crop' },
    { id:'p-8', name:'Stylo Bille BIC Cristal x50', category:'cat-3', subcategory:'sub-3-1', price:14.99, quantity:300, description:'Boîte de 50 stylos bille BIC Cristal pointe moyenne bleu.', image:'https://images.unsplash.com/photo-1585336261022-680e295ce3fe?w=400&h=400&fit=crop' },
    { id:'p-9', name:'Classeur à Levier A4', category:'cat-3', subcategory:'sub-3-3', price:3.99, quantity:400, description:'Classeur à levier dos 80mm, couverture polypro, coloris assortis.', image:'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=400&h=400&fit=crop' },
    { id:'p-10', name:'Cahier Spirale A4 200p', category:'cat-3', subcategory:'sub-3-4', price:5.49, quantity:250, description:'Cahier à spirale 200 pages grands carreaux, couverture rigide.', image:'https://images.unsplash.com/photo-1531346878377-a5be20888e57?w=400&h=400&fit=crop' },
    { id:'p-11', name:'Agrafeuse de Bureau', category:'cat-3', subcategory:'sub-3-10', price:9.99, quantity:120, description:'Agrafeuse de bureau capacité 25 feuilles, agrafes 26/6 incluses.', image:'https://images.unsplash.com/photo-1612810806695-30f7a8258391?w=400&h=400&fit=crop' },
    { id:'p-12', name:'PC Portable Pro 15"', category:'cat-4', subcategory:'sub-4-1', price:899.99, quantity:20, description:'Ordinateur portable 15.6" Intel i7, 16Go RAM, 512Go SSD.', image:'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=400&fit=crop' },
    { id:'p-13', name:'Écran LED 27"', category:'cat-4', subcategory:'sub-4-2', price:299.99, quantity:30, description:'Moniteur LED 27 pouces Full HD, HDMI/VGA/DP.', image:'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=400&h=400&fit=crop' },
    { id:'p-14', name:'Clavier + Souris Sans Fil', category:'cat-4', subcategory:'sub-4-3', price:34.99, quantity:80, description:'Pack clavier et souris sans fil 2.4GHz, design compact.', image:'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&h=400&fit=crop' },
    { id:'p-15', name:'Imprimante Multifonction Laser', category:'cat-4', subcategory:'sub-4-4', price:349.99, quantity:15, description:'Imprimante laser multifonction couleur, WiFi, recto-verso auto.', image:'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=400&h=400&fit=crop' },
    { id:'p-16', name:'Cartouche HP 305 Noir', category:'cat-5', subcategory:'sub-5-1', price:19.99, quantity:100, description:"Cartouche d'encre noire HP 305 originale.", image:'https://images.unsplash.com/photo-1563396983906-b3795482a59a?w=400&h=400&fit=crop' },
    { id:'p-17', name:'Toner Laser HP 79A', category:'cat-5', subcategory:'sub-5-2', price:69.99, quantity:40, description:'Toner noir HP 79A pour LaserJet Pro, 1000 pages.', image:'https://images.unsplash.com/photo-1585776245991-cf89dd7fc73a?w=400&h=400&fit=crop' },
    { id:'p-18', name:'Gel Désinfectant 500ml', category:'cat-6', subcategory:'sub-6-1', price:4.99, quantity:200, description:'Gel hydroalcoolique désinfectant 500ml, pompe doseuse.', image:'https://images.unsplash.com/photo-1584744982491-665216d95f8b?w=400&h=400&fit=crop' },
    { id:'p-19', name:'Distributeur Papier Essuie-mains', category:'cat-6', subcategory:'sub-6-1', price:39.99, quantity:30, description:'Distributeur mural de papier essuie-mains en ABS.', image:'https://images.unsplash.com/photo-1584568694244-14fbdf83bd30?w=400&h=400&fit=crop' },
    { id:'p-20', name:'Onduleur 1000VA', category:'cat-4', subcategory:'sub-4-6', price:129.99, quantity:25, description:'Onduleur Line-Interactive 1000VA/600W, 4 prises, USB.', image:'https://images.unsplash.com/photo-1518770660439-4636190af475?w=400&h=400&fit=crop' },
    { id:'p-21', name:'Chaise Visiteur', category:'cat-1', subcategory:'sub-1-2', price:149.99, quantity:40, description:'Chaise visiteur avec accoudoirs, piètement luge chromé.', image:'https://images.unsplash.com/photo-1503602642458-232111445657?w=400&h=400&fit=crop' },
    { id:'p-22', name:'Calculatrice de Bureau', category:'cat-3', subcategory:'sub-3-8', price:24.99, quantity:60, description:'Calculatrice de bureau 12 chiffres, double alimentation.', image:'https://images.unsplash.com/photo-1611125782996-3d95e0a3b4f0?w=400&h=400&fit=crop' },
    { id:'p-23', name:'Ruban Correcteur x3', category:'cat-3', subcategory:'sub-3-1', price:6.99, quantity:180, description:'Lot de 3 rubans correcteurs 5mm x 8m, application latérale.', image:'https://images.unsplash.com/photo-1568871009013-abb41f2ee52d?w=400&h=400&fit=crop' },
    { id:'p-24', name:'Disque Dur Externe 1To', category:'cat-4', subcategory:'sub-4-5', price:59.99, quantity:50, description:'Disque dur externe USB 3.0, 1 To, compact et léger.', image:'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=400&h=400&fit=crop' }
];

/* ---------- Storage helpers ---------- */
function loadData(key, defaults) {
    try {
        const raw = localStorage.getItem(key);
        if (raw) return JSON.parse(raw);
    } catch (e) { console.warn('loadData error', e); }
    return defaults;
}
function saveData(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
}

/* ---------- Init Store ---------- */
let categories = loadData(STORAGE_KEYS.categories, DEFAULT_CATEGORIES);
let products   = loadData(STORAGE_KEYS.products, DEFAULT_PRODUCTS);
let cart        = loadData(STORAGE_KEYS.cart, []);
let orders      = loadData(STORAGE_KEYS.orders, []);

function persistAll() {
    saveData(STORAGE_KEYS.categories, categories);
    saveData(STORAGE_KEYS.products, products);
    saveData(STORAGE_KEYS.cart, cart);
    saveData(STORAGE_KEYS.orders, orders);
}

function generateId(prefix) {
    return prefix + '-' + Date.now() + '-' + Math.random().toString(36).substr(2, 5);
}

/* Helper: find parent category for a subcategory */
function findParentCategory(subId) {
    for (const cat of categories) {
        if (cat.subcategories && cat.subcategories.find(s => s.id === subId)) return cat;
    }
    return null;
}

/* Helper: get all subcategories flat */
function getAllSubcategories() {
    const subs = [];
    categories.forEach(cat => {
        if (cat.subcategories) {
            cat.subcategories.forEach(sub => {
                subs.push({ ...sub, parentId: cat.id, parentName: cat.name, color: cat.color });
            });
        }
    });
    return subs;
}
