<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class peminjaman extends REST_Controller {
	
	function __construct($config = 'rest') {
		parent::__Construct($config);
	}
	
	//Menampilkan data
	public function index_get() {
		
		$id = $this->get('id');
		if ($id == '') {
			$data = $this->db->get('peminjaman')->result();
		} else {
			$this->db->where('id_anggota', $id);
			$data = $this->db->get('peminjaman')->result();
		}
		$result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
				   "code"=>200,
				   "message"=>"Response successfully",
				   "data"=>$data];
		$this->response($result, 200);
	    }


   //Menambah data 
   public function index_post() {
    $data = array(
        'id_anggota'  => $this->post('id_anggota'),
        'tanggal_pinjaman' => $this->post('tanggal_pinjaman'),
        'tanggal_kembali' => $this->post('tanggal_kembali'));
    $insert = $this->db->insert('peminjaman', $data);
    if ($insert) {
        //$this->response($data, 200);
        $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
            "Code"=>201,
            "message"=>"Data has successfully added",
            "data"=>$data];
        $this->response($result, 201);
    } else {
        $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
            "code"=>502,
            "message"=>"Failed adding data",
            "data"=>null];
        $this->response($result, 502);  
        }
    }

    //Memperbarui data yang telah ada
     public function index_put() { 
        $id = $this->put('id');        
        $data = array (                       
            'tanggal_pinjaman' => $this->put('tanggal_pinjaman'),
            'tanggal_kembali' => $this->put('tanggal_kembali'));
       // echo "<pre>"; print_r($data); die();
        $this->db->where('id_anggota', $id);
        $update = $this->db->update('peminjaman', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
     }

    //Menghapus data peminjaman
    public function index_delete() {
        $id = $this->delete('id'); // ini yang ditulis pada key di postman ya...., bukan customerID
        $this->db->where('id_anggota', $id);
        $delete = $this->db->delete('peminjaman');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
  
}
?>