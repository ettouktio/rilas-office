<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryTree = [
            [
                'name' => 'Mobilier de Bureau',
                'slug' => 'mobilier-de-bureau',
                'description' => 'Postes de travail, salles de reunion et amenagement professionnel pour entreprises marocaines.',
                'children' => [
                    ['name' => 'Bureaux', 'slug' => 'bureaux'],
                    ['name' => 'Sieges et Fauteuils', 'slug' => 'sieges-et-fauteuils'],
                    ['name' => 'Tables de Reunion', 'slug' => 'tables-de-reunion'],
                    ['name' => 'Meubles de Rangement', 'slug' => 'meubles-de-rangement'],
                    ['name' => "Mobilier d'Accueil", 'slug' => 'mobilier-d-accueil'],
                    ['name' => 'Tables hautes et Tabourets', 'slug' => 'tables-hautes-et-tabourets'],
                    ['name' => 'Accessoires Amenagement de Bureau', 'slug' => 'accessoires-amenagement-de-bureau'],
                ],
            ],
            [
                'name' => 'Papeterie',
                'slug' => 'papeterie',
                'description' => 'Papiers, courrier et supports d impression pour administrations, PME et ecoles privees.',
                'children' => [
                    ['name' => 'Papiers Blancs et Ivoires', 'slug' => 'papiers-blancs-et-ivoires'],
                    ['name' => 'Papiers couleurs', 'slug' => 'papiers-couleurs'],
                    ['name' => 'Papiers Photo', 'slug' => 'papiers-photo'],
                    ['name' => 'Papiers Art Graphique', 'slug' => 'papiers-art-graphique'],
                    ['name' => 'Cartes de correspondance', 'slug' => 'cartes-de-correspondance'],
                    ['name' => 'Courrier', 'slug' => 'courrier'],
                    ['name' => 'Etiquettes et Papier listing', 'slug' => 'etiquettes-et-papier-listing'],
                    ['name' => "Travaux d'Impression", 'slug' => 'travaux-d-impression'],
                ],
            ],
            [
                'name' => 'Fourniture de bureau',
                'slug' => 'fourniture-de-bureau',
                'description' => 'Ecriture, classement et petite fourniture pour le quotidien des bureaux au Maroc.',
                'children' => [
                    ['name' => 'Ecriture & Correction', 'slug' => 'ecriture-correction'],
                    ['name' => 'Archivage', 'slug' => 'archivage'],
                    ['name' => 'Classement', 'slug' => 'classement'],
                    ['name' => 'Cahiers, blocs et notes adhesives', 'slug' => 'cahiers-blocs-et-notes-adhesives'],
                    ['name' => 'Presentation et communication', 'slug' => 'presentation-et-communication'],
                    ['name' => 'Agendas et calendriers', 'slug' => 'agendas-et-calendriers'],
                    ['name' => 'Accessoires et rangement de bureau', 'slug' => 'accessoires-et-rangement-de-bureau'],
                    ['name' => 'Machines de Bureau', 'slug' => 'machines-de-bureau'],
                    ['name' => 'Cachets et Dateurs', 'slug' => 'cachets-et-dateurs'],
                    ['name' => 'Piqures comptables et manifolds', 'slug' => 'piqures-comptables-et-manifolds'],
                    ['name' => 'Petite Fourniture', 'slug' => 'petite-fourniture'],
                    ['name' => 'Librairie', 'slug' => 'librairie'],
                ],
            ],
            [
                'name' => 'Informatique & Accessoires',
                'slug' => 'informatique-accessoires',
                'description' => 'Equipements informatiques, impression et reseau pour structures professionnelles et points de vente.',
                'children' => [
                    ['name' => 'Ordinateurs et Serveurs', 'slug' => 'ordinateurs-et-serveurs'],
                    ['name' => 'Ecrans', 'slug' => 'ecrans'],
                    ['name' => 'Peripheriques', 'slug' => 'peripheriques'],
                    ['name' => 'Imprimantes et multifonctions', 'slug' => 'imprimantes-et-multifonctions'],
                    ['name' => 'Sauvegarde', 'slug' => 'sauvegarde'],
                    ['name' => 'Accessoires Informatiques', 'slug' => 'accessoires-informatiques'],
                    ['name' => 'Reseau', 'slug' => 'reseau'],
                    ['name' => 'Logiciels', 'slug' => 'logiciels'],
                    ['name' => 'Videoprojection et Accessoires', 'slug' => 'videoprojection-et-accessoires'],
                    ['name' => 'Photo-Audio Video', 'slug' => 'photo-audio-video'],
                    ['name' => 'Nettoyage informatique', 'slug' => 'nettoyage-informatique'],
                    ['name' => 'Smartphones et Tablettes', 'slug' => 'smartphones-et-tablettes'],
                    ['name' => 'Boutique Apple', 'slug' => 'boutique-apple'],
                    ['name' => 'Telephonie et telecopie', 'slug' => 'telephonie-et-telecopie'],
                    ['name' => 'Visioconference', 'slug' => 'visioconference'],
                ],
            ],
            [
                'name' => 'Cartouches & Toners',
                'slug' => 'cartouches-toners',
                'description' => 'Consommables d impression pour imprimantes, photocopieurs et environnements de bureau intensifs.',
                'children' => [
                    ['name' => "Cartouches jet d'encre", 'slug' => 'cartouches-jet-d-encre'],
                    ['name' => 'Toner pour imprimantes Laser', 'slug' => 'toner-pour-imprimantes-laser'],
                    ['name' => 'Toner Pour Photocopieurs', 'slug' => 'toner-pour-photocopieurs'],
                    ['name' => 'Pour Calculatrices et Caisses enregistreuses', 'slug' => 'pour-calculatrices-et-caisses-enregistreuses'],
                    ['name' => 'Pour imprimantes matricielles', 'slug' => 'pour-imprimantes-matricielles'],
                    ['name' => 'Pour Telecopieurs et Fax', 'slug' => 'pour-telecopieurs-et-fax'],
                    ['name' => 'Consommable pour Imprimantes Tickets et Badges', 'slug' => 'consommable-pour-imprimantes-tickets-et-badges'],
                    ['name' => 'Consommables compatibles', 'slug' => 'consommables-compatibles'],
                ],
            ],
            [
                'name' => 'Services generaux',
                'slug' => 'services-generaux',
                'description' => 'Hygiene, reception, maintenance et confort des espaces de travail.',
                'children' => [
                    ['name' => 'Tableaux decoratifs', 'slug' => 'tableaux-decoratifs'],
                    ['name' => 'Hygiene', 'slug' => 'hygiene'],
                    ['name' => 'Entretien et Sanitaires', 'slug' => 'entretien-et-sanitaires'],
                    ['name' => 'Manutention et Outillage', 'slug' => 'manutention-et-outillage'],
                    ['name' => 'Emballage', 'slug' => 'emballage'],
                    ['name' => 'Securite des Biens et Locaux', 'slug' => 'securite-des-biens-et-locaux'],
                    ['name' => 'Petit electro et electricite', 'slug' => 'petit-electro-et-electricite'],
                    ['name' => 'Alimentation et reception', 'slug' => 'alimentation-et-reception'],
                    ['name' => 'Prevention sur lieu de Travail', 'slug' => 'prevention-sur-lieu-de-travail'],
                    ['name' => "Traitement de l'Air", 'slug' => 'traitement-de-l-air'],
                    ['name' => 'Espace commercant', 'slug' => 'espace-commercant'],
                    ['name' => 'Equipement de Protection Individuelle (EPI)', 'slug' => 'equipement-de-protection-individuelle-epi'],
                    ['name' => "Vetements de Travail pour l'industrie", 'slug' => 'vetements-de-travail-pour-l-industrie'],
                ],
            ],
            [
                'name' => 'LE COIN DES BONNES AFFAIRES',
                'slug' => 'le-coin-des-bonnes-affaires',
                'description' => 'Selections promotionnelles pour les achats budgets, appels d offres et besoins recurrentiels.',
                'children' => [
                    ['name' => 'Fourniture de bureau', 'slug' => 'fourniture-de-bureau'],
                    ['name' => 'Papier', 'slug' => 'papier'],
                    ['name' => 'Services generaux', 'slug' => 'services-generaux'],
                    ['name' => 'Machines de bureau', 'slug' => 'machines-de-bureau'],
                    ['name' => 'Informatique', 'slug' => 'informatique'],
                    ['name' => 'Mobilier de Bureau', 'slug' => 'mobilier-de-bureau'],
                ],
            ],
        ];

        foreach ($categoryTree as $rootIndex => $rootData) {
            $rootCategory = Category::query()->updateOrCreate(
                ['slug' => $rootData['slug']],
                [
                    'name' => $rootData['name'],
                    'description' => $rootData['description'],
                    'parent_id' => null,
                    'sort_order' => $rootIndex,
                    'is_active' => true,
                ]
            );

            foreach ($rootData['children'] as $childIndex => $childData) {
                Category::query()->updateOrCreate(
                    ['slug' => $rootData['slug'].'-'.$childData['slug']],
                    [
                        'name' => $childData['name'],
                        'description' => "{$childData['name']} dans {$rootData['name']}.",
                        'parent_id' => $rootCategory->id,
                        'sort_order' => $childIndex,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
