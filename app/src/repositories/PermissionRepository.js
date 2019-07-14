import Repository from './Repository';
import Parser from '@/parser/index';
import HelperIndex from '@/helper/index';

const resource = '/v1/permission';

export default {
    async getByfilter(input) {
        const result = await Repository.get(`${resource}`);
        const response = Parser.run({
            module: 'Permission',
            data: HelperIndex.arrayGet(result, 'data', []), 
        })
        return response;
    },
    async getByProject(project_id) {
        const result = await Repository.get(`${resource}/getByProject/${project_id}`);
        const response = Parser.run({
            module: 'Permission',
            data: HelperIndex.arrayGet(result, 'data', []), 
        })
        return response;
    },
    async getById(id) {
        const result = await Repository.get(`${resource}/${id}`);
        const response = Parser.run({
            module: 'Permission',
            data: HelperIndex.arrayGet(result, 'data', {}),
            type: 'object' 
        })
        return response;
    },
    async getListModule(project_id) {
        const result = await Repository.get(`${resource}/module/${project_id}`);
		const response = Parser.run({
			module: 'Module',
			data: HelperIndex.arrayGet(result, 'data', []), 
		})
		return response;
    },
    async getListProject() {
        const result = await Repository.get(`${resource}/project`);
        const response = Parser.run({
            module: 'Project',
            data: HelperIndex.arrayGet(result, 'data', []), 
        })
        return response;
    },
    add(input) {
        return Repository.post(`${resource}/create`, {
            title: input.name, 
            project_id: input.project_id, 
            modules_id: input.modules_id
        });
    },
    update(id, input) {
        return Repository.put(`${resource}/update/${id}`, {
            title: input.name, 
            project_id: input.project_id, 
            modules_id: input.modules_id
        });
    },
    async position() {
        const result = await Repository.get(`${resource}/position`);
        const response = Parser.run({
            module: 'Position',
            data: HelperIndex.arrayGet(result, 'data', []), 
        })
        return response;
    },
    async positionSearch() {
        const result = await Repository.get(`${resource}/position/search`);
        const response = Parser.run({
            module: 'Position',
            data: HelperIndex.arrayGet(result, 'data', []), 
        })
        return response;
    },
    positionAdd(input) {
        return Repository.post(`${resource}/position/create`, {
            name: input.name, 
            key: input.key
        });
    },
    addModule(input) {
        return Repository.post(`${resource}/module/create`, {
        	name: input.name, 
        	project_id: input.project_id, 
        	parent_id: input.parent_id
        });
    },
    addProject(input) {
        return Repository.post(`${resource}/project/create`, {
            name: input.name, 
        });
    },
}