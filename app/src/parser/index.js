import HelperIndex from '@/helper/index';
import Module_parser from './factory.js';

export default {
	run({data, type='array', module}, $default=true) {
		let parser = Module_parser.get(module);
		let result = null;
		switch(type) {
			case 'array':
				result = [];
				data = HelperIndex.isArray(data) ? data : [];
				data.map(item=> {
					result.push(this.test(item, parser,$default));
				});
			break;
			case 'object':
				result = this.test(data, parser, $default);
			break;
		}
		return result;
	},
	test(data, parser, $default) {
		data = HelperIndex.isObject(data) ? data : {};
		let result = {};
		for(let stt in parser) {
			let item = parser[stt];
			switch(item.data_type) {
				case 'object': 
					if($default) {
						result[item.key] = this.run({data: {}, module: item.parser, type: 'object'}, false);
					}
				break;
				case 'array': 
					result[item.key] = [];
				break;
				case 'number': 
					result[item.key] = 0;
				break;
				case 'string': 
					result[item.key] = '';
				break;
				case 'boolean': 
					result[item.key] = false;
				break;
			}
			item.key_api.split('|').map(key=> {
				if(key in data) {
					let tmp = null;
					switch(item.data_type) {
						case 'object': 
							tmp = 'parser' in item ? this.run({data: data[key], module: item.parser, type: 'object'}) : data[key];
						break;
						case 'array':
							tmp = 'parser' in item ? this.run({data: data[key], module: item.parser}) : data[key];
						break;
						case 'number': 
							tmp = Number(data[key]);
							tmp = isNaN(result[item.key]) ? 0 : tmp;
						break;
						case 'string': 
							tmp = String(data[key]);
						break;
						case 'boolean': 
							tmp = Boolean(data[key]);
						break;
					}
					result[item.key] = tmp; 
				}
			})
		}
		return result;
	}
}