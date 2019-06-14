import Env from'@/config/env.js';

export default {
	arrayGet(data, fields='', $default=null) {
		fields = fields.split('.');
		for(let stt in fields) {
			let key = fields[stt];
			if(this.isArray(data) || this.isObject(data) && key in data) {
				data = data[key];
			} else {
				return $default;
			}
		};
		return data;
	},
	baseUrlAPI(path='') {
		return this.rtrim(Env.BASE_URL_API, '/') +'/'+ this.ltrim(path, '/');
	},
	rtrim(str, char=' ') {
		let reg = new RegExp(char +'+$')
		return str.replace(reg, '')
	},
	ltrim(str, char=' ') {
		let reg = new RegExp('^'+ char +'+')
		return str.replace(reg, '')
	},
	isArray(value) {
		return value && typeof value === 'object' && value.constructor === Array;
	},
	isObject(value) {
		return value && typeof value === 'object' && value.constructor === Object;
	},
	formatPrice(value, unit=' ₫') {
		if(value === 0) {
			return 0+unit;
		}
    	value = value.toString().replace(/\D/gi, '');
		value = value.replace(/^0*/gi, '');
    	value = value.replace(/(\d)(?=(\d\d\d)+(?!\d))/gi, "$1.");
		return value+unit;
    },
    toSlug(text, tail=null) {
    	text = String(text);
    	tail = String(tail);

		let slug = text.toLowerCase().trim();
		 
	   //Đổi ký tự có dấu thành không dấu
		slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
		slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
		slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
		slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
		slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
		slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
		slug = slug.replace(/đ/gi, 'd');
		//Xóa các ký tự đặt biệt
		slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
		//Đổi khoảng trắng thành ký tự gạch ngang
		slug = slug.replace(/ /gi, "-");
		//Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
		//Phòng trường hợp người nhập vào quá nhiều ký tự trắng
		slug = slug.replace(/\-\-\-\-\-/gi, '-');
		slug = slug.replace(/\-\-\-\-/gi, '-');
		slug = slug.replace(/\-\-\-/gi, '-');
		slug = slug.replace(/\-\-/gi, '-');
		//Xóa các ký tự gạch ngang ở đầu và cuối++
		slug = '@' + slug + '@';
		slug = slug.replace(/\@\-|\-\@|\@/gi, '');
		return slug + tail;
	},
	paginate(page_total, page_current) {
		page_total = parseInt(page_total);
		page_current = parseInt(page_current);

		let config = {
			page_default: 3,
			// space: 3
		}

		let result = {
			list: [],
			current: page_current,
			next: page_current < page_total ? page_current + 1 : 0, 
			back: page_current > 1 ? page_current - 1 : 0
		};

		if(page_total <= 10) {
			for(let page = 1;page <= page_total;page++) {
				result.list.push({
					type: 'page',
					data: {
						page: page
					}
				});
			}
		} else{
			let a = {
				a: true,
				b: true
			}

			let before = [];
			for(let page = 1;page <= config.page_default;page++) {
				before.push({
					type: 'page',
					data: {
						page: page
					}
				});
			}
			if(page_current-2 <= config.page_default) {
				for(let page = config.page_default+1;page < page_current+2;page++) {
					before.push({
						type: 'page',
						data: {
							page: page
						}
					});
				}
				for(let i = 0;i < 2;i++) {
					before.push({
						type: 'space',
					});
				}
				a.a = false;
			}

			let after = [];
			if(a.a && page_current+2 >= page_total - config.page_default) {
				for(let i = 0;i < 2;i++) {
					after.push({
						type: 'space',
					});
				}
				for(let page = page_current-2;page <= page_total - config.page_default;page++) {
					after.push({
						type: 'page',
						data: {
							page: page
						}
					});
				}
				a.b = false;
			}
			for(let page = page_total - config.page_default + 1;page <= page_total;page++) {
				after.push({
					type: 'page',
					data: {
						page: page
					}
				});
			}

			let center = [];
			if(a.a && a.b) {
				for(let i = 0;i < 2;i++) {
					center.push({
						type: 'space',
					});
				}
				for(let page = page_current-2;page <= page_current+2;page++) {
					center.push({
						type: 'page',
						data: {
							page: page
						}
					});
				}
				for(let i = 0;i < 2;i++) {
					center.push({
						type: 'space',
					});
				}
			}
			result.list = before.concat(center, after);
		} 
		return result;
	},
	saveAccessToken(value, exp=1) {
		this.setCookie('ACCESS_TOKEN', value, exp);
	},
	getAccessToken() {
		return this.getCookie('ACCESS_TOKEN');
	},
	// Hàm thiết lập Cookie
	setCookie(cname, cvalue, exdays) {
	    let d = new Date();
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    let expires = "expires="+d.toUTCString();
	    document.cookie = cname + "=" + cvalue + "; " + expires;
	},
	// Hàm lấy Cookie
	getCookie(cname) {
	    let name = cname + "=";
	    let ca = document.cookie.split(';');
	    for(let i=0; i<ca.length; i++) {
	        let c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1);
	        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
	    }
	    return "";
	},
}