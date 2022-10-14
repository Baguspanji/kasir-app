<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermsConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tNC = [
            [
                'app_id' => 'app.demo.kasir',
                'title' => 'Aplikasi ini merupakan milik Cv. Jonjava Tecnology. Kami membuat aplikasi berdasarkan permasalahan yang di hadapi publik.',
            ],
            [
                'app_id' => 'app.demo.kasir',
                'title' => 'Pengunduhan dan/atau penggunaan Aplikasi ini bebas biaya. Koneksi kepada jaringan internet diperlukan untuk dapat menggunakan Layanan ini. Segala biaya yang timbul atas koneksi perangkat mobile anda dengan jaringan internet sepenuhnya ditanggung oleh anda.',
            ],
            [
                'app_id' => 'app.demo.kasir',
                'title' => 'Aplikasi memerlukan izin untuk mengaksesnya, dengan mendaftarkan diri anda ke pihak yang bertanggung jawab anda akan dapat mengakses aplikasi ini.',
            ],
            [
                'app_id' => 'app.demo.kasir',
                'title' => 'Segala data yang tampil pada aplikasi adalah data yang telah di setujui oleh beberapa pihak.',
            ],
            [
                'app_id' => 'app.demo.kasir',
                'title' => 'Segala data yang tampil pada aplikasi berasal dari situs http://raport.smkalyasini.com/',
            ],
        ];

        foreach ($tNC as $tnc) {
            \App\Models\TermsCondition::create($tnc);
        }
    }
}
