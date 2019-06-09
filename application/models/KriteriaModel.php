<?php

class KriteriaModel extends CI_Model
{
    function getKriteria()
    {
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

        if ($response->affected_rows() > 0) {
            return true;
        }

        return false;
    }
}
