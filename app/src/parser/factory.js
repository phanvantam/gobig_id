const Modules = {
	Paginate: require('./Paginate.js').default,
	User: require('./User.js').default,
};

export default {
	get: name=> Modules[name],
};