<?php
require APPPATH . 'libraries/REST_Controller.php';

class HitungController extends REST_Controller
{
    public function index_get()
    {
        // penyederhanaan nilai input user
        $data = $this->setNilaiAspek();
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

        // foreach ($data as $siswa) {
        //     foreach ($siswa['data'] as $aspek) {
        //         $NCF = 0;
        //         $NSF = 0;
        //         $TCF = 0;
        //         $TSF = 0;
        //         foreach ($aspek['data'] as $factor) {
        //             if ($factor['jenis'] == 'core') {
        //                 $NCF += $factor['bobot'];
        //                 $TCF++;
        //             } else {
        //                 $NSF += $factor['bobot'];
        //                 $TSF++;
        //             }
        //         }
        //     }
        //     $dat[] = array(
        //         'id_siswa' => $siswa['id_siswa'],
        //         'NCF' => $NCF,
        //         'NSF' => $NSF,
        //         'TCF' => $TCF,
        //         'TSF' => $TSF
        //     );
        // }
        return $data;
    }
}
