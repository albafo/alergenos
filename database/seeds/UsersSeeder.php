<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		$faker=Faker::create();
		
		\DB::table('usuarios')->insert(array(
				'nombre'=>'Alvaro',
				'apellidos'=>'Baño Fos',
				'email'=>'prueba@prueba.com',
				'password'=>\Hash::make('123456'),
				'tipo'=>'user',
				'status'=>'1'
			));
		
		\DB::table('usuarios')->insert(array(
				'nombre'=>'Alvaro',
				'apellidos'=>'Baño Fos',
				'email'=>'admin@prueba.com',
				'password'=>\Hash::make('123456'),
				'tipo'=>'admin',
				'status'=>'1'
			));
		
		for($i=0; $i<100; $i++)
			\DB::table('usuarios')->insert(array(
				'nombre'=>$faker->firstName,
				'apellidos'=>$faker->lastName,
				'email'=>$faker->unique()->email,
				'password'=>\Hash::make('123456'),
				'tipo'=>'user',
				'status'=>$faker->boolean(80)
			));
	}

}
