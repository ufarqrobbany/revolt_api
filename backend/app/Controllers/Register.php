<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TemporaryUserModel;
use App\Models\UserModel;

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
            'email' => 'required|valid_email|is_unique[users.email]',
            'phone' => 'required|min_length[8]|is_unique[users.phone]|numeric',
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $data = [
            'email'     => $this->request->getVar('email'),
            'phone'     => $this->request->getVar('phone'),
        ];
        $model = new TemporaryUserModel();
        $registered = $model->save($data);
        $this->respondCreated($registered);
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
            'fullname'      => 'required|alpha',
            'username'      => 'required|min_length[6]|alpha_dash',
            'email'         => 'required',
            'phone'         => 'required',
            'password'      => 'required',
            'confirmpass'   => 'required|matches[password]',
            'gender'        => 'required|in_list[Male,Female]',
            'age'           => 'required|is_natural_no_zero',
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
        ];
        $model = new UserModel();
        $registered = $model->save($data);
        $this->respondCreated($registered);
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
