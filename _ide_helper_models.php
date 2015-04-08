<?php
/**
 * An helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Ingrediente
 *
 * @property integer $id 
 * @property string $nombre 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\Ingrediente whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ingrediente whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ingrediente whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ingrediente whereUpdatedAt($value)
 */
	class Ingrediente {}
}

namespace App{
/**
 * App\Alergeno
 *
 * @property integer $id 
 * @property string $nombre 
 * @property string $descripcion 
 * @property string $img 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereUpdatedAt($value)
 */
	class Alergeno {}
}

namespace App{
/**
 * App\Plato
 *
 * @property integer $id 
 * @property integer $categoria_id 
 * @property string $nombre 
 * @property float $precio 
 * @property integer $orden 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property-read \App\Categoria $categoria 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ingrediente[] $ingredientes 
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereCategoriaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato wherePrecio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereOrden($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereDeletedAt($value)
 */
	class Plato {}
}

namespace App{
/**
 * App\Categoria
 *
 * @property integer $id 
 * @property string $nombre 
 * @property integer $menu_id 
 * @property integer $orden 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Plato[] $platos 
 * @property-read \App\Menu $menu 
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereMenuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereOrden($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereDeletedAt($value)
 */
	class Categoria {}
}

namespace App{
/**
 * App\Menu
 *
 * @property integer $id 
 * @property string $nombre 
 * @property string $descripcion 
 * @property string $caducidad 
 * @property integer $user_id 
 * @property boolean $estado 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Categoria[] $categorias 
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereCaducidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereDeletedAt($value)
 */
	class Menu {}
}

namespace App{
/**
 * App\User
 *
 * @property integer $id 
 * @property string $nombre 
 * @property string $apellidos 
 * @property string $email 
 * @property string $tipo 
 * @property string $password 
 * @property boolean $confirmed 
 * @property string $email_confirmation 
 * @property string $remember_token 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Menu[] $menus 
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereApellidos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereTipo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmailConfirmation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 */
	class User {}
}

