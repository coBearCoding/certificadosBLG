<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Logs as LogsModel;

class Log extends Controller
{
    public function index()
    {
    }

    public function getLogs()
    {
        $model = new LogsModel();
        $data = $model->GetAllLogs();
        if ($data != null) 
        {
            $json = $this->response->setStatusCode(200)->setJSON($data);
        } 
        else 
        {
            $json = $this->response->setStatusCode(404, "Detalle no Encontrado");
        }
        return $json;
    }

    public function addRol()
    {
        $data = [
            'rol' => $this->request->getVar('rol'),
        ];
        if ($data != null) 
        {
            $model = new LogsModel();
            $dataObtenida = array(
                'rol' => $data['rol'],
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
    public function actualizarRol($id)
    {
        $data = [
            'rol' => $this->request->getVar('rol'),
        ];
        if ($data != null) 
        {
            $model = new LogsModel();
            $dataObtenida = array(
                'rol' => $data['rol'],
            );
            if ($model->update($id, $dataObtenida) === false) 
            {
                $json = $this->response->setStatusCode(404)->setJSON($model->errors());
            } 
            else 
            {
                $json = $this->response->setStatusCode(200)->setJSON("Transaccion exitosa");
            }
        }
        else
        {
            $json = $this->response->setStatusCode(404, "Hubo un error");
        }
        return $json;
    }
    public function eliminarRol($id)
    {

        $model = new LogsModel();
        $dataObtenida = array(
            'eliminado' => 1,
        );
        if ($model->update($id, $dataObtenida) === false) 
        {
            $json = $this->response->setStatusCode(404)->setJSON($model->errors());
        } 
        else 
        {
            $json = $this->response->setStatusCode(200)->setJSON("Transaccion exitosa");
        }

        return $json;
    }
}
