<?php namespace App\Models;


use CodeIgniter\Model;

class UsuaCerts extends Model
{
    protected $table = 'usu_cert';
    protected $primaryKey = 'id_usu_cert';
    protected $allowedFields = ['id_usuario', 'id_certificado', 'eliminado', 'fecha_certificado'];
    protected $useTimestamps = true;
    protected $updatedField = 'fecha_modificacion';
    protected $createdField = 'fecha_creacion';

    protected $validationRules = [
        'id_usuario' => 'required',
        'id_certificado' => 'required',
        'fecha_certificado' => 'required'
    ];
    protected $validationMessages = [
        'id_usuario' => [
            'required' => 'Este campo es requerido',
        ],
        'id_certificado' => [
            'required' => 'Este campo es requerido',
        ],
        'fecha_certificado' => [
            'required' => 'Este campo es requerido',
        ]
    ];

    //CONSULTA CUSTOMIZADA
    public function GetAllUsuaCerts()
    {
        $builder = $this->db->table('usu_cert');
        $builder->select("certificado.nombre as certificado, usuario.nombre as usuario, usu_cert.fecha_certificado");
        $builder->join('usuario', 'usu_cert.id_usuario = usuario.id_usuario');
        $builder->join('certificado', 'usu_cert.id_certificado = certificado.id_certificado');
        $builder->where('usu_cert.eliminado = 0');
        $query = $builder->get()->getResult();
        return $query;
    }
}