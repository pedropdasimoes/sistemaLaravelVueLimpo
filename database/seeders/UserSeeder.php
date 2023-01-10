<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UsuarioUnis;
use App\Actions\Fortify\CreateNewUser;
use App\Models\GrupoDocumentos;

class UserSeeder extends Seeder
{
    private $objUsuario;
    private $objGrupoDocumento;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Admin*/
        tap(User::create([
            'name' => 'Super Admin',
            'title' => 'Admin',
            'email' => 'admin@sistema.com.br',
            'password' => bcrypt('admin'),
            'permission' => '0-1-2-3-4-5-6'
        ]), function (User $user) {
            (new CreateNewUser())->createTeam($user);
        });

        tap(User::create([
            'name' => 'Super Desenvolvedor',
            'title' => 'Desenvolvedor',
            'email' => 'developer@sistema.com.br',
            'password' => bcrypt('developer'),
            'permission' => '0-1-2-3-4-5-6-7'
        ]), function (User $user) {
            (new CreateNewUser())->createTeam($user);
        });
    }
}
