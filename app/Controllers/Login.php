<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
// use Firebase\JWT\JWT;
use App\Libraries\JWTCI4;

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        helper(['form']);
        // $rules = [
        //     'email' => 'required|valid_email',
        //     'password' => 'required|min_length[6]'
        // ];
        // if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        // $model = new UserModel();
        // $user = $model->where("email", $this->request->getVar('email'))->first();
        // if (!$user) return $this->failNotFound('Email Not Found');

        // $verify = password_verify($this->request->getVar('password'), $user['password']);
        // if (!$verify) return $this->fail('Wrong Password');

        // $key = getenv('TOKEN_SECRET');
        // $payload = array(
        //     "iat" => 1356999524,
        //     "nbf" => 1357000000,
        //     "uid" => $user['id_user'],
        //     "email" => $user['email']
        // );

        // $token = JWT::encode($payload, $key);

        // return $this->respond($token);

        if (!$this->validate([
            // 'email' => 'required|valid_email',
            'username' => 'required',
            'password' => 'required|min_length[6]'
        ])) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new UserModel();
        $user  = $model->where('username', $this->request->getVar('username'))->first();
        if ($user) {
            if ( password_verify($this->request->getVar('password'), $user['password']) ) {
                $jwt = new JWTCI4;
                $token = $jwt->token();
                return $this->response->setJSON([
                    'token' => $token,
                    'idid' => intval($user['id_user']),
                    'fullname' => $user['fullname'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'password' => $user['password'],
                    'gender' => $user['gender'],
                    'age' => intval($user['age']),
                    'role' => $user['role'],
                ]);
            } else {
                return $this->fail('Wrong Password');
            }
        } else {
            return $this->failNotFound('User Not Found');
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
        //
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
