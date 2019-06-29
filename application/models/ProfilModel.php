<?php

class ProfilModel extends CI_Model
{
    function getSiswa()
    {
        // $this->db->select('tb_siswa.id as id_siswa, asal_sekolah, nisn, nama, tb_raw_factor.id as id_raw_factor');
        // $this->db->select('id_factor, raw_data');
        // $this->db->from('tb_siswa');
        // $this->db->join('tb_raw_factor', 'tb_siswa.id = tb_raw_factor.id_siswa', 'left');
        // $siswa = $this->db->get();
        $siswa = $this->db->get('tb_siswa');
        foreach ($siswa->result_array() as $sw) {
            $this->db->where('id_siswa', $sw['id']);
            $raw = $this->db->get('tb_raw_factor');
            $sw['nilai'] = $raw->result_array();

            $data[] = $sw;
        }

        return $data;
    }
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

    function getRaw()
    {
        // $this->db->where('id_factor', $id_factor);
        $data = $this->db->get('tb_raw_factor');
        // return $data->result_array();
        foreach ($data->result_array() as $raw) {
            $dat[$raw['id_siswa'] . '-raw-' . $raw['id_factor']] = $raw['raw_data'];
        };

        return $dat;
    }

    function rawNilai($data)
    {
        $this->db->where('id_siswa', $data['id_siswa']);
        $this->db->where('id_factor', $data['id_factor']);
        $exist = $this->db->get('tb_raw_factor');
        if ($exist->num_rows() > 0) {
            $this->db->where('id_siswa', $data['id_siswa']);
            $this->db->where('id_factor', $data['id_factor']);
            if ($this->db->update('tb_raw_factor', $data)) {
                $ret = true;
            } else {
                $ret = false;
            }
        } else {
            if ($this->db->insert('tb_raw_factor', $data)) {
                $ret = true;
            } else {
                $ret = false;
            }
        }

        return $ret;
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
