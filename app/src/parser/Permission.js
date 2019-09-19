export default [
	{key: 'id',key_api: 'per_id',data_type: 'number'},
	{key: 'title',key_api: 'per_title',data_type: 'string'},
	{key: 'modules_id',key_api: 'per_modules_id',data_type: 'string'},
	{key: 'modules',key_api: 'modules',data_type: 'object'},
	{key: 'project',key_api: 'project',data_type: 'object', parser: 'Project'},
	{key: 'created_at',key_api: 'per_created_at',data_type: 'string'},
	{key: 'updated_at',key_api: 'per_updated_at',data_type: 'string'},
];