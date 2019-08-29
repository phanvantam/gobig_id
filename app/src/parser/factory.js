const Modules = {
	Paginate: require('./Paginate.js').default,
	User: require('./User.js').default,
	Module: require('./Module.js').default,
	Project: require('./Project.js').default,
	Position: require('./Position.js').default,
	Permission: require('./Permission.js').default,
};

export default {
	get: name=> Modules[name],
};