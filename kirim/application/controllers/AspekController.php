<?php
require APPPATH . 'libraries/REST_Controller.php';

class AspekController extends REST_Controller
{
    public function index_get()
    {
        $data = $this->aspek->getAspek();

        if ($data) {
            $total = $this->aspek->getTotal();
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
        // $this->form_validation->set_rules('nama', 'Nama aspek', 'required', array('required' => '%s harus ada !'));
        // $this->form_validation->set_rules('persentase', 'Persentase urgensi', 'required', array('required' => '%s harus ada !'));

        // if ($this->form_validation->run()) {
        $data = array(
            'nama' => $this->post('nama', true),
            'persentase' => $this->post('persentase', true)
        );

        $response_post = $this->aspek->addAspek($data);

        if ($response_post) {
            $response = array(
                'status' => 200,
                'message' => 'Berhasil menambahkan aspek !',
                'data' => $data,
                'total_persentase' => $response_post
            );
        }
        // } else {
        //     $response = array(
        //         'status' => 403,
        //         'message' => 'Nama aspek, Persentase urgensi harus ada !'
        //     );
        // }


        $this->response($response, $response['status']);
    }
    function index_put($id_aspek)
    {
        $data = array(
            'nama' => $this->put('nama', true),
            'persentase' => $this->put('persentase', true)
        );

        $response_post = $this->aspek->editAspek($id_aspek, $data);

        if ($response_post) {
            $response = array(
                'status' => 200,
                'message' => 'Berhasil mengubah aspek !',
                'data' => $data,
                'total_persentase' => $response_post
            );
        }

        $this->response($response, $response['status']);
    }

    function index_delete($id_aspek)
    {
        if ($this->aspek->deleteAspek($id_aspek)) {
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
