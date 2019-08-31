export default [
	{key: 'id',key_api: 'use_id|id',data_type: 'number'},
	{key: 'child_id',key_api: 'usc_id',data_type: 'number'},
	{key: 'fullname',key_api: 'use_fullname|fullname',data_type: 'string'},
	{key: 'email',key_api: 'use_email|email',data_type: 'string'},
	{key: 'code',key_api: 'use_code|code',data_type: 'string'},
	{key: 'created_at',key_api: 'use_created_at|usc_created_at',data_type: 'string'},
	{key: 'updated_at',key_api: 'use_updated_at',data_type: 'string'},
	{key: 'permission',key_api: 'permission',data_type: 'array',parser: 'Permission'},
	{key: 'position',key_api: 'position',data_type: 'object',parser: 'Position'},
	{key: 'master',key_api: 'master',data_type: 'object'},
	{key: 'children',key_api: 'children',data_type: 'array',parser: 'User'},
];
