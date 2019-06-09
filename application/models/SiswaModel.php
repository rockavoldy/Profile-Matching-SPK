<?php

class SiswaModel extends CI_Model
{
    function getSiswa()
    {
        $data = $this->db->get('tb_siswa');

        return $data->result_array();
    }

    function addSiswa($data)
    {
        return $this->db->insert('tb_siswa', $data);
    }

    function editSiswa($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update('tb_siswa', $data);
    }

    function deleteSiswa($id)
    {
        $this->db->where('id', $id);
        $response = $this->db->delete('tb_siswa');

        if ($response->affected_rows() > 0) {
            return true;
        }

        return false;
    }
}
