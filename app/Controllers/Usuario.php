<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Usuarios as UsuariosModel;
use App\Models\Logs as LogsModel;

class Usuario extends Controller
{
    public function index()
    {
    }

    public function getUsuarios()
    {
        $model = new UsuariosModel();
        $data = $model->GetAllUsuarios();
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
    public function getUsuarioRol()
    {
        $model = new UsuariosModel();
        $data = $model->GetUsuRol();
        if($data != null)
        {
            $json = $this->response->setStatusCode(200)->setJSON($data);
        }
        else
        {
            $json = $this->response->setStatusCode(404, 'Detalle No Encontrado');
        }
        return $json;
    }

    public function addUsuario()
    {
        $data = [
            'nombre' => $this->request->getVar('nombre'),
            'email' => $this->request->getVar('email'),
            'id_rol'=>$this->request->getVar('id_rol')
        ];
        if ($data != null) 
        { 
            $model = new UsuariosModel();
            $dataObtenida = array(
                'nombre' => $data['nombre'],
                'email' => $data['email'],
                'id_rol'=>$data['id_rol']
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
    public function actualizarUsuario($id)
    {
        $data = [
            'nombre' => $this->request->getVar('nombre'),
            'email' => $this->request->getVar('email'),
            'id_rol' => $this->request->getVar('id_rol')
        ];
        if($data != null)
        {
            $model = new UsuariosModel();
            $dataObtenida= array(
                'nombre'=> $data['nombre'],
                'email' => $data['email'],
                'id_rol' => $data['id_rol']
            );
            if($model->update($id,$dataObtenida) === false)
            {
                $json = $this->response->setStatusCode(404)->setJSON($model->errors());
            }
            else
            {
                $logmodel = new LogsModel();
                if($logmodel->InsertUsuarioLogs($id) === false)
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
    public function eliminarUsuario($id)
    {
        $model = new UsuariosModel();
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
            if($logmodel->InsertUsuarioLogs($id) === false)
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