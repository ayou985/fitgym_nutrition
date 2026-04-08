-- Insertion des produits FitGym Nutrition
-- À exécuter dans phpMyAdmin ou via MySQL CLI

INSERT INTO `products` (`name`, `description`, `price`, `stock`, `category`, `image`) VALUES

-- Whey Isolate
('Whey Isolate Premium', 'Protéine de lactosérum ultra-filtrée avec 90% de protéines par portion. Idéale pour la récupération musculaire post-entraînement. Faible en glucides et en lipides.', 44.90, 50, 'Whey isolate', 'produit_whey.png'),
('Whey Isolate Zero Sugar', 'Whey isolate sans sucre ajouté, 25g de protéines par dose. Formule pure pour une prise de masse sèche. Digestion rapide et excellente solubilité.', 49.90, 35, 'Whey isolate', 'whey-prot.webp'),

-- Whey Gainer
('Mass Gainer Pro 3kg', 'Gainer haute performance avec 50g de protéines et 250g de glucides complexes par portion. Formule enrichie en créatine et BCAA pour une prise de masse rapide.', 39.90, 40, 'Whey gainer', 'produit_gainer.png'),
('Gainer Extreme 5kg', 'Gainer professionnel pour les hardgainers. 600 kcal par portion, matrice protéique complète (whey + caséine), glucides à index glycémique mixte.', 59.90, 20, 'Whey gainer', 'produit_gainer.png'),

-- BCAA
('BCAA 2:1:1 Instant', 'Acides aminés ramifiés en ratio optimal 2:1:1 (Leucine, Isoleucine, Valine). Réduit la fatigue musculaire et accélère la récupération. Solubilité instantanée.', 24.90, 60, 'BCAA', 'bcaa.png'),
('BCAA Essential 8000', 'Complexe BCAA haute concentration avec 8000mg par portion. Enrichi en Glutamine et Vitamine B6 pour optimiser la synthèse protéique et limiter le catabolisme.', 29.90, 45, 'BCAA', 'bcaa-product.png'),

-- Créatine
('Créatine Monohydrate Pure', 'Créatine monohydrate micronisée de qualité pharmaceutique (Creapure®). Augmente la force, la puissance et les performances lors des efforts intenses. 5g par dose.', 19.90, 80, 'Créatine', 'creatine-product.png'),
('Créatine HCL Advanced', 'Créatine Hydrochloride ultra-concentrée, absorption supérieure à la monohydrate. 1,5g par dose suffisent. Pas de phase de chargement nécessaire, sans rétention d'eau.', 32.90, 30, 'Créatine', 'creatine-product.png'),

-- Multivitamines
('Multivitamines Sport Complex', 'Formule complète de 25 vitamines et minéraux adaptée aux sportifs. Inclut Vitamine D3, Zinc, Magnésium, Fer et complexe antioxydant. 1 comprimé par jour.', 18.90, 70, 'Multivitamines', 'multivitamine-product.png'),
('Omega 3 + Multivitamines', 'Pack complet vitamines + oméga-3 EPA/DHA issus d'huile de poisson sauvage. Soutient la récupération, réduit l'inflammation et améliore la santé cardiovasculaire.', 27.90, 50, 'Multivitamines', 'multivitamine-product.png'),

-- Pre-workout
('Pre-Workout Explosive', 'Formule pré-entraînement puissante avec Caféine (200mg), Bêta-Alanine, Citrulline Malate et L-Arginine. Boost d'énergie, focus mental et pump musculaire intense.', 34.90, 40, 'Pre-workout', 'pre-workout-product.webp'),
('Pre-Workout Stim-Free', 'Pré-entraînement sans stimulants, idéal pour les entraînements en soirée. Contient Citrulline (6g), Bêta-Alanine (3,2g), Créatine HCL et électrolytes. Pump maximal sans caféine.', 31.90, 25, 'Pre-workout', 'pre-workout-product.webp');


-- Insertion des saveurs associées (table flavour)
-- D'abord récupérer les IDs insérés et associer les saveurs

INSERT INTO `flavour` (`flavour`, `id_Product`) VALUES
-- Whey Isolate Premium (id auto-généré, adapter si besoin)
('Chocolat', LAST_INSERT_ID() - 11),
('Vanille', LAST_INSERT_ID() - 11),
('Chocolat brownie', LAST_INSERT_ID() - 11),

-- Whey Isolate Zero Sugar
('Chocolat', LAST_INSERT_ID() - 10),
('Vanille', LAST_INSERT_ID() - 10),

-- Mass Gainer Pro
('Chocolat', LAST_INSERT_ID() - 9),
('Vanille', LAST_INSERT_ID() - 9),

-- Gainer Extreme
('Chocolat brownie', LAST_INSERT_ID() - 8),
('Chocolat', LAST_INSERT_ID() - 8);
