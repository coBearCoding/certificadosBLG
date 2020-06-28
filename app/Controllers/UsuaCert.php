<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UsuaCerts as UsuaCertModel;
use App\Models\Logs as LogsModel;

class UsuaCert extends Controller
{
    public function index()
    {
    }
    public function getUsuaCerts()
    {
        $model = new UsuaCertModel();
        $data = $model->GetAllUsuaCerts();
        if($data != null)
        {
            $json = $this->response->setStatusCode(200)->setJSON($data);
        }
        else
        {
            $json = $this->response->setStatusCode(404, "Detalle no Encontrado");
        }
        return $json;
    }

    public function addUsuaCert()
    {
        $data = [
            'id_usuario' => $this->request->getVar('id_usuario'),
            'id_certificado' => $this->request->getVar('id_certificado'),
            'fecha_certificado'=>$this->request->getVar('fecha_certificado')
        ];
        if ($data != null) 
        { 
            $model = new UsuaCertModel();
            $dataObtenida = array(
                'id_usuario' => $data['id_usuario'],
                'id_certificado' => $data['id_certificado'],
                'fecha_certificado'=>$data['fecha_certificado']
            );
            if ($model->insert($dataObtenida) === false) 
            {
                $json = $this->response->setStatusCode(400)->setJSON($model->errors());
            } 
            else 
            {
                $json = $this->response->setStatusCode(200)->setJSON("Transaccion exitosa");   
            }
        }
        else
        {
            $json = $this->response->setStatusCode(404, "Ocurrio un error");
        }
        return $json;
    }
    public function actualizarUsuaCert($id)
    {
        $data = [
            'id_usuario' => $this->request->getVar('id_usuario'),
            'id_certificado' => $this->request->getVar('id_certificado'),
            'fecha_certificado' => $this->request->getVar('fecha_certificado')
        ];
        if($data != null)
        {
            $model = new UsuaCertModel();
            $dataObtenida= array(
                'id_usuario'=> $data['id_usuario'],
                'id_certificado' => $data['id_certificado'],
                'fecha_certificado' => $data['fecha_certificado']
            );
            if($model->update($id,$dataObtenida) === false)
            {
                $json = $this->response->setStatusCode(404)->setJSON($model->errors());
            }
            else
            {
                $logmodel = new LogsModel();
                if($logmodel->InsertUsuCertLogs($id) === false)
                {
                    $json = $this->response->setStatusCode(404, "Error al guardar log");
                }
                else
                {
                    $json= $this->response->setStatusCode(200)->setJSON("Transaccion exitosa");
                }
            }
        }
        else
        {
            $json = $this->response->setStatusCode(404, "Hubo un error");
        }
        return $json;
    }
    public function eliminarUsuaCert($id)
    {
    
        $model = new UsuaCertModel();
        $dataObtenida = array(
            'eliminado' => 1,
        );
        if($model->update($id,$dataObtenida) === false)
        {
            $json = $this->response->setStatusCode(404)->setJSON($model->errors());
        }
        else
        {
            $logmodel = new LogsModel();
            if($logmodel->InsertUsuCertLogs($id) === false)
            {
                $json = $this->response->setStatusCode(404, "Error al guardar log");
            }
            else
            {
                $json= $this->response->setStatusCode(200)->setJSON("Transaccion exitosa");
            }
        }
    
        return $json;
    }
}