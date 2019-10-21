<?php  

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mhs');
    }

    // Get
    public function index_get()
    {
        $id = $this->get('id');

        if ($id === null) {
            $mahasiswa = $this->mhs->getMahasiswa();
        }else{
            $mahasiswa = $this->mhs->getMahasiswa($id);
        }

        if ($mahasiswa) {
            $this->response([
                'status'    => true,
                'data'      => $mahasiswa
            ], REST_Controller::HTTP_OK);
        }else {
            $this->response([
                'status'    => false,
                'message'   => 'id tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // Delete
    public function index_delete()
    {
        $id = $this->delete('id');
        $delMahasiswa = $this->mhs->deleteMahasiswa($id);
        if ($id === null) {
            $this->response([
                'status'    => false,
                'message'   => 'id tidak boleh kosong'
            ], REST_Controller::HTTP_NOT_FOUND);
        }else {
            if ($delMahasiswa > 0) {
                $this->response([
                    'status'    => true,
                    'id'        => $id,
                    'message'      => 'id terhapus'
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status'    => false,
                    'message'   => 'id tidak ditemukan'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    // create
    public function index_post()
    {   
        $data = array(
            'nrp'       => $this->post('nrp'),
            'nama'      => $this->post('nama'),
            'email'     => $this->post('email'),
            'jurusan'   => $this->post('jurusan'), 
        );
        $createMahasiswa = $this->mhs->createMahasiswa($data);
        if ($createMahasiswa > 0) {
            $this->response([
                'status'    => true,
                'message'   => 'data baru tersimpan'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status'    => false,
                'message'   => 'data tidak tersimpan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }

    // update
    public function index_put()
    {   
        $id = $this->put('id');
        $data = array(
            'nrp'       => $this->put('nrp'),
            'nama'      => $this->put('nama'),
            'email'     => $this->put('email'),
            'jurusan'   => $this->put('jurusan'), 
        );
        $createMahasiswa = $this->mhs->updateMahasiswa($data, $id);
        if ($createMahasiswa > 0) {
            $this->response([
                'status'    => true,
                'message'   => 'data terubah'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status'    => false,
                'message'   => 'data tidak terubah'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }

}

?>