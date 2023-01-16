<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;

    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        helper(['form']);
        $model = new UserModel();
        $id = $this->request->getVar('id');
        $p = $this->request->getVar();

        $data = [];
        if (isset($p['fullname'])) {
            $data['fullname'] = $p['fullname'];
        }
        if (isset($p['username'])) {
            $data['username'] = $p['username'];
        }
        if (isset($p['age'])) {
            $data['age'] = $p['age'];
        }
        if (isset($p['gender'])) {
            $data['gender'] = $p['gender'];
        }
        if (isset($p['image'])) {
            $data['image'] = $p['image'];
        }

        $model->update($id, $data);
        
        $user  = $model->where('id_user', $id)->first();
        $response = [
            'error' => false,
        ];
        if (isset($user['fullname'])) {
            $response['fullname'] = $user['fullname'];
        }
        if (isset($user['username'])) {
            $response['username'] = $user['username'];
        }
        if (isset($user['age'])) {
            $response['age'] = $user['age'];
        }
        if (isset($user['gender'])) {
            $response['gender'] = $user['gender'];
        }
        if (isset($user['image'])) {
            $response['image'] = $user['image'];
        }
        
        return $this->respond($response);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        helper(['form']);
        $model = new UserModel();
        $id = $this->request->getVar('id');
        $p = $this->request->getVar();
        $user  = $model->where('id_user', $id)->first();
        $rules = [];
        $data = [];
        
        if (isset($p['email'])) {
            $rules['email'] = 'is_unique[users.email]';
            if(!$this->validate($rules)) {
                return $this->respond(['error' => 'email already registered']); 
            } else {
                $data['email'] = $p['email'];
                $model->update($id, $data);
            }
        }
        if (isset($p['phone'])) {
            $rules['phone'] = 'is_unique[users.phone]';
            if(!$this->validate($rules)) {
                return $this->respond(['error' => 'phone number already registered']); 
            } else {
                $data['phone'] = $p['phone'];
                $model->update($id, $data);
            }
        }
        if (isset($p['oldpass'])) {
            if($p['oldpass'] == $user['password'] ) {
                if($p['newpass'] == $p['confirmnewpass']) {
                    $data['password'] = $p['newpass'];
                    $model->update($id, $data);
                } else {
                    return $this->respond(['error' => 'new password and confirm new password does not match']);
                }
            } else {
                return $this->respond(['error' => 'old password is incorrect']);
            }
        }

        $response = [
            'error' => false,
        ];
        if (isset($p['email'])) {
            $response['email'] = $user['email'];
        }
        if (isset($p['phone'])) {
            $response['phone'] = $user['phone'];
        }
        if (isset($p['newpass'])) {
            $response['password'] = $user['password'];
        }
        
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
