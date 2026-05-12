<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ternak_service
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('jwt_auth');
        $this->user_data = $this->CI->jwt_auth->validate();
    }

    public function getLokasiList(int $id_company) //$id_company = 1 (internal)
    {
        $data = $this->CI->db
            ->select('id, location')
            ->from('company_sub')
            ->where('id_company', $id_company)
            ->where('status', 1)
            ->order_by('location', 'ASC')
            ->get()
            ->result_array();

        return array_map(function ($item) {
            return [
                'id'   => (int) $item['id'],
                'name' => strtoupper($item['location'] ?? ''),
            ];
        }, $data);
    }

    public function getKandangByLokasi(int $id_lokasi) //$id_lokasi = 1 (BOCEK)
    {
        $data = $this->CI->db
            ->select('id, nama as name')
            ->from('kandang')
            ->where('id_lokasi', $id_lokasi)
            ->order_by('nama', 'ASC')
            ->get()
            ->result_array();
        return $data;
    }

    public function getByPeriode(int $id_kandang, string $periode)
    {
        $data = $this->CI->db
            ->select('ka.id, k.nama, ka.status_kandang_activity, ka.populasi_awal, ka.periode, ka.strain')
            ->from('kandang_activity as ka')
            ->join('kandang as k', 'ka.id_kandang = k.id')
            ->where('ka.id_kandang', $id_kandang)
            ->where('ka.periode', $periode)
            ->get()
            ->result_array();

        return array_map(function ($item) {
            return [
                'id'    => (int) $item['id'],
                'name'  => strtoupper($item['nama']),
                'status' => $item['status_kandang_activity'],
                'begin' => (int) $item['populasi_awal'],
                'periode' => $item['periode'],
                'strain' => $item['strain'],
            ];
        }, $data);
    }

    public function getKandangList(int $id_kandang, ?string $periode = null)
    {
        $this->CI->db
            ->select('ka.id, k.nama, ka.status_kandang_activity, ka.populasi_awal, ka.periode, ka.strain, ka.tanggal_mulai')
            ->from('kandang as k')
            ->join('kandang_activity as ka', 'ka.id_kandang = k.id')
            ->where('k.id', $id_kandang);

        if ($periode) {
            $this->CI->db->where('ka.periode', $periode);
        }

        $data = $this->CI->db
            ->order_by('k.nama', 'ASC')
            ->get()
            ->result_array();

        return array_map(function ($item) {
            return [
                'id'    => (int) $item['id'],
                'name'  => strtoupper($item['nama']),
                'status' => $item['status_kandang_activity'],
                'begin' => (int) $item['populasi_awal'],
                'chickin_date' => $item['tanggal_mulai'],
                'periode' => $item['periode'],
                'strain' => $item['strain'],
            ];
        }, $data);
    }
    // =================== CORETAN
    // public function getKandangList(int $id_kandang) //$id_lokasi = 1 (BOCEK)
    // {
    //     $data = $this->CI->db
    //         ->select('k.id, k.nama, ka.status_kandang_activity, ka.populasi_awal, ka.periode, ka.strain')
    //         ->from('kandang as k')
    //         ->join('kandang_activity as ka', 'ka.id_kandang = k.id')
    //         ->where('k.id', $id_kandang)
    //         ->order_by('nama', 'ASC')
    //         ->get()
    //         ->result_array();

    //     $grouped = [];

    //     foreach ($data as $row) {
    //         $id = $row['id'];
    //         if (!isset($grouped[$id])) {
    //             $grouped[$id] = [
    //                 'id'    => (int) $id,
    //                 'name'  => strtoupper($row['nama']),
    //                 'item'  => []
    //             ];
    //         }
    //         $grouped[$id]['item'][] = [
    //             'status'  => $row['status_kandang_activity'],
    //             'begin'   => (int) $row['populasi_awal'],
    //             'periode' => $row['periode'],
    //             'strain'  => $row['strain'],
    //         ];
    //     }

    //     return array_values($grouped);
    // }

    public function getrhpp_old(int $id_kandang, string $periode)
    {
        $data = [
            "henhouse" => [
                "id" => $id_kandang,
                "name" => "BOCEK",
                "period" => $periode,
                "chick_in_date" => "2024-01-01",
                "closed_date" => null,
                "address" => "Jl. Raya Bogor, No. 123"
            ],
            "doc" => [
                "name" => "Document 1",
                "quantity" => 100,
                "delivery_order" => "DO-001",
                "scheme" => [
                    "inti" => [
                        "price" => 10000,
                        "amount" => 50
                    ],
                    "plazma" => [
                        "price" => 15000,
                        "amount" => 50
                    ]
                ]
            ],
            "feed" => [
                "in" => [
                    "quantity" => 1000,
                    "scheme" => [
                        "inti" => [
                            "price" => 10000,
                            "amount" => 50
                        ],
                        "plazma" => [
                            "price" => 20000,
                            "amount" => 50
                        ]
                    ],
                    "items" => [
                        "id" => 1,
                        "name" => "Feed Item 1",
                        "transaction_type" => "in",
                        "delivery_order" => "DO-001",
                        "quantity" => 100,
                        "date" => "2024-01-01",
                        "scheme" => [
                            "inti" => [
                                "price" => 10000,
                                "amount" => 50
                            ],
                            "plazma" => [
                                "price" => 20000,
                                "amount" => 50
                            ]
                        ]
                    ]
                ],
                "used" => [
                    "quantity" => 34,
                    "scheme" => [
                        "inti" => [
                            "price" => 34,
                            "amount" => 34
                        ],
                        "plazma" => [
                            "price" => 34,
                            "amount" => 34
                        ]
                    ],
                    "items" => [
                        "id" => 1,
                        "name" => "Feed Item 1",
                        "transaction_type" => "used",
                        "delivery_order" => "DO-001",
                        "quantity" => 34,
                        "date" => "2024-01-01",
                        "scheme" => [
                            "inti" => [
                                "price" => 34,
                                "amount" => 34
                            ],
                            "plazma" => [
                                "price" => 34,
                                "amount" => 34
                            ]
                        ]
                    ]
                ]
            ],
            "ovk" => [
                "in" => [
                    "quantity" => 1000,
                    "scheme" => [
                        "inti" => [
                            "price" => 10000,
                            "amount" => 50
                        ],
                        "plazma" => [
                            "price" => 20000,
                            "amount" => 50
                        ]
                    ],
                    "items" => [
                        "id" => 1,
                        "name" => "OVK Item 1",
                        "transaction_type" => "in",
                        "delivery_order" => "DO-001",
                        "quantity" => 100,
                        "date" => "2024-01-01",
                        "scheme" => [
                            "inti" => [
                                "price" => 10000,
                                "amount" => 50
                            ],
                            "plazma" => [
                                "price" => 20000,
                                "amount" => 50
                            ]
                        ]
                    ]
                ],
                "used" => [
                    "quantity" => 34,
                    "scheme" => [
                        "inti" => [
                            "price" => 34,
                            "amount" => 34
                        ],
                        "plazma" => [
                            "price" => 34,
                            "amount" => 34
                        ]
                    ],
                    "items" => [
                        "id" => 1,
                        "name" => "Feed Item 1",
                        "transaction_type" => "used",
                        "delivery_order" => "DO-001",
                        "quantity" => 34,
                        "date" => "2024-01-01",
                        "scheme" => [
                            "inti" => [
                                "price" => 34,
                                "amount" => 34
                            ],
                            "plazma" => [
                                "price" => 34,
                                "amount" => 34
                            ]
                        ]
                    ]
                ]
            ],
            "sales" => [
                "quantity" => 100,
                "avg_age" => 5,
                "total_weight" => 4,
                "avg_weight" => 4,
                "scheme" => [
                    "inti" => [
                        "price" => 4,
                        "amount" => 4
                    ],
                    "plazma" => [
                        "price" => 4,
                        "amount" => 4,
                    ],
                ],
                "items" => [
                    [
                        "id" => 4,
                        "buyer_name" => 'sdf',
                        "delivery_order" => 'sdf',
                        "quantity" => 4,
                        "age" => 4,
                        "chicken_count" => 4,
                        "chicken_total_weight" => 4,
                        "chicken_avg_weight" => 4,
                        "scheme" => [
                            "inti" => [
                                "price" => 4,
                                "amount" => 4,
                            ],
                            "plazma" => [
                                "price" => 4,
                                "amount" => 4,
                            ],
                        ],
                    ],
                ]
            ],
        ];
        return $data;
    }
}
