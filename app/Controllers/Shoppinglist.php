<?php

namespace App\Controllers;
use App\Models\ShoppingModel;

class ShoppingList extends BaseController
{
    public function __construct()
    {
        $this->ShoppingModel = new ShoppingModel();
    }

    public function index()
    {
        return view('shoppinglist');
    }

    public function ajaxtest()
    {
        return view('ajaxtest');
    }

    public function getList()
    {
        $data = $this->ShoppingModel->findAll();
        return $this->response->setJSON($data);
    }

    public function addItem()
    {
        $data = [
            'item' => $this->request->getPost('item'),
            'checkoff' => $this->request->getPost('checkoff'),
        ];
        
        $this->ShoppingModel->insert($data);
    }

    public function checkoff()
    {
        $id = $this->request->getPost('id');
        $checkoff = $this->request->getPost('checkoff');
        
        $this->ShoppingModel->set('checkoff', $checkoff)->where('id', $id)->update();
    }

    public function clear()
    {
        $this->ShoppingModel->emptyTable('shopping');
    }
}
