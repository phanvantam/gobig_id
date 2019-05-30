import Repository from './Repository';

const resource = '/customer';

export default {
    getByFilter(page) {
        return Repository.get(resource, {
            params: {
                page: page
            }
        });
    }
}