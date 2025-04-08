<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imgpath = __DIR__ . "/kepek";

        Product::insert([
            [
                'name_hu' => 'Takia, fehér alap',
                'name_en' => 'Takia, white base',
                'material_hu' => 'nemez',
                'material_en' => 'felt',
                'description_hu' => 'Hagyományos nomád fejviselet tisztán nemezből, vastagabb anyag és tiszta varrat',
                'description_en' => 'Traditional nomadic headwear made of pure felt, thicker material and clean seams',
                'price_hu' => 10000.00,
                'price_en' => 35.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/takia.jpg")),
                'stock' => 30,
                'category_hu' => "fejviselet",
                'category_en' => "headwear",

            ],
            [
                'name_hu' => 'Takia, színes alap',
                'name_en' => 'Takia, colored base',
                'material_hu' => 'nemez',
                'material_en' => 'felt',
                'description_hu' => 'Hagyományos nomád fejviselet tisztán nemezből, vékonyabb anyag',
                'description_en' => 'Traditional nomadic headwear made of pure felt, thinner material',
                'price_hu' => 8000.00,
                'price_en' => 30.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/takia_colored.jpg")),
                'stock' => 28,
                'category_hu' => "fejviselet",
                'category_en' => "headwear",
            ],
            [
                'name_hu' => 'Kazah Ushanka',
                'name_en' => 'Kazakh Ushanka',
                'material_hu' => 'gyapjú',
                'material_en' => 'wool',
                'description_hu' => 'Hagyományos sapka ami védi a füleket és vastag anyagnól van régi nomád díszítéssel. Tökéletes téli viselet.',
                'description_en' => 'Traditional hat that protects the ears and is made of thick material with old nomadic decoration. Perfect winter wear.',
                'price_hu' => 12000.00,
                'price_en' => 40.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/ushanka.jpg")),
                'stock' => 20,
                'category_hu' => "fejviselet",
                'category_en' => "headwear",
            ],
            [
                'name_hu' => '230x120 cm-es faliszőnyeg',
                'name_en' => '230x120 cm wall carpet',
                'material_hu' => 'szövet',
                'material_en' => 'fabric',
                'description_hu' => 'Hagyományos nomád faliszőnyeg amit jurta vagy ház falára lehet akasztani. Éves kézi munka.',
                'description_en' => 'Traditional nomadic wall carpet that can be hung on the wall of a yurt or house. Yearly handwork.',
                'price_hu' => 100000.00,
                'price_en' => 350.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/230x120wall_carpet.jpg")),
                'stock' => 1,
                'category_hu' => "dísz",
                'category_en' => "decoration",

            ],
            [
                'name_hu' => '110x80 cm-es faliszőnyeg',
                'name_en' => '110x80 cm wall carpet',
                'material_hu' => 'szövet',
                'material_en' => 'fabric',
                'description_hu' => 'Hagyományos nomád faliszőnyeg amit jurta vagy ház falára lehet akasztani. Éves kézi munka.',
                'description_en' => 'Traditional nomadic wall carpet that can be hung on the wall of a yurt or house. Yearly handwork.',
                'price_hu' => 80000.00,
                'price_en' => 280.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/110x80wall_carpet.jpg")),
                'stock' => 1,
                'category_hu' => "dísz",
                'category_en' => "decoration",

            ],
            [
                'name_hu' => 'Közepes váll táska',
                'name_en' => 'Small shoulder bag',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Közepes méretű váll táska ami tökéletes a mindennapi használatra.',
                'description_en' => 'Medium-sized shoulder bag that is perfect for everyday use.',
                'price_hu' => 12000.00,
                'price_en' => 40.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/shoulder_bag.jpg")),
                'stock' => 14,
                'category_hu' => "táska",
                'category_en' => "bag",

            ],
            [
                'name_hu' => 'Kicsi váll táska',
                'name_en' => 'Small shoulder bag',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Kis méretű váll táska ami tökéletes a mindennapi használatra apró dolgok tárolásához.',
                'description_en' => 'Small-sized shoulder bag that is perfect for everyday use for storing small items.',
                'price_hu' => 8000.00,
                'price_en' => 30.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/small_shoulder_bag.jpg")),
                'stock' => 20,
                'category_hu' => "táska",
                'category_en' => "bag",

            ],
            [
                'name_hu' => 'Nagy női táska',
                'name_en' => 'Large women\'s bag',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Nagy méretű táska nők számára sok zsebbel a minden napi használatra.',
                'description_en' => 'Large size bag for women with many pockets for everyday use.',
                'price_hu' => 15000.00,
                'price_en' => 50.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/bag.jpg")),
                'stock' => 13,
                'category_hu' => "táska",
                'category_en' => "bag",

            ],
            [
                'name_hu' => 'Közepes női táska',
                'name_en' => 'Medium women\'s bag',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Közepes méretű táska nők számára sok zsebbel a minden napi használatra.',
                'description_en' => 'Middle size bag for women with many pockets for everyday use.',
                'price_hu' => 12000.00,
                'price_en' => 40.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/midbag.jpg")),
                'stock' => 15,
                'category_hu' => "táska",
                'category_en' => "bag",
            ],

            [
                'name_hu' => 'Kicsi női táska',
                'name_en' => 'Small women\'s bag',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Kis méretű táska nők számára sok zsebbel a minden napi használatra.',
                'description_en' => 'Small size bag for women with many pockets for everyday use.',
                'price_hu' => 10000.00,
                'price_en' => 35.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/smallbag.jpg")),
                'stock' => 15,
                'category_hu' => "táska",
                'category_en' => "bag",
            ],

            [
                'name_hu' => 'Kis szütyő',
                'name_en' => 'Small pouch',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Kis szütyő apró dolgok tárolására. Nyakba akasztható.',
                'description_en' => 'Small pouch for storing small items. Can be hung around the neck.',
                'price_hu' => 7000.00,
                'price_en' => 25.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/smallpouch.jpg")),
                'stock' => 15,
                'category_hu' => "táska",
                'category_en' => "bag",

            ],

            [
                'name_hu' => 'Hátizsák',
                'name_en' => 'Backpack',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Hátizsák sok zsebbel a mindennapi használatra.',
                'description_en' => 'Backpack with many pockets for everyday use.',
                'price_hu' => 12000.00,
                'price_en' => 40.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/bagpack.jpg")),
                'stock' => 8,
                'category_hu' => "táska",
                'category_en' => "bag",


            ],
            [
                'name_hu' => 'Aprós Pénztárca',
                'name_en' => 'Small wallet for coins',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Pénztárca aprók tárolására',
                'description_en' => 'Wallet for storing coins',
                'price_hu' => 6000.00,
                'price_en' => 20.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/smallwallet.jpg")),
                'stock' => 5,
                'category_hu' => "táska",
                'category_en' => "bag",

            ],
            [
                'name_hu' => 'Kicsi oldal táska',
                'name_en' => 'Small side bag',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Elegáns oldal táska apró dolgok tárolására. ',
                'description_en' => 'Elegant side bag for storing small items.',
                'price_hu' => 9000.00,
                'price_en' => 30.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/smallsidebag.jpg")),
                'stock' => 5,
                'category_hu' => "táska",
                'category_en' => "bag",

            ],

            [
                'name_hu' => 'Dísz párna',
                'name_en' => 'Decorative pillow',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Dísz párna ami tökéletes a kanapéra vagy az ágyra.',
                'description_en' => 'Decorative pillow that is perfect for the couch or bed.',
                'price_hu' => 9000.00,
                'price_en' => 30.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/decorativepillow.jpg")),
                'stock' => 5,
                'category_hu' => "dísz",
                'category_en' => "decoration",


            ],

            [
                'name_hu' => 'Szemüveg tartó',
                'name_en' => 'Glasses holder',
                'material_hu' => 'bársony',
                'material_en' => 'velvet',
                'description_hu' => 'Szemüveg tartó ami tökéletes a szemüveg tárolására.',
                'description_en' => 'Glasses holder that is perfect for storing glasses.',
                'price_hu' => 7000.00,
                'price_en' => 25.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/glassholder.jpg")),
                'stock' => 5,
                'category_hu' => "táska",
                'category_en' => "bag",

            ],
            [
                'name_hu' => 'Asztal terítő',
                'name_en' => 'Table cloth',
                'material_hu' => 'pamut',
                'material_en' => 'cotton',
                'description_hu' => 'Dísz asztal terítő virág mintával.',
                'description_en' => 'Decorative tablecloth with flower pattern.',
                'price_hu' => 15000.00,
                'price_en' => 50.00,
                'image_url' => base64_encode(file_get_contents($imgpath . "/tablecloth.jpg")),
                'stock' => 5,
                'category_hu' => "táska",
                'category_en' => "bag",

            ],








        ]);
    }
}
