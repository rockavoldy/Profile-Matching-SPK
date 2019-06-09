<?php

class ProfilModel extends CI_Model
{
    function getAspek()
    {
        $data = $this->db->get('tb_aspek');

        return $data->result_array();
    }

    function getKriteriaByAspek($id_aspek)
    {
        $this->db->where('id_aspek', $id_aspek);
        $data = $this->db->get('tb_factor');

        return $data->result_array();
    }

    function addNilai($data)
    {
        if ($this->db->insert('tb_nilai_factor', $data)) {
            return true;
        }

        return false;
    }

    function editNilai($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update('tb_nilai_factor', $data);
    }
}
