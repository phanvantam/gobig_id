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