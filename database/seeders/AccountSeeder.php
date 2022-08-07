<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AccountSeeder extends Seeder
{
    protected $items = [
        ['code' => '1-10001', 'name' => 'Kas', 'account_type_id' => 1, 'isLock' => 1],
        ['code' => '1-10002', 'name' => 'Bank', 'account_type_id' => 1, 'isLock' => 0],
        ['code' => '1-10100', 'name' => 'Piutang Usaha', 'account_type_id' => 2, 'isLock' => 1],
        ['code' => '1-10101', 'name' => 'Piutang Belum Ditagih', 'account_type_id' => 2, 'isLock' => 1],
        ['code' => '1-10201', 'name' => 'Persediaan Barang', 'account_type_id' => 3, 'isLock' => 1],
        ['code' => '1-10300', 'name' => 'Piutang Lainnya', 'account_type_id' => 4, 'isLock' => 0],
        ['code' => '1-10402', 'name' => 'Biaya Dibayar Di Muka', 'account_type_id' => 4, 'isLock' => 1],
        ['code' => '1-10500', 'name' => 'PPN Masukan', 'account_type_id' => 4, 'isLock' => 1],
        ['code' => '1-10700', 'name' => 'Aset Tetap - Tanah', 'account_type_id' => 5, 'isLock' => 0],
        ['code' => '1-10701', 'name' => 'Aset Tetap - Bangunan', 'account_type_id' => 5, 'isLock' => 0],
        ['code' => '1-10702', 'name' => 'Aset Tetap - Perlengkapan', 'account_type_id' => 5, 'isLock' => 1],
        ['code' => '1-10751', 'name' => 'Akumulasi Penyusutan - Tanah', 'account_type_id' => 6, 'isLock' => 0],
        ['code' => '1-10752', 'name' => 'Akumulasi Penyusutan - Bangunan', 'account_type_id' => 6, 'isLock' => 0],
        ['code' => '1-10753', 'name' => 'Akumulasi Penyusutan - Perlengkapan', 'account_type_id' => 6, 'isLock' => 1],
        ['code' => '1-10800', 'name' => 'Investasi', 'account_type_id' => 7, 'isLock' => 0],
        ['code' => '2-20100', 'name' => 'Hutang Usaha', 'account_type_id' => 8, 'isLock' => 1],
        ['code' => '2-20101', 'name' => 'Hutang Belum Ditagih', 'account_type_id' => 8, 'isLock' => 1],
        ['code' => '2-20200', 'name' => 'Hutang Lain-lain', 'account_type_id' => 9, 'isLock' => 0],
        ['code' => '2-20201', 'name' => 'Hutang Gaji', 'account_type_id' => 9, 'isLock' => 0],
        ['code' => '2-20202', 'name' => 'Hutang Deviden', 'account_type_id' => 9, 'isLock' => 0],
        ['code' => '2-20203', 'name' => 'Pendapatan Diterima Di Muka', 'account_type_id' => 9, 'isLock' => 1],
        ['code' => '2-20205', 'name' => 'Biaya Terhutang Lainnya', 'account_type_id' => 9, 'isLock' => 0],
        ['code' => '2-20400', 'name' => 'Hutang Bank', 'account_type_id' => 9, 'isLock' => 0],
        ['code' => '2-20500', 'name' => 'PPN Keluaran', 'account_type_id' => 9, 'isLock' => 1],
        ['code' => '2-20700', 'name' => 'Kewajiban Manfaat Karyawan', 'account_type_id' => 10, 'isLock' => 0],
        ['code' => '3-30000', 'name' => 'Modal Saham', 'account_type_id' => 11, 'isLock' => 0],
        ['code' => '3-30001', 'name' => 'Tambahan Modal Disetor', 'account_type_id' => 11, 'isLock' => 0],
        ['code' => '3-30999', 'name' => 'Ekuitas Saldo Awal', 'account_type_id' => 11, 'isLock' => 1],
        ['code' => '4-40001', 'name' => 'Pendapatan', 'account_type_id' => 12, 'isLock' => 1],
        ['code' => '4-40002', 'name' => 'Diskon Penjualan', 'account_type_id' => 12, 'isLock' => 1],
        ['code' => '4-40003', 'name' => 'Retur Penjualan', 'account_type_id' => 12, 'isLock' => 1],
        ['code' => '4-40004', 'name' => 'Pendapatan Belum Ditagih', 'account_type_id' => 12, 'isLock' => 1],
        ['code' => '5-50000', 'name' => 'Beban Pokok Pendapatan', 'account_type_id' => 13, 'isLock' => 1],
        ['code' => '5-50001', 'name' => 'Diskon Pembelian', 'account_type_id' => 13, 'isLock' => 1],
        ['code' => '5-30002', 'name' => 'Retur Pembelian', 'account_type_id' => 13, 'isLock' => 0],
        ['code' => '6-60001', 'name' => 'Biaya Umum & Administratif', 'account_type_id' => 14, 'isLock' => 0],
        ['code' => '6-60501', 'name' => 'Penyusutan Aset', 'account_type_id' => 14, 'isLock' => 0],
        ['code' => '7-70000', 'name' => 'Pendapatan Bunga - Bank', 'account_type_id' => 15, 'isLock' => 0],
        ['code' => '7-70099', 'name' => 'Pendapatan Lain-lain', 'account_type_id' => 15, 'isLock' => 1],
        ['code' => '8-80000', 'name' => 'Beban Lain-lain', 'account_type_id' => 16, 'isLock' => 0],
        ['code' => '8-80101', 'name' => 'Penyesuaian Persediaan', 'account_type_id' => 16, 'isLock' => 1],
        ['code' => '9-00000', 'name' => 'Kas Keluar Lainnya', 'account_type_id' => 17, 'isLock' => 1]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // account type seeder
        Schema::disableForeignKeyConstraints();

        DB::table('account_types')->truncate();
        DB::table('account_types')->insert([
            ['code' => '1-100','name'  => 'Kas & Bank'],                 // ID: 1
            ['code' => '1-101','name'  => 'Akun Piutang'],               // ID: 2
            ['code' => '1-102','name'  => 'Persediaan'],                 // ID: 3
            ['code' => '1-103','name'  => 'Aktiva Lancar Lainnya'],      // ID: 4
            ['code' => '1-106','name'  => 'Aktiva Tetap'],               // ID: 5
            ['code' => '1-107','name'  => 'Depresiasi & Amortisasi'],    // ID: 6
            ['code' => '1-108','name'  => 'Aktiva Lainnya'],             // ID: 7
            ['code' => '2-201','name'  => 'Akun Hutang'],                // ID: 8
            ['code' => '2-202','name'  => 'Kewajiban Lancar Lainnya'],   // ID: 9
            ['code' => '2-207','name'  => 'Kewajiban Jangka Panjang'],   // ID: 10
            ['code' => '3-300','name'  => 'Ekuitas'],                    // ID: 11
            ['code' => '4-400','name'  => 'Pendapatan'],                 // ID: 12
            ['code' => '5-500','name'  => 'Harga Pokok Penjualan'],      // ID: 13
            ['code' => '6-600','name'  => 'Beban'],                      // ID: 14
            ['code' => '7-700','name'  => 'Pendapatan Lainnya'],         // ID: 15
            ['code' => '8-800','name'  => 'Beban Lainnya'],              // ID: 16
            ['code' => '9-000','name'  => 'Pengeluaran Kas']             // ID: 17
        ]);

        Schema::enableForeignKeyConstraints();

        // account seeder 
        foreach ($this->items as $item) {
            if (! DB::table('accounts')->where(['code' => $item['code']])->exists()) {
                DB::table('accounts')->insert($item);
            }
        }

    }
}
