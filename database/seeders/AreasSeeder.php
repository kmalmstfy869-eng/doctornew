<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [

            [
                'name' => 'الإسكندرية',
                'slug' => 'alexandria',
            ],

            [
                'name' => 'سيدي بشر',
                'slug' => 'sidi-bishr',
            ],

            [
                'name' => 'ميامي',
                'slug' => 'miami',
            ],

            [
                'name' => 'العصافرة',
                'slug' => 'el-asafra',
            ],

            [
                'name' => 'المندرة',
                'slug' => 'el-mandara',
            ],

            [
                'name' => 'سموحة',
                'slug' => 'smouha',
            ],

            [
                'name' => 'محرم بك',
                'slug' => 'moharam-bik',
            ],

            [
                'name' => 'كامب شيزار',
                'slug' => 'camp-caesar',
            ],

            [
                'name' => 'الإبراهيمية',
                'slug' => 'el-ibrahimia',
            ],

            [
                'name' => 'رشدي',
                'slug' => 'rushdy',
            ],

            [
                'name' => 'كفر عبده',
                'slug' => 'kafr-abdo',
            ],

            [
                'name' => 'جليم',
                'slug' => 'gleem',
            ],

            [
                'name' => 'ستانلي',
                'slug' => 'stanley',
            ],

            [
                'name' => 'لوران',
                'slug' => 'loran',
            ],

            [
                'name' => 'سبورتنج',
                'slug' => 'sporting',
            ],

            [
                'name' => 'المنشية',
                'slug' => 'mansheya',
            ],

            [
                'name' => 'العطارين',
                'slug' => 'attarin',
            ],

            [
                'name' => 'محطة الرمل',
                'slug' => 'raml-station',
            ],

        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
