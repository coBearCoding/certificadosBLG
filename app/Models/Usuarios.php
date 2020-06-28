<?php namespace App\Models;


use CodeIgniter\Model;

use function PHPSTORM_META\map;

class Usuarios extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['nombre', 'eliminado', 'id_rol', 'email'];
    protected $useTimestamps = true;
    protected $updatedField = 'fecha_modificacion';
    protected $createdField = 'fecha_creacion';

    protected $validationRules = [
        'nombre' => 'required|min_length[4]',
        'email' => 'required|min_length[8]|valid_email',
        'id_rol'=> 'required'
    ];
    protected $validationMessages = [
        'nombre' => [
            'required' => 'Este campo es requerido',
            'min_length' => 'Minimo colocar 4 caracteres',
        ],
        'email' => [
            'required' => 'Este campo es requerido',
            'min_length' => 'Minimo colocar 8 caracteres',
            'valid_email'=> 'El correo es invalido'
        ],
        'id_rol'=> [
            'required' => 'Este campo es requerido'
        ]
    ];
    //CONSULTAS CUSTOMIZADAS
    public function GetAllUsuarios()
    {
        $builder = $this->db->table('usuario');
        $builder->select('*')->where('eliminado = 0');
        $query = $builder->get()->getResult();
        return $query;
    }

    public function GetUsuRol()
    {
       $builder = $this->db->table('usuario');
       $builder->select('nombre, email, rol');
       $builder->join('roles', 'usuario.id_rol = roles.id_rol')->where("usuario.eliminado = 0");
       $query = $builder->get()->getResult();
       return $query;
    }
}