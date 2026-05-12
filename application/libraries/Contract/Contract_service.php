<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contract_service
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->library(
            'General/General_service'
        );

        $this->general_service =
            $this->CI->general_service;
    }

    public function getAllContracts(int $id_ref, string $ref) // $ref == kandang/branch, $id_ref == id_kandang | id_company_sub
    {
        if ($ref === 'branch') {
            $ref = 'company_sub';
        }
        $query = $this->CI->db
            ->select('c.id, c.code, c.effective_date, c.description, c.referenceable_type, cs.id as id_company_sub, cs.location as nama_branch, k.id as id_kandang, k.nama as nama_kandang')
            ->from('contracts c')
            ->join('company_sub cs', 'c.referenceable_id = cs.id', 'left')
            ->join('kandang k', 'c.referenceable_id = k.id', 'left')
            ->where('c.referenceable_type', $ref)
            ->order_by('c.effective_date', 'desc');

        if ($id_ref !== null) {
            $query->where('c.referenceable_id', $id_ref);
        }
        $data = $query->get()->result_array();

        return array_map(function ($item) {
            return [
                'id'    => (int) $item['id'],
                'code'  => $item['code'],
                'effective_date' => $item['effective_date'],
                'reference' => [
                    'id' => $item['referenceable_type'] === 'company_sub' ? (int) $item['id_company_sub'] : (int) $item['id_kandang'],
                    'name' => $item['nama_branch'] ?? $item['nama_kandang'],
                    'type' => $item['referenceable_type'],
                ],
                'description' => $item['description'],
            ];
        }, $data);
    }

    public function create(array $payload)
    {
        if ($payload['referenceable_type'] === 'branch') {
            $payload['referenceable_type'] = 'company_sub';
        }
        $this->CI->db->trans_begin();
        try {

            if (empty($payload['referenceable_type'])) {
                echo $this->general_service->resApi('Referenceable type is required', [], false, 400);
                return;
            }

            if (empty($payload['referenceable_type'])) {
                echo $this->general_service->resApi('Invalid referenceable type', [], false, 400);
                return;
            }

            if (empty($payload['effective_date'])) {
                echo $this->general_service->resApi('Invalid effective date', [], false, 400);
                return;
            }

            $contract = [
                'referenceable_id' => !empty($payload['referenceable_id']) ? (int) $payload['referenceable_id'] : null,
                'referenceable_type' => trim($payload['referenceable_type']),
                'effective_date' => !empty($payload['effective_date']) ? $payload['effective_date'] : null,
                'description' => !empty($payload['description']) ? trim($payload['description']) : null,
                'code' => $this->generateContractCode($payload['referenceable_id'], $payload['referenceable_type']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->CI->db->insert('contracts', $contract);
            $idContract = $this->CI->db->insert_id();
            if (!$idContract) {
                return $this->general_service->resApi('Failed create contract', [], false, 500);
            }

            if ($this->CI->db->trans_status() === false) {
                echo $this->general_service->resApi('Transaction failed', [], false, 400);
                return;
            }

            $this->CI->db->trans_commit();

            return $this->general_service->resApi('Contract created successfully', [
                'id_contract' => $idContract
            ], true, 201);
        } catch (Exception $e) {

            $this->CI->db->trans_rollback();
            return $this->general_service->resApi($e->getMessage(), [], false, 500);
        }
    }

    public function createMaterials(array $payload)
    {
        $this->CI->db->trans_begin();
        try {
            if (empty($payload['contract_id'])) {
                return $this->general_service->resApi('Contract ID is required', [], false, 400);
            }

            $contract = $this->CI->db->get_where('contracts', ['id' => $payload['contract_id']])->row();
            if (!$contract) {
                return $this->general_service->resApi('Contract not found', [], false, 404);
            }

            $this->CI->db->where('id_contract', $payload['contract_id']);
            $this->CI->db->where('referenceable_material !=', 'livebird');
            $this->CI->db->delete('contract_pricelist');

            $batchItems = [];

            foreach ($payload['feeds'] as $item) {
                $batchItems[] = [
                    'id_contract'               => (int) $payload['contract_id'],
                    'id_material'               => !empty($item['id']) ? (int) $item['id'] : null,
                    'referenceable_material'    => 'pakan',
                    'price'                     => !empty($item['price']) ? (float) $item['price'] : 0,
                    'created_at'                => date('Y-m-d H:i:s'),
                    'updated_at'                => date('Y-m-d H:i:s'),
                ];
            }
            foreach ($payload['docs'] as $item) {
                $batchItems[] = [
                    'id_contract'               => (int) $payload['contract_id'],
                    'id_material'               => !empty($item['id']) ? (int) $item['id'] : null,
                    'referenceable_material'    => 'doc',
                    'price'                     => !empty($item['price']) ? (float) $item['price'] : 0,
                    'created_at'                => date('Y-m-d H:i:s'),
                    'updated_at'                => date('Y-m-d H:i:s'),
                ];
            }
            foreach ($payload['ovks'] as $item) {
                $batchItems[] = [
                    'id_contract'               => (int) $payload['contract_id'],
                    'id_material'               => !empty($item['id']) ? (int) $item['id'] : null,
                    'referenceable_material'    => 'obat',
                    'price'                     => !empty($item['price']) ? (float) $item['price'] : 0,
                    'created_at'                => date('Y-m-d H:i:s'),
                    'updated_at'                => date('Y-m-d H:i:s'),
                ];
            }

            if (empty($batchItems)) {
                return $this->general_service->resApi('No valid items to insert', [], false, 400);
            }

            $this->CI->db->insert_batch('contract_pricelist', $batchItems);

            if ($this->CI->db->trans_status() === false) {
                $this->CI->db->trans_rollback();
                return $this->general_service->resApi('Transaction failed', [], false, 400);
            }

            $this->CI->db->trans_commit();

            return $this->general_service->resApi('Materials added successfully', [
                'contract_id' => $payload['contract_id'],
                'count'       => count($batchItems)
            ], true, 201);
        } catch (Exception $e) {
            $this->CI->db->trans_rollback();
            return $this->general_service->resApi($e->getMessage(), [], false, 500);
        }
    }

    public function createSales(array $payload)
    {
        $this->CI->db->trans_begin();
        try {
            if (empty($payload['contract_id'])) {
                return $this->general_service->resApi('Contract ID is required', [], false, 400);
            }

            $contract = $this->CI->db->get_where('contracts', ['id' => $payload['contract_id']])->row();
            if (!$contract) {
                return $this->general_service->resApi('Contract not found', [], false, 404);
            }

            $this->CI->db->where('id_contract', $payload['contract_id']);
            $this->CI->db->where('referenceable_material', 'livebird');
            $this->CI->db->delete('contract_pricelist');

            $batchItems = [];

            foreach ($payload['items'] as $item) {
                $batchItems[] = [
                    'id_contract'               => (int) $payload['contract_id'],
                    'id_material'               => !empty($item['id']) ? (int) $item['id'] : null,
                    'referenceable_material'    => 'livebird',
                    'price'                     => !empty($item['price']) ? (float) $item['price'] : 0,
                    'created_at'                => date('Y-m-d H:i:s'),
                    'updated_at'                => date('Y-m-d H:i:s'),
                ];
            }

            if (empty($batchItems)) {
                return $this->general_service->resApi('No valid items to insert', [], false, 400);
            }

            $this->CI->db->insert_batch('contract_pricelist', $batchItems);

            if ($this->CI->db->trans_status() === false) {
                $this->CI->db->trans_rollback();
                return $this->general_service->resApi('Transaction failed', [], false, 400);
            }

            $this->CI->db->trans_commit();

            return $this->general_service->resApi('Materials added successfully', [
                'contract_id' => $payload['contract_id'],
                'count'       => count($batchItems)
            ], true, 201);
        } catch (Exception $e) {
            $this->CI->db->trans_rollback();
            return $this->general_service->resApi($e->getMessage(), [], false, 500);
        }
    }

    public function show(int $id)
    {
        $data = $this->CI->db
            ->select('
                c.id, c.code, c.effective_date, c.description, c.referenceable_type, 
                cs.id as id_company_sub, cs.location as nama_branch, cs.id_company,
                k.id as id_kandang, k.nama as nama_kandang, k.id_lokasi,
                cs2.location, cs2.id_company id_company_type')
            ->from('contracts c')
            ->join('company_sub cs', 'c.referenceable_id = cs.id', 'left')
            ->join('kandang k', 'c.referenceable_id = k.id', 'left')
            ->join('company_sub cs2', 'k.id_lokasi = cs2.id', 'left')
            ->where('c.id', $id)
            ->get()
            ->row_array();
        if (!$data) {
            return $this->general_service->resApi('No Data', [], false, 400);
        }

        $items = $this->CI->db
            ->select('
            cp.id, cp.referenceable_material type, cp.price, 
            p.id id_pakan, p.brand name_pakan, 
            o.id id_obat, o.brand name_obat, 
            d.id id_doc, d.name name_doc, 
            l.id id_livebird, l.name name_livebird')
            ->from('contract_pricelist cp')
            ->join('pakan p', 'cp.id_material = p.id', 'left')
            ->join('obat o', 'cp.id_material = o.id', 'left')
            ->join('doc d', 'cp.id_material = d.id', 'left')
            ->join('livebird l', 'cp.id_material = l.id', 'left')
            ->where('cp.id_contract', $id)
            ->get()
            ->result_array();

        $formattedItems = array_map(function ($item) {
            return [
                'id' => (int) $item['id'],
                'type' => $item['type'],
                'item' => [
                    'id' => $item['id_' . $item['type']] ?? null,
                    'name' => $item['name_' . $item['type']] ?? null,
                ],
                'price' => (float) $item['price'],
            ];
        }, $items);

        $data['feeds'] = array_values(array_filter(
            $formattedItems,
            fn($x) => $x['type'] === 'pakan'
        ));
        $data['docs'] = array_values(array_filter(
            $formattedItems,
            fn($x) => $x['type'] === 'doc'
        ));
        $data['ovks'] = array_values(array_filter(
            $formattedItems,
            fn($x) => $x['type'] === 'obat'
        ));
        $data['sales'] = array_values(array_filter(
            $formattedItems,
            fn($x) => $x['type'] === 'livebird'
        ));
        $companyId = $data['referenceable_type'] === 'company_sub' ? (int) $data['id_company'] : (int) $data['id_company_type'];
        return [
            'id' => (int) $data['id'],
            'code'  => $data['code'],
            'effective_date' => $data['effective_date'],
            'reference' => [
                'id' => $data['referenceable_type'] === 'company_sub' ? (int) $data['id_company_sub'] : (int) $data['id_kandang'],
                'name' => $data['nama_branch'] ?? $data['nama_kandang'],
                'type' => $data['referenceable_type'],
                'branch' => [
                    'id' => $data['referenceable_type'] === 'company_sub' ? (int) $data['id_company_sub'] : (int) $data['id_lokasi'],
                    'name' => $data['referenceable_type'] === 'company_sub' ? $data['nama_branch'] : $data['location'],
                ],
                'company' => [
                    'id' => $companyId,
                    'name' => $companyId === 1 ? 'Internal' : ($companyId === 10 ? 'Mitra' : 'Planet Namex')
                ]
            ],
            'description' => $data['description'],
            'docs' => $data['docs'],
            'feeds' => $data['feeds'],
            'ovks' => $data['ovks'],
            'sales' => $data['sales']
        ];
    }

    public function update(int $id, array $payload)
    {
        if ($payload['referenceable_type'] === 'branch') {
            $payload['referenceable_type'] = 'company_sub';
        }

        $this->CI->db->trans_begin();
        try {
            $existing = $this->CI->db->get_where('contracts', ['id' => $id])->row();
            if (!$existing) {
                return $this->general_service->resApi('Contract not found', [], false, 404);
            }

            $contract = [
                'referenceable_id' => !empty($payload['referenceable_id']) ? (int) $payload['referenceable_id'] : $existing->referenceable_id,
                'referenceable_type' => !empty($payload['referenceable_type']) ? trim($payload['referenceable_type']) : $existing->referenceable_type,
                'effective_date' => !empty($payload['effective_date']) ? $payload['effective_date'] : $existing->effective_date,
                'description' => !empty($payload['description']) ? trim($payload['description']) : $existing->description,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->CI->db->where('id', $id)->update('contracts', $contract);

            if ($this->CI->db->trans_status() === false) {
                $this->CI->db->trans_rollback();
                return $this->general_service->resApi('Transaction failed', [], false, 400);
            }

            $this->CI->db->trans_commit();
            return $this->general_service->resApi('Contract updated successfully', ['id_contract' => $id], true, 200);
        } catch (Exception $e) {
            $this->CI->db->trans_rollback();
            return $this->general_service->resApi($e->getMessage(), [], false, 500);
        }
    }

    public function delete(int $id)
    {
        $this->CI->db->trans_begin();
        try {
            $this->CI->db->where('id', $id)->delete('contracts');
            if ($this->CI->db->trans_status() === false) {
                $this->CI->db->trans_rollback();
                return $this->general_service->resApi('Transaction failed', [], false, 400);
            }

            $this->CI->db->trans_commit();
            return $this->general_service->resApi('Contract deleted successfully', ['id_contract' => $id], true, 200);
        } catch (Exception $e) {
            $this->CI->db->trans_rollback();
            return $this->general_service->resApi($e->getMessage(), [], false, 500);
        }
    }

    private function generateContractCode(int $id, string $type)
    {
        return sprintf(
            'CTR-%d-%s%s',
            $id,
            strtoupper(substr($type, 0, 1)),
            date('Ymd')
        );
    }
}
