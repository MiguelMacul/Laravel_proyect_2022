<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Empleado extends Model
{
    //indica a que tabla va referenciado
    protected $table = 'empleado';
    //array de los campos de la tabla
    //Atributs
    protected $fillable = ['id','nombre','edad','puesto','activo','estado_residencia','sueldo','tipo_moneda'];
}
