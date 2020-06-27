<?php

namespace App\Models;


use CodeIgniter\Model;

class Logs extends Model
{
    protected $table = 'logs';
    protected $primaryKey = 'id_log';
    protected $allowedFields = ['id_usuario', 'id_certificado', 'id_roles', 'id_usu_cert'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';

    //CONSULTA CUSTOMIZADA DE LOGS
    public function GetAllLogs()
    {
        $builder = $this->db->table('logs');
        $builder->select('*');
        $builder->join('usuario', 'logs.id_usuario = usuario.id');
        $builder->join('certificado', 'logs.id_certificado = certificado.id_certificado');
        $builder->join('rol', 'logs.id_roles = rol.id_rol');
        $builder->join('usu_cert', 'logs.id_usu_cert = usu_cert.id_usu_cert');
        $query = $builder->get()->getResult();
        return $query;
    }

    public function InsertCertLogs($id)
    {
        $builder = $this->db->table('logs');

        $data = [
            'id_certificado' => $id,
            'id_usuario' => null,
            'id_roles' => null,
            'id_usu_cert' => null,
            'fecha_creacion' => time(),
        ];
        $builder->insert($data);
        return;
    }
    public function InsertUsuarioLogs($id)
    {
        $builder = $this->db->table('logs');
        $data = [
            'id_certificado' => null,
            'id_usuario' => $id,
            'id_roles' => null,
            'id_usu_cert' => null,
            'fecha_creacion' => time(),
        ];
        $builder->insert($data);
        return;
    }
    public function InsertRolesLogs($id)
    {
        $builder = $this->db->table('logs');

        $data = [
            'id_certificado' => null,
            'id_usuario' => null,
            'id_roles' => $id,
            'id_usu_cert' => null,
            'fecha_creacion' => time(),
        ];
        $builder->insert($data);
        return;
    }
    public function InsertUsuCertLogs($id)
    {
        $builder = $this->db->table('logs');
        $data = [
            'id_certificado' => null,
            'id_usuario' => null,
            'id_roles' => null,
            'id_usu_cert' => $id,
            'fecha_creacion' => time(),
        ];
        $builder->insert($data);
        return;
    }
}
