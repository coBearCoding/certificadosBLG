<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Certificados as CertificadosModel;
use App\Models\Logs as LogsModel;

//use CodeIgniter\HTTP\Request as request;

class Certificado extends Controller
{
    public function index()
    {
    }

    public function getCertificados()
    {
        $model = new CertificadosModel();

        $data = $model->GetCertificados();
       
        if ($data != null) 
        {
            $json = $this->response->setStatusCode(200)->setJSON($data);
        } 
        else 
        {
            $json = $this->response->setStatusCode(404, 'Detalle No Encontrado');
        }
        return $json;
    }
    //--------------------------------------------------------------------
    public function addCertificado()
    {
        //INSERTAR DATOS DESDE CLIENTE
        $data = [
           'nombre' => $this->request->getVar('nombre'),
        ];
        if ($data != null) 
        { 
            $model = new CertificadosModel();
            $dataObtenida = array(
                'nombre' => $data['nombre'],
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

    public function actualizarCertificado($id)
    {
        $data = [
            'nombre' => $this->request->getVar('nombre'),
        ];
        if($data != null)
        {
            $model = new CertificadosModel();
            $dataObtenida= array(
                'nombre'=> $data['nombre'],
            );
            if($model->update($id,$dataObtenida) === false)
            {
                $json = $this->response->setStatusCode(404)->setJSON($model->errors());
            }
            else
            {
                $logmodel = new LogsModel();
                if($logmodel->InsertCertLogs($id) === false)
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

    public function eliminarCertificado($id)
    {
        $model = new CertificadosModel();
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
            if($logmodel->InsertCertLogs($id) === false)
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
