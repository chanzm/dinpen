<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Admin",
            'email' => "Admin".'@gmail.com',
            'password' => bcrypt('123'),
            'user_enable' => '1'
        ]);
        
        DB::table('users')->insert([
            'name' => "SUJIATUN, S.Pd",
            'email' => "SUJIATUN".'@gmail.com',
            'password' => bcrypt('123'),
            'user_enable' => '1'
        ]);

        DB::table('users')->insert([
            'name' => "NANING HARINI ARINTOWATI,S.Pd",
            'email' => "NANING".'@gmail.com',
            'password' => bcrypt('123'),
            'user_enable' => '1'
        ]);

        DB::table('unit_kerjas')->insert([
            'kelompok_id' => '1',
            'unit_name' => 'SDN WONOREJO 274',
            'unit_address' => 'WONOREJO RUNGKUT NO. 01',
            'dpalock' => '0',
            'tipe' => '1',
            'nss' => '101056014011',
            'kode_lokasi_simbada' => '13.30.08.01.15.15',
            'status' => 't'
            ]);

        DB::table('unit_kerjas')->insert([
            'kelompok_id' => '1',
            'unit_name' => 'SDN WONOREJO 274',
            'unit_address' => 'WONOREJO RUNGKUT NO. 01',
            'dpalock' => '0',
            'tipe' => '1',
            'nss' => '101056014011',
            'kode_lokasi_simbada' => '13.30.08.01.15.15',
            'status' => 't'
            ]);

        DB::table('detail_kepala_sekolahs')->insert([
            'unit_id' => 1,
            'pangkat_kepala_sekolah' => 'Pembina Tk. I',
            'nip_kepala_sekolah' => '196307251983032014',
            'ktp_kepala_sekolah' => '3578066507630004',
            'alamat_kepala_sekolah' => 'Simo Gunung Kramat Timur 40',
            'kecamatan_kepala_sekolah' => 'RUNGUT',
            'telp_kepala_sekolah' => '082139261660',
            'periode_awal_kepala_sekolah' => date('2016/05/04'),
            'periode_akhir_kepala_sekolah' => date('2017/09/17'),
            'user_id' => 2
            ]);

        DB::table('detail_bendahara_bos')->insert([
            'unit_id' => 1,
            'pangkat_bendahara_bos' => 'PENGATUR TK. I',
            'nip_bendahara_bos' => '196805102008012012',
            'alamat_bendahara_bos' => 'MEDOKAN KAMPUNG BUNTU RT 04 RW 02',
            'sk_bendahara_bos' => '421.1 / 012 / 436.7.1.2.24 / 2018',
            'tgl_sk_bendahara_bos' => date('2016/1/19'),
            'telp_bendahara_bos' => '085607267636',
            'periode_awal_bendahara_bos' => date('2017/1/1'),
            'periode_akhir_bendahara_bos' => date('2017/12/31'),
            'ktp_bendahara_bos' => '3578035005680001',
            'user_id' => 3
        ]);

        DB::table('detail_bendahara_units')->insert([
            'unit_id' => 1,
            'pangkat_bendahara' => 'PENGATUR TK. I',
            'nip_bendahara' => '196805102008012012',
            'alamat_bendahara' => 'MEDOKAN KAMPUNG BUNTU RT 04 RW 02',
            'sk_bendahara' => '421.1 / 012 / 436.7.1.2.24 / 2018',
            'tgl_sk_bendahara' => date('2016/1/19'),
            'telp_bendahara' => '085607267636',
            'periode_awal_bendahara' => date('2017/1/1'),
            'periode_akhir_bendahara' => date('2017/12/31'),
            'ktp_bendahara' => '3578035005680001',
            'user_id' => 3
        ]);

        DB::table('detail_banks')->insert([
            'unit_id' => 1,
            'nama_bank' => 'Bank Jatim',
            'alamat_bank' => 'Semolowaru, UNTAG',
            'nomor_rekening' => '0017909801',
            'atas_nama' => 'SDN Wonorejo 274',
            'cp' => 'Drs. H. UMAR, MM',
            'tlp_cp' => '081330349999',
            'cp_lain' => 'Nanik Handayani, S.Pd.SD',
            'tlp_cp_lain' => '082139144900'
        ]);

        Db::table('transaksi')->insert([
            'nama_transaksi' => "pembayaran Gaji",
            'nilai' => 10000000,
            'tipe' => 1,
            'unit_id' => 1
        ]);

        Db::table('transaksi')->insert([
            'nama_transaksi' => "Pembelian Alat Olah Raga",
            'nilai' => 20000000,
            'tipe' => 2,
            'unit_id' => 1
        ]);

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => 1,
            'nama_detail_tansaksi' => "Gaji Ariya Wildan",
            'nilai' => 5000000,
            'tujuan' => '5115100123',
            'nama_tujuan' => 'Ariya Wildan',
            'status' => 0
        ]);


        DB::table('detail_transaksi')->insert([
            'id_transaksi' => 1,
            'nama_detail_tansaksi' => "Gaji Findryan",
            'nilai' => 5000000,
            'tujuan' => '5115100001',
            'nama_tujuan' => 'Findryan Kurnia Prandana',
            'status' => 0
        ]);

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => 2,
            'nama_detail_tansaksi' => "Pembelian Ring Basket",
            'nilai' => 1000000,
            'tujuan' => '7777',
            'nama_tujuan' => 'PT NBA',
            'status' => 0
        ]);

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => 2,
            'nama_detail_tansaksi' => "Pembelian Bola Basket",
            'nilai' => 2000000,
            'tujuan' => '7777',
            'nama_tujuan' => 'PT NBA',
            'status' => 0
        ]);

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => 2,
            'nama_detail_tansaksi' => "Pembelian Gawang Sepak Bola",
            'nilai' => 17000000,
            'tujuan' => '7777',
            'nama_tujuan' => 'PT Fifa',
            'status' => 0
        ]);
    }
}
