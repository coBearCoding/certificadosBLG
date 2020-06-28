<?php namespace App\Models;


use CodeIgniter\Model;

class Certificados extends Model
{
    protected $table = 'certificado';
    protected $primaryKey = 'id_certificado';
    protected $allowedFields = ['nombre', 'eliminado'];
    protected $useTimestamps = true;
    protected $updatedField = 'fecha_modificacion';
    protected $createdField = 'fecha_creacion';

    protected $validationRules = [
        'nombre' => 'required|min_length[4]',
    ];
    protected $validationMessages = [
        'nombre' => [
            'required' => 'Este campo es requerido',
            'min_length' => 'Minimo colocar 4 caracteres',
        ]
    ];

    //CONSULTA CUSTOMIZADA
    public function GetCertificados()
    {
        $builder = $this->db->table('certificado');
        $builder->select('nombre')->where('certificado.eliminado = 0');
        $query = $builder->get()->getResult();
        return $query;
    }
}