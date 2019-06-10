<?php

class KriteriaModel extends CI_Model
{
    function getKriteria()
    {
        $this->db->select('tb_aspek.id as id_aspek, tb_factor.id, tb_aspek.nama, deskripsi, jenis, tb_factor.nilai');
        $this->db->from('tb_factor');
        $this->db->join('tb_aspek', 'tb_aspek.id = tb_factor.id_aspek', 'left');
        $data = $this->db->get();

        return $data->result_array();
    }

    function getKriteriaById($id)
    {
        // $this->db->select('tb_aspek.id as id_aspek, tb_factor.id, tb_aspek.nama, deskripsi, jenis, tb_factor.nilai');
        // $this->db->from('tb_factor');
        // $this->db->join('tb_aspek', 'tb_aspek.id = tb_factor.id_aspek', 'left');
        $this->db->where('id_aspek', $id);
        $data = $this->db->get('tb_factor');

        return $data->result_array();
    }

    function addKriteria($data)
    {
        return $this->db->insert('tb_factor', $data);
    }

    function editKriteria($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update('tb_factor', $data);
    }

    function deleteKriteria($id)
    {
        $this->db->where('id', $id);
        $response = $this->db->delete('tb_factor');

        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return false;
    }
}
