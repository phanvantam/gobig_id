<template>
	<div class="modal modal_sc1" id="user-add-permission">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <!-- Modal Header -->
	            <div class="modal-header">
	            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
	                <h4 class="modal-title">Thêm quyền người dùng</h4>
	                
	            </div>
	            <!-- Modal body -->
	            <div class="modal-body">
                    <div class="form-group">
                        <label for="">Dự án:</label>
                        <select class="form-control" v-model="data.project_id">
                            <option value="null" disabled="">-- Chọn dự án --</option>
                            <option v-for="item in projects" :value="item.id">{{ item.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nhóm quyền:</label>
                        <select class="form-control" v-model="data.permission_id">
                            <option value="null" disabled="">-- Chọn nhóm quyền --</option>
                            <option v-for="item in permissions" :value="item.id">{{ item.title }}</option>
                        </select>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-6" v-for="item in modules">
                            <label>{{ item.name }}</label>
                            <span class="help-block" v-for="item in item.children">
                                <i :class="{fa: true, 'fa-circle-o': !data.modules.includes(`${item.id}`), 'fa-dot-circle-o': data.modules.includes(`${item.id}`)}"></i>
                                {{ item.name }}
                            </span>
                        </div>
                    </div>
	            </div>
	            <!-- Modal footer -->
	            <div class="modal-footer">
	                <button type="button" class="btn btn-connect pull-left" @click="submit()">Xác nhận</button>
	                <button type="button" class="btn btn-danger close-modal" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	    </div>
	</div>
</template>

<script>
import PermissionRepository from '@/repositories/PermissionRepository';
import UserRepository from '@/repositories/UserRepository';
import HelperIndex from '@/helper/index';

export default {
    data: ()=> ({
        data: {
            project_id: null, 
            permission_id: null,
            modules: []
        },
        projects: [],
        permissions: [],
        modules: []
    }),
    watch: {
        'data.project_id': async function(value) {
            if(value !== null) {
            	this.data.permission_id = null;
                await this.getPermission();
                await this.getModule();
                await this.getPermissionOld();
            }
        },
        'data.permission_id': function(value) {
            if(value !== null) {
               this.getPermissionSelect();
            }
        }
    },
    props: {
    	user_id: {
    		type: Number
    	}
    },
    created() {
        this.getProject();
    },
    methods: {
        submit() {
        	let params = {
                permission_id: this.data.permission_id,
        		project_id: this.data.project_id,
        		user_id: this.user_id
        	};
        	UserRepository.permissionAdd(params)
            .then(response=> {
                switch(response.status) {
                    case 1: 
                        $(this.$el).find('.close-modal').click();
                        this.$emit('reload');
                        this.$notify({
                            text: 'Thêm quyền thành công',
                            type: 'success'
                        });
                    break;
                    case 0:
                        response.messages.list.map(value=> {
                            this.$notify({
                                text: value,
                                type: 'error'
                            })
                        });
                    break;
                }
            })
        },
        getPermissionOld() {
            UserRepository.permissionDetail(this.user_id, this.data.project_id)
            .then(response=> {
                this.data.permission_id = HelperIndex.arrayGet(response, 'data.usp_permission_id', null);
            })
        },
        getProject() {
            PermissionRepository.getListProject()
            .then(response=> {
                this.projects = response;
            })
        },
        getPermission() {
            PermissionRepository.getByProject(this.data.project_id)
            .then(response=> {
                this.permissions = response;
            })
        },
         getPermissionSelect() {
            PermissionRepository.getById(this.data.permission_id)
            .then(response=> {
               this.data.modules = response.modules_id.split(',');
            })
        },
        getModule() {
            PermissionRepository.getListModule(this.data.project_id)
            .then(response=> {
                this.modules = this.sortModuleByParent(response);
            })
        },
        sortModuleByParent(data) {
            let result = [];
            data.map(item=> {
                if(item.parent_id === 0) {
                    result.push(Object.assign({}, item, {child: []}));
                }
            })
            result.map(item=> {
                data.map(item_v2=> {
                    if(item.id === item_v2.parent_id) {
                        item.child.push(item_v2);
                    }
                })
            })
            return result;
        }
    }
}
</script>