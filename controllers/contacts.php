<?php


class contacts {

    var $allowedKeys = [
        'email',
        'firstname',
        'lastname',
        'gender',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'county',
        'phone',
    ];

    public function list() {
        global $db;
        json([
            'data' => $db->read('contacts')
        ]);
    }

    public function store($data) {
        global $db;

        $data = sanitizeAllowed($data, $this->allowedKeys);

        try {
            $res = $db->create('contacts', $data);

            if ($res) {
                $r = $db->single('contacts', 'id = ' . $db->insert_id());
                json([
                    'data' => $r
                ]);
            } else {
                json([
                    'msg' => 'Unable to store contact details'
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            json([
                'msg' => 'Unable to store contact details',
                // 'addl' => $th->getMessage()
            ]);
        }
    }

    public function show($id) {
        global $db;
        $record = $db->single('contacts', "id = $id");

        if(! empty($record))
            json([
                'data' => $record
            ]);
        else {
            http_response_code(404);
            json([
                'msg' => 'Contact does not exist'
            ]);
        }

    }

    public function update($id, $data) {
        global $db;

        $data = sanitizeAllowed($data, $this->allowedKeys);

        try {
            $res = $db->update('contacts', $data, "id = $id");

            if ($res) {
                $r = $db->single('contacts', "id = $id");
                json([
                    'data' => $r
                ]);
            } else {
                json([
                    'msg' => 'Unable to update contact details'
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            json([
                'msg' => 'Unable to update contact details',
                'addl' => $th->getMessage()
            ]);
        }
    }

    public function delete($id) {
        global $db;
        return $db->delete('contacts', "id = $id") ? json([ 'msg' => 'Contact has been deleted' ]) : json([ 'msg' => 'Unable to delete contact' ]);
    }
}