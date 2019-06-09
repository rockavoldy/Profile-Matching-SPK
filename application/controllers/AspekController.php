<?php
require APPPATH . 'libraries/REST_Controller.php';

class AspekController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('AspekModel');
    }

    public function index_get()
    {
        $data = $this->AspekModel->getAspek();

        if ($data) {
            $total = $this->AspekModel->getTotal();
            $response = array(
                'status' => 200,
                'data' => $data,
                'total_persentase' => $total
            );
        } else {
            $response = array(
                'status' => 403,
                'message' => 'Belum ada aspek yang ditambahkan !'
            );
        }

        $this->response($response, $response['status']);
    }

    public function index_post()
    {
        $this->form_validation->set_rules('nama', 'Nama aspek', 'required', array('required' => '%s harus ada !'));
        $this->form_validation->set_rules('persentase', 'Persentase urgensi', 'required', array('required' => '%s harus ada !'));

        if ($this->form_validation->run()) {
            $data = array(
                'nama' => $this->post('nama', true),
                'persentase' => $this->post('persentase', true)
            );

            $response_post = $this->AspekModel->addAspek($data);

            if ($response_post) {
                $response = array(
                    'status' => 200,
                    'message' => 'Berhasil menambahkan aspek !',
                    'data' => $data,
                    'total_persentase' => $response_post
                );
            }
        } else {
            $response = array(
                'status' => 403,
                'message' => 'Nama aspek, Persentase urgensi harus ada !'
            );
        }


        $this->response($response, $response['status']);
    }
}
