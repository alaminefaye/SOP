<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cuisine',
                'slug' => 'cuisine',
                'description' => 'Procédures de préparation, cuisson et conservation des aliments',
                'icon' => 'bx-food-menu',
                'color' => '#FF6B6B',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Service',
                'slug' => 'service',
                'description' => 'Procédures d\'accueil, prise de commande et service client',
                'icon' => 'bx-restaurant',
                'color' => '#4ECDC4',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Hygiène & Nettoyage',
                'slug' => 'hygiene-nettoyage',
                'description' => 'Procédures de nettoyage, désinfection et maintenance',
                'icon' => 'bx-spray',
                'color' => '#45B7D1',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Sécurité',
                'slug' => 'securite',
                'description' => 'Sécurité alimentaire, sécurité incendie et premiers secours',
                'icon' => 'bx-shield-alt-2',
                'color' => '#F7B731',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Stock & Inventaire',
                'slug' => 'stock-inventaire',
                'description' => 'Réception, stockage et rotation des stocks',
                'icon' => 'bx-package',
                'color' => '#A55EEA',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Gestion Financière',
                'slug' => 'gestion-financiere',
                'description' => 'Caisse, facturation et rapports financiers',
                'icon' => 'bx-money',
                'color' => '#26DE81',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Ressources Humaines',
                'slug' => 'ressources-humaines',
                'description' => 'Formation, évaluation et planning du personnel',
                'icon' => 'bx-group',
                'color' => '#FD79A8',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Administration',
                'slug' => 'administration',
                'description' => 'Ouverture, fermeture et procédures administratives',
                'icon' => 'bx-building',
                'color' => '#6C5CE7',
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
