<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rhpp_service
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('MData'); // Pastikan model yang dibutuhkan di-load
    }

    public function getRhppData(int $id_kandang, string $periode)
    {
        $henhouse = $this->CI->db
            ->select('k.id, k.nama, ka.periode, k.alamat, ka.tanggal_mulai, MAX(panen.tanggal) as tanggal_panen, ka.strain, ka.harga_doc as harga_inti, ka.populasi_awal')
            ->from('kandang as k')
            ->join('kandang_activity as ka', 'ka.id_kandang = k.id')
            ->join('kandang_activity_log_panen as panen', 'panen.id_kandang = k.id AND panen.periode = ka.periode', 'left')
            ->where('k.id', $id_kandang)
            ->where('ka.periode', $periode)
            ->get()
            ->row();

        $doc = $henhouse;
        // SELECT * FROM `kandang_activity_log_sapronak` where id_kandang = 2604 and periode = '20260317PJ0002' ORDER BY `tanggal_kandang_activity_log` DESC
        $feed = $this->CI->db
            ->select('sapronak.id id, sapronak.method_sapronak method, sapronak.id_kandang_to, sapronak.type_sapronak type, sapronak.tanggal_kandang_activity_log tanggal, sapronak.qty, sapronak.harga harga_inti,
                      k.nama nama_kandang, 
                      k2.nama to, 
                      obat.brand nama_obat, 
                      pakan.brand nama_pakan')
            ->from('kandang_activity_log_sapronak as sapronak')
            ->join('kandang as k', 'k.id = sapronak.id_kandang')
            ->join('kandang as k2', 'k2.id = sapronak.id_kandang_to', 'left')
            ->join('obat', 'obat.id = sapronak.id_this', 'left')
            ->join('pakan', 'pakan.id = sapronak.id_this', 'left')
            ->where('sapronak.id_kandang', $id_kandang)
            ->where('sapronak.periode', $periode)
            ->get()
            ->result_array();
        // $ovk = $this->CI->MData->getFeedTransactions($id_kandang, $periode);
        // $sales = $this->CI->MData->getFeedTransactions($id_kandang, $periode);

        // 2. Susun Response Utama
        return [
            "henhouse" => $this->transformHenhouse($henhouse),
            "doc"      => $this->transformDoc($doc),
            "feed"     => $this->transform($feed, 'pakan'),
            "ovk"     => $this->transform($feed, 'ovk'),
            // "sales"    => $this->transformSales($sales),
        ];
    }

    private function transformHenhouse($data)
    {
        return [
            "id" => $data->id,
            "name" => $data->nama,
            "period" => $data->periode,
            "chick_in_date" => $data->tanggal_mulai,
            "closed_date" => $data->tanggal_panen,
            "address" => $data->alamat
        ];
    }

    private function transformDoc($data)
    {
        return [
            "name" => "DOC " . strtoupper($data->strain) . " + VAKSIN (GAK GINI BOS)",
            "date" => $data->tanggal_mulai,
            "quantity" => $data->populasi_awal,
            "delivery_order" => "No. Surat Jalan DOC",
            "scheme" => $this->formatScheme(10000, (int) $data->harga_inti, $data->populasi_awal)
        ];
    }

    private function transform($data, string $type)
    {
        $items_in = $this->itemsLoop($data, $type, 'in');
        $items_mutation_in = $this->itemsLoop($data, $type, 'mutation_in');
        $items_used = $this->itemsLoop($data, $type, 'use');
        $items_out = $this->itemsLoop($data, $type, 'out');

        // echo json_encode($items_in); exit;
        // echo json_encode($this->formatScheme($items_in['amount_inti'], 12000, $items_in['total_qty'])); exit;

        return [
            "in" => [
                "quantity" => $items_in['total_qty'],
                "scheme" => $this->formatScheme($items_in['amount_inti'], 12000, $items_in['total_qty']),
                "items" => $items_in['items']
            ],
            "mutation_in" => [
                "quantity" => $items_mutation_in['total_qty'],
                "scheme" => $this->formatScheme(10000, 12000, $items_mutation_in['total_qty']),
                "items" => $items_mutation_in['items']
            ],
            "out" => [
                "quantity" => $items_out['total_qty'],
                "scheme" => $this->formatScheme(10000, 12000, $items_out['total_qty']),
                "items" => $items_out['items']
            ],
            "used" => [
                "quantity" => $items_used['total_qty'],
                "scheme" => $this->formatScheme(10000, 12000, $items_used['total_qty']),
                "items" => $items_used['items']
            ],
        ];
    }

    private function formatScheme(int $price_inti, int $price_plasma, int $qty)
    {
        return [
            "inti"   => ["price" => $price_inti, "amount" => $price_inti * $qty],
            "plazma" => ["price" => $price_plasma, "amount" => $price_plasma * $qty]
        ];
    }

    private function itemsLoop(array $data, string $type, string $method) //$method = in, out, mutation_in, used, $type = pakan, ovk
    {
        // echo json_encode($data); exit;
        $items = [];
        $total_qty = 0;
        $schema = [];
        foreach ($data as $row) {
            if ($type !== $row['type']) {
                continue;
            }
            if ($method === 'in') {
                if ($row['method'] !== 'in') {
                    continue;
                }
                if (!empty($row['id_kandang_to'])) {
                    continue;
                }
            }
            if ($method === 'mutation_in') {
                if ($row['method'] !== 'in') {
                    continue;
                }
                if (empty($row['id_kandang_to'])) {
                    continue;
                }
            }
            if ($method === 'out') {
                if ($row['method'] !== 'out') {
                    continue;
                }
                if (empty($row['id_kandang_to'])) {
                    continue;
                }
            }
            if ($method === 'use') {
                if ($row['method'] !== 'use') {
                    continue;
                }
            }
            $schema = $this->formatScheme($row['harga_inti'], $row['harga_plasma'] ?? 111, $row['qty']);
            $total_qty += (int) $row['qty'];
            $items[] = [
                "id" => (int) $row['id'],
                "date" => $row['tanggal'],
                "name" => $type === 'pakan' ? $row['nama_pakan'] : $row['nama_obat'],
                "transaction_type" => $row['method'],
                "delivery_order" => 'STATIK DULU BOSKU',
                "quantity" => (int) $row['qty'],
                "scheme" => $schema
            ];
        }
        // echo json_encode($schema); exit;
        return [
            'items' => $items,
            'total_qty' => $total_qty,
            'amount_inti' => $schema['inti']['amount'] ?? 0,
            'amount_plasma' => $schema['plazma']['amount'] ?? 0
        ];
    }
}
