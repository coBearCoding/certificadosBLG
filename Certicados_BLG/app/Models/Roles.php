<?php

namespace App\Models;


use CodeIgniter\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    protected $allowedFields = ['rol', 'eliminado'];
    protected $useTimestamps = true;
    protected $updatedField = 'fecha_modificacion';
    protected $createdField = 'fecha_creacion';

    protected $validationRules = [
        'rol' => 'required|min_length[4]',
    ];
    protected $validationMessages = [
        'rol' => [
            'required' => 'Este campo es requerido',
            'min_length' => 'Minimo colocar 4 caracteres',
        ]
    ];

    //CONSULTA CUSTOMIZADA
    public function GetRoles()
    {
        $builder = $this->db->table('roles');
        $builder->select('rol')->where('roles.eliminado = 0');
        $query = $builder->get()->getResult();
        return $query;
    }
}
