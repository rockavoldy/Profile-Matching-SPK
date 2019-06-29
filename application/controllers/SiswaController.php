<?php
require APPPATH . 'libraries/REST_Controller.php';

class SiswaController extends REST_Controller
{
    public function index_get($id_siswa = null)
    {
        if (!$id_siswa) {
            $data = $this->siswa->getSiswa();
        } else {
            $data = $this->siswa->getSiswaById($id_siswa);
        }

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

    public function index_post()
    {
        // $this->form_validation->set_rules('nisn', 'NISN', 'required', array('required' => '%s harus ada !'));
        // $this->form_validation->set_rules('nama', 'Nama', 'required', array('required' => '%s harus ada !'));
        // $this->form_validation->set_rules('asal_sekolah', 'Asal Sekolah', 'required', array('required' => '%s harus ada !'));

        // if ($this->form_validation->run() == FALSE) {
        //     $response = array(
        //         'status' => 403,
        //         'message' => 'NISN, Nama, dan Asal Sekolah harus diisi !',
        //         'error' => validation_errors()
        //     );
        // } else {
        $data = array(
            'nisn' => $this->post('nisn', true),
            'nama' => $this->post('nama', true),
            'asal_sekolah' => $this->post('asal_sekolah', true)
        );

        $response_post = $this->siswa->addSiswa($data);

        if ($response_post) {
            $response = array(
                'status' => 200,
                'message' => 'Berhasil menambahkan siswa !',
                'data' => $data
            );
        }
        // }


        $this->response($response, $response['status']);
    }

    function index_put($id_siswa)
    {
        $data = array(
            'nisn' => $this->put('nisn', true),
            'nama' => $this->put('nama', true),
            'asal_sekolah' => $this->put('asal_sekolah', true)
        );

        $response_post = $this->siswa->editSiswa($id_siswa, $data);

        if ($response_post) {
            $response = array(
                'status' => 200,
                'message' => 'Berhasil menambahkan siswa !',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 403,
                'message' => 'Gagal update data siswa !'
            );
        }

        $this->response($response, $response['status']);
    }

    function index_delete($id_siswa)
    {
        if ($this->siswa->deleteSiswa($id_siswa)) {
            $response = array(
                'status' => 200,
                'message' => 'Berhasil dihapus !'
            );
        } else {
            $response = array(
                'status' => 403,
                'message' => 'Gagal dihapus !'
            );
        }

        $this->response($response, $response['status']);
    }
}
