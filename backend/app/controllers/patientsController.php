<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class PatientsController extends Controller
{
    public function beforeExecuteRoute()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', 'http://localhost:5173');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $this->response->setContentType('application/json');

        if ($this->request->getMethod() === 'OPTIONS') {
            $this->response->setStatusCode(204, 'No Content')->send();
            // Return false agar tidak lanjut ke action
            return false;
        }

        return true;
    }

    // GET /patients
    public function indexAction()
    {
        try {
            $patients = Patients::find();
            $response = [
                'status' => 'success',
                'data' => $patients->toArray()
            ];
            
            $this->response->setJsonContent($response);
            return $this->response;
        } catch (Exception $e) {
            $this->response->setStatusCode(500);
            $this->response->setJsonContent([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            return $this->response;
        }
    }

    // GET /patients/{id}
    public function showAction($id)
    {
        try {
            $patient = Patients::findFirst($id);
            
            if (!$patient) {
                $this->response->setStatusCode(404);
                $this->response->setJsonContent([
                    'status' => 'error',
                    'message' => 'Patient not found'
                ]);
                return $this->response;
            }

            $response = [
                'status' => 'success',
                'data' => $patient->toArray()
            ];
            
            $this->response->setJsonContent($response);
            return $this->response;
        } catch (Exception $e) {
            $this->response->setStatusCode(500);
            $this->response->setJsonContent([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            return $this->response;
        }
    }

    // POST /patients
    public function createAction()
    {
        try {
            $data = $this->request->getJsonRawBody();
            
            $patient = new Patients();
            $patient->name = $data->name;
            $patient->sex = $data->sex;
            $patient->religion = $data->religion ?? null;
            $patient->phone = $data->phone ?? null;
            $patient->address = $data->address ?? null;
            $patient->nik = $data->nik;

            if ($patient->save()) {
                $this->response->setStatusCode(201);
                $this->response->setJsonContent([
                    'status' => 'success',
                    'message' => 'Patient created successfully',
                    'data' => $patient->toArray()
                ]);
            } else {
                $this->response->setStatusCode(400);
                $errors = [];
                foreach ($patient->getMessages() as $message) {
                    $errors[] = $message->getMessage();
                }
                $this->response->setJsonContent([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $errors
                ]);
            }
            
            return $this->response;
        } catch (Exception $e) {
            $this->response->setStatusCode(500);
            $this->response->setJsonContent([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            return $this->response;
        }
    }

    // PUT /patients/{id}
    public function updateAction($id)
    {
        try {
            $patient = Patients::findFirst($id);
            
            if (!$patient) {
                $this->response->setStatusCode(404);
                $this->response->setJsonContent([
                    'status' => 'error',
                    'message' => 'Patient not found'
                ]);
                return $this->response;
            }

            $data = $this->request->getJsonRawBody();
            
            $patient->name = $data->name ?? $patient->name;
            $patient->sex = $data->sex ?? $patient->sex;
            $patient->religion = $data->religion ?? $patient->religion;
            $patient->phone = $data->phone ?? $patient->phone;
            $patient->address = $data->address ?? $patient->address;
            $patient->nik = $data->nik ?? $patient->nik;

            if ($patient->save()) {
                $this->response->setJsonContent([
                    'status' => 'success',
                    'message' => 'Patient updated successfully',
                    'data' => $patient->toArray()
                ]);
            } else {
                $this->response->setStatusCode(400);
                $errors = [];
                foreach ($patient->getMessages() as $message) {
                    $errors[] = $message->getMessage();
                }
                $this->response->setJsonContent([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $errors
                ]);
            }
            
            return $this->response;
        } catch (Exception $e) {
            $this->response->setStatusCode(500);
            $this->response->setJsonContent([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            return $this->response;
        }
    }

    // DELETE /patients/{id}
    public function deleteAction($id)
    {
        try {
            $patient = Patients::findFirst($id);
            
            if (!$patient) {
                $this->response->setStatusCode(404);
                $this->response->setJsonContent([
                    'status' => 'error',
                    'message' => 'Patient not found'
                ]);
                return $this->response;
            }

            if ($patient->delete()) {
                $this->response->setJsonContent([
                    'status' => 'success',
                    'message' => 'Patient deleted successfully'
                ]);
            } else {
                $this->response->setStatusCode(500);
                $this->response->setJsonContent([
                    'status' => 'error',
                    'message' => 'Failed to delete patient'
                ]);
            }
            
            return $this->response;
        } catch (Exception $e) {
            $this->response->setStatusCode(500);
            $this->response->setJsonContent([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            return $this->response;
        }
    }
}