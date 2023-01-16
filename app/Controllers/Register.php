<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TemporaryUserModel;
use App\Models\UserModel;
// use Firebase\JWT\JWT;
use App\Libraries\JWTCI4;

class Register extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        helper(['form']);
        
        $rules = [
            'email' => 'required|is_unique[users.email]',
            'phone' => 'required|is_unique[users.phone]',
        ];
        
        if(!$this->validate($rules)) {
            return $this->respond(['error' => 'email or phone number already registered']);
        } else {
           $data = [
                'email'     => $this->request->getVar('email'),
                'phone'     => $this->request->getVar('phone'),
            ];
            $model = new TemporaryUserModel();
            $model->save($data);
            $response = [
                'error' => false,
            ];
            // $response = 'yes';
            return $this->respondCreated($response);
        } 
        
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
        helper(['form']);
        $rules = [
            'fullname'          => 'required',
            'username'          => 'required|min_length[6]|alpha_dash',
            'email'             => 'required',
            'phone'             => 'required',
            'password'          => 'required',
            'confirmpass'       => 'required|matches[password]',
            'gender'            => 'required|in_list[Male,Female]',
            'age'               => 'required|is_natural_no_zero',
            'role'              => 'required|in_list[Customer,Marketer,Manager]',
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $data = [
            'fullname'     => $this->request->getVar('fullname'),
            'username'     => $this->request->getVar('username'),
            'email'        => $this->request->getVar('email'),
            'phone'        => $this->request->getVar('phone'),
            'password'     => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'gender'        => $this->request->getVar('gender'),
            'age'        => $this->request->getVar('age'),
            'role'        => $this->request->getVar('role'),
        ];
        $model = new UserModel();
        $model->save($data);
        $last_insert_id = $model->getInsertID();
        $user  = $model->where('id_user', $last_insert_id)->first();
        $jwt = new JWTCI4;
        $token = $jwt->token();
        $response = [
            'error' => false,
            'idid' => $last_insert_id,
            'fullname' => $user['fullname'],
            'username' => $user['username'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'password' => $user['password'],
            'gender' => $user['gender'],
            'age' => intval($user['age']),
            'role' => $user['role'],
            'token' => $token,
            
        ];
        // $response = false;
        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
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
