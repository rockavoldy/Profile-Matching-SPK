<?php
require APPPATH . 'libraries/REST_Controller.php';

class NilaiProfilController extends REST_Controller
{

    public function siswa_get()
    {
        $data = $this->profil->getSiswa();

        if ($data) {
            $response = array(
                'status' => 200,
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 403,
                'message' => 'Tidak ada siswa terdaftar !'
            );
        }

        $this->response($response, $response['status']);
    }

    public function index_get($id_aspek = null)
    {
        $data = $this->profil->getKriteriaByAspek($id_aspek);

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
        $data = $this->profil->getAspek();

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

    public function raw_get()
    {
        $data = $this->profil->getRaw();

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

    public function raw_post()
    {

        $data = $this->post();
        // $data = array(
        //     'id_siswa' => $this->post('id_siswa', true),
        //     'id_factor' => $this->post('id_kriteria', true),
        //     'raw_data' => $this->post('raw', true)
        // );

        $response_post = $this->profil->rawNilai($data);

        if ($response_post) {
            $response = array(
                'status' => 200,
                'message' => 'Berhasil menambahkan nilai !',
                'data' => $data,
                'total_persentase' => $response_post
            );
        }


        $this->response($response, $response['status']);
    }

    public function index_post()
    {
        $data = array(
            'id_siswa' => $this->post('id_siswa', true),
            'id_factor' => $this->post('id_factor', true),
            'nilai' => $this->post('nilai', true)
        );

        $response_post = $this->profil->addNilai($data);

        if ($response_post) {
            $response = array(
                'status' => 200,
                'message' => 'Berhasil menambahkan nilai !',
                'data' => $data,
                'total_persentase' => $response_post
            );
        }


        $this->response($response, $response['status']);
    }
}
