export default {
	check(value, rule='required:string') {
		const rules = rule.split('|');
		for(let stt in rules) {
			let params = [value];
			let options = rules[stt].split(':');
			let action = this[options[0]];

			if(options.length > 1) {
				options.splice(0, 1);
				params.push(options);
			}
			let result = action.apply(this, params);
			if(result === false) {
				return false
			}
		}
		return true;
	},
	required(value, options) {
		let pass = true;
		options.map(type=> {
			if(pass) {
				let tmp = null;
				switch(type) {
					case 'string': 
						tmp = String(value);
						pass = tmp == '' ? false : true;
					break;
					case 'number': 
						tmp = Number(value);
						pass = isNaN(tmp) || tmp == 0 ? false : true;
					break;
					case 'boolean': 
						tmp = Boolean(value);
						pass = tmp;
					break;
				}
			}
		});
		return pass;
	},
	url(value) {
		value = String(value);
		let re = /^(http|https)(\:\/\/).*$/;
		return re.test(value);
	},
	phone(value) {
		value = String(value);
		// area code
		let re = /^\+84[\d]{9}$/;
		return re.test(value);
	},
}