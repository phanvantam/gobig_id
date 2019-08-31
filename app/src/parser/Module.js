export default [
	{key: 'id',key_api: 'mod_id',data_type: 'number'},
	{key: 'name',key_api: 'mod_name',data_type: 'string'},
	{key: 'code',key_api: 'mod_code',data_type: 'string'},
	{key: 'children',key_api: 'children',data_type: 'array', parser: 'Module'},
	{key: 'parent_id',key_api: 'mod_parent_id',data_type: 'number'},
	{key: 'created_at',key_api: 'mod_created_at',data_type: 'string'},
	{key: 'updated_at',key_api: 'mod_updated_at',data_type: 'string'},
];