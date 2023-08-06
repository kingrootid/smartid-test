<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\MasterKlaster;
use App\Models\SubKlaster;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => 1
        ]);
        MasterKlaster::insert(
            [
                [
                    'name' => 'Hak Sipil dan Kebebasan',
                    'uuid' => '13e2f7df-1e4d-47e3-a5b1-72d5ebdfb36b'
                ],
                [
                    'name' => 'Lingkungan Keluarga dan Pengasuhan Alternatif',
                    'uuid' => '66c7a30a-0c03-41f2-ada4-61870aa055b2'
                ],
                [
                    'name' => 'Kekerasan Dasar dan Kesejahteraan',
                    'uuid' => '0f16132a-fbd1-4ad9-a56b-f59df3e8c758'
                ],
                [
                    'name' => 'Pendidikan, Pemanfaatan Waktu Luang dan Kegiatan Budaya',
                    'uuid' => 'bcf6a624-82fa-4066-b8e0-68dbedad511c'
                ],
                [
                    'name' => 'Perlindungan Khusus',
                    'uuid' => 'c2d22a2d-c0bb-450e-bc37-ca02b53522f5'
                ],
            ]
        );
        SubKlaster::insert(
            [
                [
                    'uuid' => '07dbbe25-53a2-4b47-93e4-d003ba44280b',
                    'master_klaster_uuid' => '13e2f7df-1e4d-47e3-a5b1-72d5ebdfb36b',
                    'name' => 'Hak atas identitas'
                ],
                [
                    'uuid' => 'e704a7cc-a7ef-42a6-9a07-54b0aa4c3da3',
                    'master_klaster_uuid' => '13e2f7df-1e4d-47e3-a5b1-72d5ebdfb36b',
                    'name' => 'Hak perlindungan identitas'
                ],
                [
                    'uuid' => 'ec633978-0954-4ac6-8863-bbafad7f024e',
                    'master_klaster_uuid' => '13e2f7df-1e4d-47e3-a5b1-72d5ebdfb36b',
                    'name' => 'Hak berekspresi dan mengeluarkan pendapat'
                ],
                [
                    'uuid' => 'a09252dd-ef88-46f7-b5b1-b3d65c019f8f',
                    'master_klaster_uuid' => '13e2f7df-1e4d-47e3-a5b1-72d5ebdfb36b',
                    'name' => 'Hak berpikir, berhati nurani dan beragama'
                ],
                [
                    'uuid' => '499ed55c-ec74-4a21-b87f-44e4fefa13d2',
                    'master_klaster_uuid' => '13e2f7df-1e4d-47e3-a5b1-72d5ebdfb36b',
                    'name' => 'Hak berorganisasi dan berkumpul secara damai'
                ],
                [
                    'uuid' => '76af79f9-78f1-4879-a0b0-f17db22bb07f',
                    'master_klaster_uuid' => '13e2f7df-1e4d-47e3-a5b1-72d5ebdfb36b',
                    'name' => 'Hak atas perlindungan kehidupan pribadi'
                ],
                [
                    'uuid' => '67ef94ee-adcf-4982-9735-41914a8e9ee7',
                    'master_klaster_uuid' => '13e2f7df-1e4d-47e3-a5b1-72d5ebdfb36b',
                    'name' => 'Hak akses informasi yang layak'
                ],
                [
                    'uuid' => '16cd2b78-b39e-4204-904e-c5de12b7b70a',
                    'master_klaster_uuid' => '13e2f7df-1e4d-47e3-a5b1-72d5ebdfb36b',
                    'name' => 'Hak bebas dari penyiksaan dan penghukuman lain yang kejam, tidak manusiawi atau merendahkan martabat manusia'
                ],
                [
                    'uuid' => 'e139969e-9e13-41d6-972a-a9bd39e6f585',
                    'master_klaster_uuid' => '66c7a30a-0c03-41f2-ada4-61870aa055b2',
                    'name' => 'Bimbingan dan tanggung jawab orang tua'
                ],
                [
                    'uuid' => 'f4fba558-3b55-4226-83b0-f8711b606ed0',
                    'master_klaster_uuid' => '66c7a30a-0c03-41f2-ada4-61870aa055b2',
                    'name' => 'Anak yang terpisah dari orang tua'
                ],
                [
                    'uuid' => '4189304f-2121-48c2-8c61-f208764f8fd7',
                    'master_klaster_uuid' => '66c7a30a-0c03-41f2-ada4-61870aa055b2',
                    'name' => 'Reunifikasi'
                ],
                [
                    'uuid' => '58b20322-88aa-40a7-83cb-6b83f946c50e',
                    'master_klaster_uuid' => '66c7a30a-0c03-41f2-ada4-61870aa055b2',
                    'name' => 'Pemindahan anak secara ilegal'
                ],
                [
                    'uuid' => 'be2974fb-d9a4-4182-b0fe-0b7d4c2e68c0',
                    'master_klaster_uuid' => '66c7a30a-0c03-41f2-ada4-61870aa055b2',
                    'name' => 'Dukungan kesejahteraan bagi anak'
                ],
                [
                    'uuid' => 'bc84c768-6609-4af5-85e7-f259c4bbef96',
                    'master_klaster_uuid' => '66c7a30a-0c03-41f2-ada4-61870aa055b2',
                    'name' => 'Anak yang terpaksa dipisahkan dari lingkungan keluarga'
                ],
                [
                    'uuid' => 'eb9cdea1-40da-4914-9cfb-db098ae24b1e',
                    'master_klaster_uuid' => '66c7a30a-0c03-41f2-ada4-61870aa055b2',
                    'name' => 'Pengangkatan/adopsi anak'
                ],
                [
                    'uuid' => 'ba4f271f-c30a-432c-929e-75378bc971db',
                    'master_klaster_uuid' => '66c7a30a-0c03-41f2-ada4-61870aa055b2',
                    'name' => 'Tinjauan penempatan secara berkala'
                ],
                [
                    'uuid' => '69b61b79-8bb0-477b-a7ee-5e7e4a75e110',
                    'master_klaster_uuid' => '66c7a30a-0c03-41f2-ada4-61870aa055b2',
                    'name' => 'Kekerasan dan penelantaran'
                ],
                [
                    'uuid' => '98db94d6-ea16-4117-8358-7022b832821d',
                    'master_klaster_uuid' => '0f16132a-fbd1-4ad9-a56b-f59df3e8c758',
                    'name' => 'Anak penyandang disabilitas'
                ],
                [
                    'uuid' => '78c70266-48cf-465d-a25c-7dfa07da35e0',
                    'master_klaster_uuid' => '0f16132a-fbd1-4ad9-a56b-f59df3e8c758',
                    'name' => 'Kesehatan dan layanan kesehatan'
                ],
                [
                    'uuid' => 'f9e24920-9100-496c-9719-8052502ac6da',
                    'master_klaster_uuid' => '0f16132a-fbd1-4ad9-a56b-f59df3e8c758',
                    'name' => 'Jaminan sosial layanan dan fasilitasi kesehatan'
                ],
                [
                    'uuid' => 'da90e2ad-d846-44f2-bc5a-2efaf2c809c8',
                    'master_klaster_uuid' => '0f16132a-fbd1-4ad9-a56b-f59df3e8c758',
                    'name' => 'Standar hidup'
                ],
                [
                    'uuid' => '16caf39d-c01d-4ec2-bacb-1963884bc234',
                    'master_klaster_uuid' => 'bcf6a624-82fa-4066-b8e0-68dbedad511c',
                    'name' => 'Pendidikan'
                ],
                [
                    'uuid' => '9c3237b7-ccaf-406d-9e3c-f86ff6ccecf8',
                    'master_klaster_uuid' => 'bcf6a624-82fa-4066-b8e0-68dbedad511c',
                    'name' => 'Tujuan pendidikan'
                ],
                [
                    'uuid' => 'c557e733-f854-4f4d-9c46-e23848ed0d35',
                    'master_klaster_uuid' => 'bcf6a624-82fa-4066-b8e0-68dbedad511c',
                    'name' => 'Kegiatan liburan, kegiatan budaya, dan olahraga'
                ],
                [
                    'uuid' => '670f03e4-f9be-4741-a044-ac2c82115f79',
                    'master_klaster_uuid' => 'c2d22a2d-c0bb-450e-bc37-ca02b53522f5',
                    'name' => 'Anak dalam situasi darurat'
                ],
                [
                    'uuid' => 'ffc4a92d-a947-4e41-8cc8-951ef863c684',
                    'master_klaster_uuid' => 'c2d22a2d-c0bb-450e-bc37-ca02b53522f5',
                    'name' => 'Anak yang berhadapan dengan hukum'
                ],
                [
                    'uuid' => '75a8a90a-87c2-466d-b43a-f5ca9595eb63',
                    'master_klaster_uuid' => 'c2d22a2d-c0bb-450e-bc37-ca02b53522f5',
                    'name' => 'Anak dalam situasi eksploitasi'
                ],
                [
                    'uuid' => 'aa08349c-dac3-4cb7-9809-6c1c64bb5e30',
                    'master_klaster_uuid' => 'c2d22a2d-c0bb-450e-bc37-ca02b53522f5',
                    'name' => 'Anak yang masuk dalam kelompok minoritas dan adat'
                ],
            ]
        );
    }
}
