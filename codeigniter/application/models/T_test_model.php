<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * テーブル
 * @author kamikawa
 *
 */
class T_test_model extends MY_Model{
/*
	private $id;
	private $number;
	private $string;
	private $bool;
*/

	public function getId() {return $this->id;}
	public function setId($id) {$this->id = $id;}
	public function getNumber() {return $this->number;}
	public function setNumber($number) {$this->number = $number;}
	public function getString() {return $this->string;}
	public function setString($string) {$this->string= $string;}
	public function getBool() {return $this->bool;}
	public function setBool($bool) {$this->bool= $bool;}

	public function getAll__(){
		return $this->id. ' ### '. $this->number. ' $$$ '. $this->string. ' %%% '. $this->bool;
	}

    /**
     * コンストラクタ
     */
    function __construct(){
        parent:: __construct();
        // ********** コンストラクタ内で他のモデルのロードは禁止！！ **********
        // ********** 使用する関数内でロードすること！！             **********
    }

    function getAll(){
		$result = array();

		$this->db->select('*');
		$this->db->from('t_test');

		$query = $this->db->get();
        $result = $query->result_array();

        return $result;
	}

	function getAllObject(){
		require_once APPPATH. 'models/entities/t_test_entity.php';

		$result = null;
print "<br>";
print "<br>";
print "<br>";
var_dump(__CLASS__);
print "<br>";
print "<br>";
print "<br>";
		$this->db->select('*');
/*		$this->db->select('t1.id as t1_id');
		$this->db->select('t1.number as t1_number');
		$this->db->select('t1.string as t1_string');
		$this->db->select('t1.bool as t1_bool');
		$this->db->select('t2.id as t2_id');
		$this->db->select('t2.t_test_id as t2_t_test_id');
		$this->db->select('t2.number as t2_number');
		$this->db->select('t2.string as t2_string');
		$this->db->select('t2.bool as t2_bool');
*/
		$this->db->from('t_test as t1');
		$this->db->join('t_test2 as t2', 't2.t_test_id=t1.id');

		$query = $this->db->get();
		$result = $query->result(__CLASS__);

		return $result;
	}

	function setObject(){
//		require_once APPPATH. 'models/entities/t_test_entity.php';
//		$entity = new t_test_entity();
//		$this->setId(1);
		$this->setString('zzzzz');

		$this->db->set($this);
		$this->db->where('id', 1);
//var_dump($this->db);
		$this->db->update('t_test');

//		print "last_query:<br>";
//		var_dump($this->db->last_query());
//		print "<br>";
	}
}
