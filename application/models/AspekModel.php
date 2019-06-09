<?php

class AspekModel extends CI_Model
{
    function getAspek()
    {
        $data = $this->db->get('tb_aspek');

        return $data->result_array();
    }

    function getTotal()
    {
        $this->db->select('sum(persentase) as total_persentase');
        $sum = $this->db->get('tb_aspek');
        return $sum->row()->total_persentase;
    }

    function addAspek($data)
    {
        if ($this->db->insert('tb_aspek', $data)) {
            return $this->getTotal();
        }
    }

    function editAspek($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update('tb_aspek', $data);
    }

    function deleteAspek($id)
    {
        $this->db->where('id', $id);
        $response = $this->db->delete('tb_aspek');

        if ($response->affected_rows() > 0) {
            return true;
        }

        return false;
    }
}
