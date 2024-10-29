<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create(['nama_customer' => 'Franky', 'email' => 'franky@gmail.com', 'nomor_telepon' => '08123187423']);
        Customer::create(['nama_customer' => 'Khisan', 'email' => 'khisan@gmail.com', 'nomor_telepon' => '08123465345']);
        Customer::create(['nama_customer' => 'Sultan', 'email' => 'sultan@gmail.com', 'nomor_telepon' => '08123546345']);
        Customer::create(['nama_customer' => 'Amanda', 'email' => 'amanda@gmail.com', 'nomor_telepon' => '08125677654']);
        Customer::create(['nama_customer' => 'Ingrid', 'email' => 'ingrid@gmail.com', 'nomor_telepon' => '08123757433']);
    }
}
