<?php
require APPPATH . 'libraries/REST_Controller.php';

class KriteriaController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('KriteriaModel');
    }

    public function index_get($id_aspek = null)
    {
        if ($id_aspek) {
            $data = $this->KriteriaModel->getKriteriaById($id_aspek);

            if ($data) {
                $response = array(
                    'status' => 200,
                    'data' => array(
                        'text' => $data['deskripsi'],
                        'value' => $data['id']
                    ),
                );
            }
        } else {
            $data = $this->KriteriaModel->getKriteria();

            if ($data) {
                $response = array(
                    'status' => 200,
                    'data' => $data,
                );
            }
            // else {
            //     $response = array(
            //         'status' => 403,
            //         'message' => 'Belum ada kriteria yang tersedia !'
            //     );
            // }
        }

        $this->response($response, $response['status']);
    }

    public function index_post()
    {
        $data = array(
            'id_aspek' => $this->post('id_aspek', true),
            'jenis' => $this->post('jenis', true),
            'deskripsi' => $this->post('deskripsi', true),
            'nilai' => $this->post('nilai', true)
        );

        $response_post = $this->KriteriaModel->addKriteria($data);

        if ($response_post) {
            $response = array(
                'status' => 200,
                'message' => 'Berhasil menambahkan Kriteria !',
                'data' => $data
            );
        }


        $this->response($response, $response['status']);
    }

    public function index_put($id)
    {
        $data = array(
            'id_aspek' => $this->put('id_aspek', true),
            'jenis' => $this->put('jenis', true),
            'deskripsi' => $this->put('deskripsi', true),
            'nilai' => $this->put('nilai', true)
        );

        $response_post = $this->KriteriaModel->editKriteria($id, $data);

        if ($response_post) {
            $response = array(
                'status' => 200,
                'message' => 'Berhasil merubah Kriteria !',
                'data' => $data
            );
        }


        $this->response($response, $response['status']);
    }

    public function index_delete($id)
    {
        if ($this->KriteriaModel->deleteKriteria($id)) {
            $response = array(
                'status' => 200,
                'message' => 'Berhasil menghapus Kriteria !'
            );
        }

        $this->response($response, $response['status']);
    }
}
