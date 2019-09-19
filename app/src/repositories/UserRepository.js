import Repository from './Repository';
import Parser from '@/parser/index';
import HelperIndex from '@/helper/index';

const resource = '/v1/user';

export default {
    async getByFilter(input) {
        const result = await Repository.get(resource, {
            params: {
                page: input.page,
                per: input.page_per,
            }
        });
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
    async getDetail(id) {
        const result = await Repository.get(`${resource}/detail/${id}`);
        const response = Parser.run({
            module: 'User',
            data: HelperIndex.arrayGet(result, 'data', {}),
            type: 'object'
        })
        return response;
    },
    permissionAdd(input) {
        return Repository.post(`${resource}/permission/create`, {
            permission_id: input.permission_id,
            user_id: input.user_id,
            project_id: input.project_id,
        });
    },
    permissionDetail(user_id, project_id) {
        return Repository.get(`${resource}/permission/detail/${user_id}`, {
            params: {
                project_id: project_id,
            }
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
        	fullname: input.fullname,
            position_id: input.position_id,
            master_id: input.master_id,
        });
    },
    async getChild(user_id, input) {
        const result = await Repository.get(`${resource}/child/${user_id}`, {
            params: {
                page: input.page,
                per: input.page_per,
            }
        });
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
    childRemove(id) {
        return Repository.delete(`${resource}/child/remove/${id}`);
    },
    edit(id, input) {
        return Repository.put(`${resource}/update/${id}`, {
            email: input.email, 
            password: input.password, 
            fullname: input.fullname,
            master_id: input.master_id,
        });
    },
    updateProfile(input) {
        return Repository.put(`${resource}/profile/update`, {
            fullname: input.fullname,
        });
    },
    profileUpdatePassword(input) {
        return Repository.put(`${resource}/profile/update/password`, {
            password: input.password,
            password_old: input.password_old,
            password_confirm: input.password_confirm,
        });
    },
    async profile() {
        const result = await Repository.get(`${resource}/profile`);
        const response = Parser.run({
            module: 'User',
            data: HelperIndex.arrayGet(result, 'data', {}),
            type: 'object'
        })
        return response;
    },
}