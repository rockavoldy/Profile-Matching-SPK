<?php
require APPPATH . 'libraries/REST_Controller.php';

class HitungController extends REST_Controller
{
    public function index_get()
    {
        // penyederhanaan nilai input user
        $data = $this->getHitung();
        if ($data) {
            $response = array(
                'status' => 200,
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 403,
                // 'message' => 'Belum ada aspek yang ditambahkan !'
            );
        }

        $this->response($response, $response['status']);
    }

    private function getDataKelas()
    {
        $data = $this->hitung->getMinMaxRaw();
        if ($data) {
            foreach ($data as $dat) {
                $dat['int_kelas'] = (int) $dat['int_kelas'];
                $dat['jangkauan'] = (int) $dat['jangkauan'];
                $dat['min_raw'] = (int) $dat['min_raw'];
                $dat['max_raw'] = (int) $dat['max_raw'];
                for ($i = 1; $i <= 9; $i++) {
                    if ($i == 1) {
                        $dat['kelas' . $i] = $dat['min_raw'] + $dat['int_kelas'];
                    } else {
                        $dat['kelas' . $i] = ($dat['kelas' . ($i - 1)] + 1) + $dat['int_kelas'];
                    }
                }
                $dataa[] = $dat;
            }
            return $dataa;
        } else {
            return false;
        }
    }

    private function setNilaiKriteria()
    {
        $data_raw = $this->hitung->getRaw();
        $data = $this->getDataKelas();
        $nilai = 0;

        foreach ($data as $kelas) {
            foreach ($data_raw as $raw) {
                $raw['raw_data'] = (int) $raw['raw_data'];
                if ($raw['id_factor'] == $kelas['id_factor']) {
                    for ($i = 1; $i <= 9; $i++) {
                        if ($raw['raw_data'] <= $kelas['kelas' . $i]) {
                            $nilai = $i;
                            break;
                        }
                    }
                    $data_nilai[] = array(
                        'id_siswa' => $raw['id_siswa'],
                        'id_factor' => $raw['id_factor'],
                        'nilai' => $nilai
                    );
                }
            }
        }

        return $data_nilai;
        // $this->hitung->addNilaiFactor($data_nilai);
    }

    private function setGapNilaiFactor()
    {
        $nilaiFactorSiswa = $this->setNilaiKriteria();
        $nilaiFactor = $this->hitung->getNilai();

        foreach ($nilaiFactor as $nilai) {
            $gap = (int) ($nilai['nilai'] - $nilai['nilai_factor']);
            if ($gap < -4) $bobot = 1;
            if ($gap > 4) $bobot = 5;
            switch ($gap) {
                case 0:
                    $bobot = 3;
                    break;
                case 1:
                    $bobot = 3.5;
                    break;
                case -1:
                    $bobot = 2.5;
                    break;
                case 2:
                    $bobot = 4;
                    break;
                case -2:
                    $bobot = 2;
                    break;
                case 3:
                    $bobot = 4.5;
                    break;
                case -3:
                    $bobot = 1.5;
                    break;
                case 4:
                    $bobot = 5;
                    break;
                case -4:
                    $bobot = 1;
                    break;
                default:
                    $bobot = 3;
                    break;
            }

            $data[] = array(
                'id_siswa' => $nilai['id_siswa'],
                'id_factor' => $nilai['id_factor'],
                'gap' => $gap,
                'bobot' => $bobot
            );
        }

        $this->hitung->addNilaiFactor($nilaiFactorSiswa);
        $this->hitung->addGapNilaiFactor($data);
    }

    private function setNilaiAspek()
    {
        $this->setGapNilaiFactor();
        $data = $this->hitung->getAspek();

        foreach ($data as $siswa) {
            $d = null;
            foreach ($siswa['data'] as $aspek) {
                $NCF = 0;
                $NSF = 0;
                $TCF = 0;
                $TSF = 0;

                $dd = null;
                foreach ($aspek['data'] as $factor) {
                    if ($factor['jenis'] == 'core') {
                        $NCF += $factor['bobot'];
                        $TCF++;
                    } else {
                        $NSF += $factor['bobot'];
                        $TSF++;
                    }
                }
                $nilai_total = $this->getNilaiTotal(array('NCF' => $NCF, 'NSF' => $NSF));
                $dd = $aspek;
                $dd['data'] = array(
                    'id_aspek' => $aspek['id_aspek'],
                    'NCF' => $NCF,
                    'NSF' => $NSF,
                    'TCF' => $TCF,
                    'TSF' => $TSF,
                    'nilai_total' => $nilai_total
                );
                $d[] = $dd;
            }
            $dat[] = array(
                'id_siswa' => $siswa['id_siswa'],
                'data' => $d
            );
        }

        foreach ($dat as $ddd) {
            foreach ($ddd['data'] as $sis) {
                $kirim[] = array(
                    'id_siswa' => $ddd['id_siswa'],
                    'id_aspek' => $sis['data']['id_aspek'],
                    'nilai' => $sis['data']['nilai_total']
                );
            }
        }

        $this->hitung->addNilaiAspek($kirim);

        return $kirim;
    }

    private function getNilaiTotal($data)
    {
        $nilai_total = ((60 / 100) * $data['NCF']) + ((40 / 100) * $data['NSF']);
        return $nilai_total;
    }

    private function getHitung()
    {
        $this->setNilaiAspek();
        $data = $this->hitung->getHitung();

        $kirim['head'] = $data['head'];
        foreach ($data['siswa'] as $siswa) {
            $siswa['total'] = 0;
            foreach ($siswa['data'] as $dat) {
                $siswa['total'] += (float) $dat['hasil'];
            }
            $kirim['siswa'][] = $siswa;
        }
        return $kirim;
    }
}
