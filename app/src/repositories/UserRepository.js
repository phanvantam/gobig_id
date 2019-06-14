import Repository from './Repository';
import Parser from '@/parser/index';
import HelperIndex from '@/helper/index';

const resource = '/v1/user';

export default {
    async getByFilter(input) {
        const result = await Repository.get(resource);
		const response = {
			users: Parser.run({
				module: 'User',
				data: HelperIndex.arrayGet(result, 'data.users', []), 
			}),
			paginate: Parser.run({
				module: 'Paginate',
				data: HelperIndex.arrayGet(result, 'data.paginate', {}), 
				type: 'object'
			})
		};
		return response;
    },
    login(input) {
        return Repository.post(`/v1/auth/login`, {
        	email: input.email, 
        	password: input.password, 
        });
    },
    add(input) {
        return Repository.post(`/v1/user/create`, {
        	email: input.email, 
        	password: input.password, 
        	fullname: input.fullname
        });
    },
}