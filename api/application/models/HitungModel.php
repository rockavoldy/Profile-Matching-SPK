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
        $this->db->truncate('tb_nilai_factor');
        if ($this->db->insert_batch('tb_nilai_factor', $data)) {
            return true;
        }
        return false;
    }

    function addGapNilaiFactor($data)
    {
        $this->db->truncate('tb_gap_nilai_factor');
        if ($this->db->insert_batch('tb_gap_nilai_factor', $data)) {
            return true;
        }
        return false;
    }

    function addNilaiAspek($data)
    {
        $this->db->truncate('tb_nilai_aspek');
        if ($this->db->insert_batch('tb_nilai_aspek', $data)) {
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
            $data = null;
            $data_aspek = null;
            $data_factor = null;
            $da = null;

            $this->db->select('tb_aspek.id as id_aspek, tb_aspek.persentase');
            $this->db->from('tb_gap_nilai_factor');
            $this->db->join('tb_factor', 'tb_gap_nilai_factor.id_factor = tb_factor.id', 'left');
            $this->db->join('tb_aspek', 'tb_factor.id_aspek = tb_aspek.id', 'left');
            $this->db->where('id_siswa', $sw['id_siswa']);
            $this->db->group_by('tb_aspek.id');
            $aspek = $this->db->get();
            $data_aspek = $aspek->result_array();

            foreach ($data_aspek as $da) {
                $this->db->select('id_factor, jenis, bobot');
                $this->db->from('tb_gap_nilai_factor');
                $this->db->join('tb_factor', 'tb_gap_nilai_factor.id_factor = tb_factor.id', 'left');
                $this->db->join('tb_aspek', 'tb_factor.id_aspek = tb_aspek.id', 'left');
                $this->db->where('id_siswa', $sw['id_siswa']);
                $this->db->where('id_aspek', $da['id_aspek']);
                $factor = $this->db->get();
                $data_factor = $factor->result_array();

                $da['data'] = $data_factor;
                $data[] = $da;
            }

            $dataa[] = array(
                'id_siswa' => $sw['id_siswa'],
                'data' => $data
            );
        }

        // return $data->result_array();
        return $dataa;
    }

    function getHitung()
    {
        $this->db->select('id, nama, persentase');
        $this->db->order_by('id');
        $aspek = $this->db->get('tb_aspek');
        $head[] = array(
            'text' => 'Siswa',
            'value' => 'siswa'
        );
        foreach ($aspek->result_array() as $data_aspek) {
            $head[] = array(
                'text' => $data_aspek['nama'] . " (" . $data_aspek['persentase'] . "%)",
                'value' => $data_aspek['id']
            );
        }
        $head[] = array(
            'text' => 'Total',
            'sortable' => true,
            'value' => 'total'
        );

        $this->db->select('id, nisn, nama');
        $siswa = $this->db->get('tb_siswa');
        foreach ($siswa->result_array() as $sw) {
            $this->db->select('id_aspek, nilai, ((persentase / 100) * nilai) as hasil');
            $this->db->from('tb_aspek');
            $this->db->join('tb_nilai_aspek', 'tb_aspek.id = tb_nilai_aspek.id_aspek', 'left');
            $this->db->where('id_siswa', $sw['id']);
            $this->db->order_by('id_aspek');
            $aspek = $this->db->get();
            $sw['data'] = $aspek->result_array();
            $data['siswa'][] = $sw;
        }

        $data['head'] = $head;

        return $data;
    }
}
