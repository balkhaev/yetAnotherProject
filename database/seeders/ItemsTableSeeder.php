<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Item::create([
                'bsgId' => $faker->uuid,
                'name' => $faker->word,
                'shortName' => $faker->word,
                'price' => $faker->randomNumber,
                'basePrice' => $faker->randomNumber,
                'avg24hPrice' => $faker->randomNumber,
                'avg7daysPrice' => $faker->randomNumber,
                'traderName' => $faker->word,
                'traderPrice' => $faker->randomNumber,
                'traderPriceCur' => $faker->currencyCode,
                'slots' => $faker->randomDigit,
                'diff24h' => $faker->randomNumber,
                'diff7days' => $faker->randomNumber,
                'icon' => $faker->url,
                'link' => $faker->url,
                'wikiLink' => $faker->url,
                'img' => $faker->imageUrl(320, 240, 'animals', true),
                'imgBig' => $faker->imageUrl(640, 480, 'animals', true),
                'referance' => $faker->url,
            ]);
        }
    }
}
