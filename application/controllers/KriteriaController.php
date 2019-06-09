<?php
require APPPATH . 'libraries/REST_Controller.php';

class KriteriaController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('KriteriaModel');
    }

    public function index_get()
    {
        $data = $this->KriteriaModel->getKriteria();

        if ($data) {
            $response = array(
                'status' => 200,
                'data' => $data,
            );
        } else {
            $response = array(
                'status' => 403,
                'message' => 'Belum ada kriteria yang tersedia !'
            );
        }

        $this->response($response, $response['status']);
    }

    public function index_post()
    {
        $this->form_validation->set_rules('id_aspek', 'Aspek', 'required', array('required' => '%s harus ada !'));
        $this->form_validation->set_rules('jenis', 'Jenis kriteria', 'required', array('required' => '%s harus utama atau pendukung !'));
        $this->form_validation->set_rules('deskripsi', 'Nama Kriteria', 'required', array('required' => '%s harus ada !'));
        $this->form_validation->set_rules('nilai', 'Nilai kriteria', 'required', array('required' => '%s harus ada !'));

        if ($this->form_validation->run()) {
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
        } else {
            $response = array(
                'status' => 403,
                'message' => 'Mohon untuk di cek kembali !'
            );
        }


        $this->response($response, $response['status']);
    }
}
