<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
Use App\User;

class UsersModuleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use RefreshDatabase;  //lo que se haga en cada uno de los metodos se deshace cuando finaliza

    public function test_it_shows_the_user_list_page()
    {
        factory(User::class)->create(['name' => 'Joel']);
        factory(User::class)->create(['name' => 'Ellie']);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('Joel')
            ->assertSee('Ellie');
    }

    public function test_it_shows_a_default_messege_if_there_are_no_users()
    {
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('No hay usuarios registrados');
    }

    public function test_it_displays_the_user_details_page()
    {
        $user = factory(User::class)->create(['name' => 'Duilio Palacios']);

        $this->get('/usuarios/'.$user->id)
            ->assertStatus(200)
            ->assertSee('Duilio Palacios');
    }

    public function it_displays_a_404_error_if_the_user_is_not_found()
    {
        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }

    public function test_it_loads_the_new_users_page()
    {
        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear nuevo usuario');
    }

    public function it_creates_a_new_user()
    {
        $this->post('/usuarios', [
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456'
        ])->assertRedirect('/usuarios');

        /*$this->assertDatabaseHas('users', [
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456' --> no la va a encontrar porque esta encriptada
                                            por eso se usa el método de abajo
        ]);*/

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456']);
    }

    public function the_name_is_required()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios', [
                'name' => '',
                'email' => 'duilio@styde.net',
                'password' => '123456'])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

        /*$this->assertDatabaseMissing('users', ['email' => 'duilio@styde.net']);*/

        $this->assertEquals(0, User::count());
    }

    public function the_email_is_required()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios', [
                'name' => 'Duilio',
                'email' => '',
                'password' => '123456'])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['email' => 'El campo email es obligatorio']);

        /*$this->assertDatabaseMissing('users', ['email' => 'duilio@styde.net']);*/

        $this->assertEquals(0, User::count());
    }

    public function the_email_must_be_valid()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios', [
                'name' => 'Duilio',
                'email' => 'correo-no-valido',
                'password' => '123456'])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['email' => 'El email no es válido']);

        /*$this->assertDatabaseMissing('users', ['email' => 'duilio@styde.net']);*/

        $this->assertEquals(0, User::count());
    }

    public function the_email_must_be_unique()
    {
        factory(User::class)->create([
            'email' => 'duilio@styde.net']);
        
        $this->from('/usuarios/nuevo')
            ->post('/usuarios', [
                'name' => 'Duilio',
                'email' => 'duilio@styde.net',
                'password' => '123456'])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['email' => 'El email está en uso y debe ser único']);

        /*$this->assertDatabaseMissing('users', ['email' => 'duilio@styde.net']);*/

        $this->assertEquals(1, User::count());  //se valida que haya solo un registro
    }

    public function the_password_is_required()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios', [
                'name' => 'Duilio',
                'email' => 'duilio@styde.net',
                'password' => ''])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['password' => 'El campo password es obligatorio']);

        /*$this->assertDatabaseMissing('users', ['email' => 'duilio@styde.net']);*/

        $this->assertEquals(0, User::count());
    }

    public function the_password_must_have_more_than_6_characters()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios', [
                'name' => 'Duilio',
                'email' => 'duilio@styde.net',
                'password' => '123'])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['password' => 'La contraseña debe contener más de 6 caracteres']);

        $this->assertEquals(0, User::count());
    }

    public function test_it_loads_the_user_edit_page()
    {
        $user = factory(User::class)->create();
        
        $this->get("/usuarios/{$user->id}/editar")
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario')
            ->assertViewHas('user', function ($viewUser) use ($user) {
                return $viewUser->id == $user->id;
            });
    }

    public function it_updates_a_user()
    {
        $user = factory(User::class)->create();
        
        $this->put("/usuarios/{$user->id}", [
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456'
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456']);
    }

    public function the_name_is_required_when_updating_a_user()
    {
        $user = factory(User::class)->create();
        
        $this->from("/usuarios/{$user->id}/editar")
            ->post("/usuarios/{$user->id}", [
                'name' => '',
                'email' => 'duilio@styde.net',
                'password' => '123456'])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

        $this->assertDatabaseMissing('users', ['email' => 'duilio@styde.net']);
    }

    public function the_email_is_required_when_updating_a_user()
    {
        $user = factory(User::class)->create();
        
        $this->from("/usuarios/{$user->id}/editar")
            ->post("/usuarios/{$user->id}", [
                'name' => 'Duilio',
                'email' => '',
                'password' => '123456'])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email' => 'El campo email es obligatorio']);

        $this->assertDatabaseMissing('users', ['name' => 'Duilio']);
    }

    public function the_email_must_be_valid_when_updating_a_user()
    {
        $user = factory(User::class)->create();
        
        $this->from("/usuarios/{$user->id}/editar")
            ->post("/usuarios/{$user->id}", [
                'name' => 'Duilio',
                'email' => 'correo-no-valido',
                'password' => '123456'])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email' => 'El email no es válido']);

        $this->assertDatabaseMissing('users', ['name' => 'Duilio']);
    }

    public function the_email_must_be_unique_when_updating_a_user()
    {
        factory(User::class)->create([
            'email' => 'existing-email@example.com'
        ]);
        
        $user = factory(User::class)->create([
            'email' => 'duilio@styde.net']);
        
        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => 'Duilio',
                'email' => 'existing-email@example.com',
                'password' => '123456'])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email' => 'El email está en uso y debe ser único']);

        //$this->assertDatabaseMissing('users', ['email' => 'duilio@styde.net']);
    }

    public function the_email_can_stay_the_same_when_updating_a_user()
    {
        $user = factory(User::class)->create([
            'email' => 'duilio@styde.net']);
        
        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => 'Duilio',
                'email' => 'duilio@styde.net',
                'password' => '123456'])
            ->assertRedirect("/usuarios/{$user->id}");

        $this->assertDatabaseHas('users', [
            'name' => 'Duilio',
            'email' => 'duilio@styde.net']);
    }

    public function the_password_is_optional_when_updating_a_user()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('clave_anterior')]);
        
        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => 'Duilio',
                'email' => 'duilio@styde.net',
                'password' => ''])
            ->assertRedirect("/usuarios/{$user->id}");

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => 'clave_anterior']);
    }

    public function it_deletes_a_user()
    {
        $user = factory(User::class)->create();
        
        $this->delete("/usuarios/{$user->id}")
            ->assertRedirect('/usuarios');

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        //$this->assertSame(0, User::count());
    }
}
