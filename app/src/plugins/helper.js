export default {
	install (vue, options) {
		vue.mixin({
		    methods: {
		    	arrayGet(data=[], fields='', $default=null) {
			        if(typeof data === 'object' && (data !== null)) {
			        	fields = fields.toString().split('.');
			        	/*Get data by key*/
			        	for(let i in fields) {
			        		if(typeof data === 'object' && (data !== true || data !== false)) {
			        			if(fields[i] in data) {
				        			data = data[fields[i]];
				        		} else {
				        			data = $default;
				        			break;
				        		}
			        		}
			        	}
			        } else {
			        	return $default;
			        }
			        return data;
			    },
			    rtrim(str, char=' ') {
			    	let reg = new RegExp(char +'+$')
			    	return str.replace(reg, '')
			    },
			    ltrim(str, char=' ') {
			    	let reg = new RegExp('^'+ char +'+')
			    	return str.replace(reg, '')
			    },
			    jsonEncode(data) {
			    	return JSON.stringify(data);
			    },
			    //Trả về value === hàm time() php
			    timeNow() {
			    	return Math.floor(Date.now() / 1000)
			    },
			    reloadPage() {
			    	this.$router.go(this.$router.currentRoute)
			    },
			    md5(value) {
			    	var md5 = require('md5');
					return md5(value);
			    },
			    redirect(options) {
			    	if('path' in options) {
			    		window.location.href = options.path
			    	} else if('route' in options) {
			    		let data = {name: options.route}
			    		delete options.route
			    		for(let label in options) {
			    			data[label] = options[label];
			    		}
			    		this.$router.push(data)
			    	}
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
						console.log(before);
						// console.log(center);
					//  console.log(after);
						result.list = before.concat(center, after);
					} 
					// console.log(result)
					return result;
				}
		    }
		})
	}
}