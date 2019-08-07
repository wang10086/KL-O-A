<?php
namespace Main\Model;

use Think\Model\RelationModel;

class AccountModel extends RelationModel{
	
	protected $_link = array(
	    'role' => array (
		    'mapping_type' => self::MANY_TO_MANY,
			'foreign_key' => 'user_id',
			'relation_key' => 'role_id',
			'relation_table' => 'oa_role_user',
			'mapping_fields' => 'id,name,remark,role_name',
		)
	);
	
}
?>