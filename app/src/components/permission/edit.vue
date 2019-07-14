<template>
	<div id="permission-edit" class="modal modal_sc1">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <!-- Modal Header -->
	            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
	                <h4 class="modal-title">Câp nhật quyền</h4>
	            </div>
	            <!-- Modal body -->
	            <div class="modal-body">
	                <div class="form-group">
	                    <label for="">Tên:</label>
	                    <input type="text" v-model="data.name" class="form-control">
	                </div>
                    <div class="form-group">
                        <label for="">Dự án:</label>
                        <select class="form-control" v-model="data.project_id">
                            <option value="null" disabled="">-- Chọn dự án --</option>
                            <option v-for="item in projects" :value="item.id">{{ item.name }}</option>
                        </select>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-6" v-for="item in modules">
                            <label>{{ item.name }}</label>
                            <span class="help-block" style="cursor: pointer;" v-for="item in item.child" @click="addModule(item.id)" >
                                <i :class="{fa: true, 'fa-circle-o': !data.modules.includes(item.id), 'fa-dot-circle-o': data.modules.includes(item.id)}"></i>
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
import PermissionRepository from '@/repositories/PermissionRepository'

export default {
    data: ()=> ({
        data: {
            project_id: null, 
            name: null,
            modules: []
        },
        projects: [],
        modules: []
    }),
    props: {
        id: {
            type: Number,
        }
    },
    watch: {
        'data.project_id': function(value) {
            if(value !== null) {
                this.getModule();
            }
        },
        id: function (value) {
            if(value !== 0) {
                this.getPermission();
            }
        }
    },
    created() {
        this.getProject();
    },
    methods: {
        submit() {
        	PermissionRepository.update(this.id, Object.assign({}, this.data, {modules_id: this.data.modules.join(',')}))
            .then(response=> {
                switch(response.status) {
                    case 1: 
                        this.resetForm();
                        $(this.$el).find('.close-modal').click();
                        this.$emit('reload');
                        this.$notify({
                            text: 'Cập nhật quyền thành công',
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
        resetForm() {
            this.data.project_id = null;
            this.data.modules = [];
            this.data.name = null;
            this.$emit('update:id', 0);
        },
        getProject() {
            PermissionRepository.getListProject()
            .then(response=> {
                this.projects = response;
            })
        },
        getModule() {
            PermissionRepository.getListModule(this.data.project_id)
            .then(response=> {
                this.modules = this.sortModuleByParent(response);
            })
        },
        addModule(value) {
            if(this.data.modules.includes(value)) {
                this.data.modules.splice(this.data.modules.indexOf(value), 1);
            } else {
                this.data.modules.push(value);
            }
        },
        getPermission() {
            PermissionRepository.getById(this.id)
            .then(response=> {
                this.data.project_id = response.project.id;
                this.data.name = response.title;
                response.modules.map(item=> {
                    this.data.modules.push(parseInt(item.id));
                })
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