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
    async getInfo(input) {
        const result = await Repository.get(`${resource}/info`);
        const response = Parser.run({
            module: 'User',
            data: HelperIndex.arrayGet(result, 'data', {}),
            type: 'object'
        })
        return response;
    },
    async getChild(user_id) {
        const result = await Repository.get(`${resource}/child/${user_id}`);
        const response = Parser.run({
            module: 'User',
            data: HelperIndex.arrayGet(result, 'data', []),
        })
        return response;
    },
    childAdd(input) {
        return Repository.post(`${resource}/child/create`, {
            parent_id: input.parent_id,
            child_id: input.child_id,
        });
    },
    permissionAdd(input) {
        return Repository.post(`${resource}/permission/create`, {
            permission_id: input.permission_id,
            user_id: input.user_id,
        });
    },
    async search(input) {
        const result = await Repository.get(`${resource}/search`, {
            params: {
                query: input.query
            }
        });
        const response = Parser.run({
            module: 'User',
            data: HelperIndex.arrayGet(result, 'data', []),
        })
        return response;
    },
    login(input) {
        return Repository.post(`/v1/auth/login`, {
        	email: input.email, 
        	password: input.password, 
        });
    },
    add(input) {
        return Repository.post(`${resource}/create`, {
        	email: input.email, 
        	password: input.password, 
        	fullname: input.fullname
        });
    },
}