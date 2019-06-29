<?php
class HitungModel extends CI_Model
{
    function getRaw()
    {
        $data = $this->db->get('tb_raw_factor');
        return $data->result_array();
    }

    function getMinMaxRaw()
    {
        $this->db->select('id_factor, min(raw_data) as min_raw, max(raw_data) as max_raw');
        $this->db->select('(max(raw_data) - min(raw_data)) as jangkauan');
        $this->db->select('((max(raw_data) - min(raw_data))/9) as int_kelas');
        $this->db->from('tb_raw_factor');
        $this->db->group_by('id_factor');
        $data = $this->db->get();
        return $data->result_array();
    }

    function getNilai()
    {
        $this->db->select('tb_nilai_factor.id_factor, tb_nilai_factor.id_siswa, tb_factor.id_aspek, tb_nilai_factor.nilai');
        $this->db->select('tb_factor.nilai as nilai_factor');
        $this->db->from('tb_nilai_factor');
        $this->db->join('tb_factor', 'tb_factor.id = tb_nilai_factor.id_factor', 'left');
        $data = $this->db->get();
        return $data->result_array();
    }

    function addNilaiFactor($data)
    {
        $this->db->empty_table('tb_nilai_factor');
        if ($this->db->insert_batch('tb_nilai_factor', $data)) {
            return true;
        }
        return false;
    }

    function addGapNilaiFactor($data)
    {
        $this->db->empty_table('tb_gap_nilai_factor');
        if ($this->db->insert_batch('tb_gap_nilai_factor', $data)) {
            return true;
        }
        return false;
    }

    function getAspek()
    {
        $this->db->select('id_siswa');
        $this->db->group_by('id_siswa');
        $siswa = $this->db->get('tb_gap_nilai_factor');
        $data_siswa = $siswa->result_array();

        foreach ($data_siswa as $sw) {
            $this->db->select('tb_aspek.id as id_aspek, tb_aspek.persentase');
            $this->db->from('tb_gap_nilai_factor');
            $this->db->join('tb_factor', 'tb_gap_nilai_factor.id_factor = tb_factor.id', 'left');
            $this->db->join('tb_aspek', 'tb_factor.id_aspek = tb_aspek.id', 'left');
            $this->db->where('id_siswa', $sw['id_siswa']);
            $this->db->group_by('tb_aspek.id');
            $aspek = $this->db->get();
            $data_aspek = $aspek->result_array();
            $ds = $data_aspek;

            foreach ($ds as $da) {
                $this->db->select('id_factor, jenis, bobot');
                $this->db->from('tb_gap_nilai_factor');
                $this->db->join('tb_factor', 'tb_gap_nilai_factor.id_factor = tb_factor.id', 'left');
                $this->db->join('tb_aspek', 'tb_factor.id_aspek = tb_aspek.id', 'left');
                $this->db->where('id_siswa', $sw['id_siswa']);
                $this->db->where('id_aspek', $da['id_aspek']);
                $factor = $this->db->get();
                $data_factor = $factor->result_array();

                // $data_factor['id_aspek'] = $da['id'];
                $da['data'] = $data_factor;
                // $data_aspek['data'] = $data_aspek;
                // $data_factor['data'] = $data_factor;
                $dataa[] = array(
                    'id_siswa' => $sw['id_siswa'],
                    'data' => $da
                );
            }
        }


        // return $data->result_array();
        return $dataa;
    }
}
