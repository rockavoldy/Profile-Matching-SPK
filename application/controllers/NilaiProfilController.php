<?php
require APPPATH . 'libraries/REST_Controller.php';

class NilaiProfilController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProfilModel');
    }

    public function index_get($id_aspek = 0)
    {
        $data = $this->ProfilModel->getKriteriaByAspek($id_aspek);

        if ($data) {
            $response = array(
                'status' => 200,
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 403,
                'message' => 'Tidak ada data nilai !'
            );
        }

        $this->response($response, $response['status']);
    }

    public function aspek_get()
    {
        $data = $this->ProfilModel->getAspek();

        if ($data) {
            $response = array(
                'status' => 200,
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 403,
                'message' => 'Tidak ada data aspek !'
            );
        }

        $this->response($response, $response['status']);
    }

    public function index_post()
    {
        $this->form_validation->set_rules('id_siswa', 'Siswa', 'required', array('required' => '%s harus ada !'));
        $this->form_validation->set_rules('id_factor', 'Kriteria harus ada', 'required', array('required' => '%s harus ada !'));

        if ($this->form_validation->run()) {
            $data = array(
                'id_siswa' => $this->post('id_siswa', true),
                'id_factor' => $this->post('id_factor', true),
                'nilai' => $this->post('nilai', true)
            );

            $response_post = $this->ProfilModel->addNilai($data);

            if ($response_post) {
                $response = array(
                    'status' => 200,
                    'message' => 'Berhasil menambahkan nilai !',
                    'data' => $data,
                    'total_persentase' => $response_post
                );
            }
        } else {
            $response = array(
                'status' => 403,
                'message' => 'Nilai harus diisi !'
            );
        }

        $this->response($response, $response['status']);
    }
}
