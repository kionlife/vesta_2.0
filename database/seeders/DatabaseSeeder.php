<?php

namespace Database\Seeders;

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
        Schema::disableForeignKeyConstraints();
        // \App\Models\User::factory(10)->create();
        $this->call(AbonentsTableSeeder::class);
        $this->call(AbonentTypeTableSeeder::class);
        $this->call(ArchiveTableSeeder::class);
        $this->call(BalancesTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(ContractsTableSeeder::class);
        $this->call(CostsTableSeeder::class);
        $this->call(CountersTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(HistoryTableSeeder::class);
        $this->call(InspectorToServiceTableSeeder::class);
        $this->call(InvoicesTableSeeder::class);
        $this->call(MetersTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(OauthAccessTokensTableSeeder::class);
        $this->call(OauthAuthCodesTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);
        $this->call(OauthPersonalAccessClientsTableSeeder::class);
        $this->call(OauthRefreshTokensTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(ProvidersTableSeeder::class);
        $this->call(ReceiptTableSeeder::class);
        $this->call(ReceiptDataTableSeeder::class);
        $this->call(ReceiptStatusTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ServiceToMeterTableSeeder::class);
        $this->call(TariffsTableSeeder::class);
        $this->call(TypeTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
